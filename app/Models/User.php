<?php

namespace Fedn\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Fedn\Models\User
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','nickname'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Create a new user.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = []) {
        parent::__construct($attributes);

        if(isset($this->attributes['api_token']) === false || empty($this->attributes['api_token'])) {
            $this->attributes['api_token'] = str_random(60);
        }
    }
    public function articles() {
        return $this->hasMany(Article::class);
    }

    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    public function metas() {
        return $this->hasMany(UserMeta::class);
    }

    public function hasRole($role) {

        if(is_int($role)) {
            $roles = array_pluck($this->roles->toArray(), 'id');
            return in_array($role, $roles);
        } else {
            $roles = array_pluck($this->roles->toArray(), 'title');
            return in_array($role, $roles);
        }
    }

    public function inRoles($roles) {
        $result = false;
        foreach($roles as $role) {
            if ($this->hasRole($role)) {
                $result = true;
                break;
            }
        }
        return $result;
    }
}
