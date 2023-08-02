<?php

namespace Locomotif\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Locomotif\Admin\Models\Accounts;

class AccountsCompany extends Model{
    protected $table = 'account_company_infos';

    public function accounts(){
        return $this->belongsTo(Accounts::class, 'id', 'account_id');
    }
}