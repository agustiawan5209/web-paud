<?php

namespace App\Http\Middleware;

use App\Models\User;
use Inertia\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();
        if(Auth::check()){
            $user = User::find(Auth::user()->id);
        }
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user,
                'role' => auth()->hasUser() ? auth()->user()->getRoleNames()->toArray() : [],
            ],
            'message'=> fn () => $request->session()->get('message'),
        ];
    }
}
