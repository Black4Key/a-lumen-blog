<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    public const SUBSCRIPTION_TYPE_FREE = 'free';
    public const SUBSCRIPTION_TYPE_PREMIUM = 'premium';

    protected $table = 'users';
    //protected $primaryKey = 'id'; //solo se diverso dal default
    //public $incrementing = true;   //$keyType  $timestamps

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'picture',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'api_token',
    ];

    protected $guarded = [
        'id', 'subscription',
    ];

    public function posts(){
        return $this->hasMany(Post::class);
    }
}
