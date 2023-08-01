<?php

namespace Locomotif\Admin\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Locomotif\Admin\Models\Role;
use Locomotif\Designers\Models\Designer;
use Locomotif\Clients\Models\Clients;

class Users extends Model implements Authenticatable
{
   protected $fillable = ['name','email', 'password'];

   // Relationship with roles (Many-to-Many)
   public function roles()
   {
       return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
   }

   // Relationship with clients (One-to-One)
   public function client()
   {
       return $this->hasOne(Clients::class);
   }

   // Relationship with designers (One-to-One)
   public function designer()
   {
       return $this->hasOne(Designer::class, 'user_id');
   }

   public function getAuthIdentifierName()
    {
        // Return the name of the identifier column in your 'users' table
        return 'id';
    }

    public function getAuthIdentifier()
    {
        // Return the value of the identifier column for the current user
        return $this->id;
    }

    public function getAuthPassword()
    {
        // Return the hashed password for the current user
        return $this->password;
    }

    public function getRememberToken()
    {
        // Return the remember token value for the current user
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        // Set the remember token value for the current user
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        // Return the name of the remember token column in your 'users' table
        return 'remember_token';
    }
}
