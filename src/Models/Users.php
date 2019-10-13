<?php

namespace Locomotif\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
   protected $fillable = ['name','email', 'password'];
}
