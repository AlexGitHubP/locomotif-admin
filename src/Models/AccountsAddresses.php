<?php

namespace Locomotif\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Locomotif\Admin\Models\Accounts;

class AccountsAddresses extends Model{
    protected $table = 'account_addresses';
    
    public function accounts(){
        return $this->belongsTo(Accounts::class, 'id', 'account_id');
    }
}
