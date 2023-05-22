<?php

namespace Locomotif\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Locomotif\Admin\Models\Role;
use Locomotif\Designer\Models\Designer;
use Locomotif\Clients\Models\Clients;

class Users extends Model
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
       return $this->hasOne(Designer::class);
   }
}
