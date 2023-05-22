<?php

namespace Locomotif\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Locomotif\Admin\Models\Users;

class Role extends Model
{
    protected $fillable = ['name'];

    // Relationship with users (Many-to-Many)
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
    }
}


?>