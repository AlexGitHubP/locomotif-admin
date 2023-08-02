<?php

namespace Locomotif\Admin\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Locomotif\Admin\Models\Users;
use Locomotif\Admin\Models\AccountsAddresses;

class Accounts extends Model{
    protected $table = 'accounts';

    public function user(){
        return $this->belongsTo(Users::class);
    }

    public function addresses(){
        return $this->hasMany(AccountsAddresses::class, 'account_id');

    }
}
