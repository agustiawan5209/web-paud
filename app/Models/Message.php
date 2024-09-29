<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'recipient_id',  'nama_pengirim','nama_penerima', 'message', 'is_read'];



    protected $dates = ['created_at', 'updated_at'];


    protected $appends = [
        'human_format',
    ];
    // Accessor untuk formatted created_at
    public function humanFormat() : Attribute
    {
        $result = Carbon::parse($this->created_at)->diffForHumans();
        return new Attribute(
            get:fn()=> $result
        );
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}
