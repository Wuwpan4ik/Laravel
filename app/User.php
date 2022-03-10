<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\LibraryConnect;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    protected function isRights($id) {
        $temp = LibraryConnect::where('user_to', '=', $id)->where('library_id', '=', Auth::user()->id)->get();
        if (!isset($temp[0]) and $id != Auth::user()->id and count($temp) == 0) {
            return True;
        }
        return False;
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'user_to', 'id');
    }
}
