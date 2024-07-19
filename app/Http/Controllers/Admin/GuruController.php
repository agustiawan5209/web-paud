<?php

namespace App\Http\Controllers\Admin;

use App\Models\Guru;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Posyandu;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\StoreGuruRequest;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\UpdateGuruRequest;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableName = 'gurus'; // Ganti dengan nama tabel yang Anda inginkan
        // dd(Guru::with(['posyandus']));
        // $columns=DB::getSchemaBuilder()->getColumnListing($tableName);
        $columns[] = 'id';
        $columns[] = 'nama';
        $columns[] = 'nomor_telepon';
        $columns[] = 'alamat';
        // dd($columns);
        return Inertia::render('Admin/Guru/Index', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['posyandus_id','remember_token', 'password', 'email_verified_at', 'created_at', 'updated_at', 'user_id'])),
            'data' => Guru::filter(Request::only('search', 'order'))->with(['user'])
            ->paginate(10),
            'can' => [
                'add' => Auth::user()->can('add guru'),
                'edit' => Auth::user()->can('edit guru'),
                'show' => Auth::user()->can('show guru'),
                'delete' => Auth::user()->can('delete guru'),
                'reset' => Auth::user()->can('reset guru'),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $columns_guru = DB::getSchemaBuilder()->getColumnListing('gurus');
        $columns_user = DB::getSchemaBuilder()->getColumnListing('users');
        $columns_hide = ['remember_token', 'email_verified_at', 'created_at', 'updated_at', 'user_id', 'id', 'name'];
        $colums = array_diff(array_merge($columns_guru, $columns_user), $columns_hide);
        $colums['2'] =  [
            'name' => 'jabatan',
            'value' => Role::whereNot('name', 'Guru')->get(),
        ];
        // dd($colums);
        return Inertia::render('Admin/Guru/Form', [
            'jabatan' => Role::whereNot('name', 'Admin')->get(),
            'colums' => array_values($colums),
            'linkCreate' => 'Guru.store',

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGuruRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
            'phone' => $request->no_telpon,

        ]);
        $role = Role::findByName('Guru');
        if ($role) {
            $user->assignRole($role); // Assign 'user' role to the user
            $user->givePermissionTo([
                'add nilai',
                'edit nilai',
                'delete nilai',
                'show nilai',
            ]);
        }


        event(new Registered($user));

        Guru::create([
            'user_id' => $user->id,
            'nama' => $user->name,
            'alamat' => $request->alamat,
        ]);
        return redirect()->route('Guru.index')->with('message', 'Data Guru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Guru $guru)
    {
        Request::validate([
            'slug'=> 'required|exists:gurus,id',
        ]);
        return Inertia::render('Admin/Guru/Show', [
            'guru' => $guru->find(Request::input('slug')),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guru $guru)
    {
        Request::validate([
            'slug'=> 'required|exists:gurus,id',
        ]);
        return Inertia::render('Admin/Guru/Edit', [
            'guru' => $guru->with(['user'])->find(Request::input('slug')),
            'jabatan' => Role::whereNot('name', 'Orang Tua')->get(),

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGuruRequest $request, Guru $guru)
    {

        $guru = Guru::find(Request::input('slug'));

        $user = User::find($guru->user_id);
        $user->update([
            'name' => $request->name,
            // 'username' => $request->username,
            // 'email' => $request->email,
            // 'password' => Hash::make($request->password),
            // 'remember_token' => Str::random(60),
            'phone' => $request->no_telpon,
        ]);

        $guru->update([
            'nama' => $request->name,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('Guru.index')->with('message', 'Data Guru berhasil Di Edit!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guru $guru)
    {
        $guru = Guru::with(['user'])->find(Request::input('slug'));
        $user_id = $guru->user->id;
        User::find($user_id)->delete();
        return redirect()->route('Guru.index')->with('message', 'Data Guru berhasil Di Hapus!');
    }



   /**
     * Display the specified resource.
     */
    public function resetpassword(Guru $guru)
    {

        return Inertia::render('Admin/Guru/UpdatePassword', [
            'user' => User::find(Request::input('slug')),
        ]);
    }
    public function resetpasswordUpdate(Guru $guru)
    {

        Request::validate([
            'password' => 'required|string|confirmed|min:8',
            'password_confirmation' => 'required',
        ]);


        $user = User::find(Request::input('slug'));
        $user->update([
            'remember_token' => Str::random(60),
            'password' => Hash::make(Request::input('password')),
        ]);
        return redirect()->route('Guru.index')->with('message', 'Password Guru berhasil Di Ubah!');

    }
}
