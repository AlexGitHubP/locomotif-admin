<?php

namespace Locomotif\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RootUserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $uid = DB::table('users')->insertGetId([
            'name' => 'Locomotif',
            'email' => 'locomotif@locomotif.ro',
            'password' => Hash::make('dFk#9x)@;C[{@]xVen@9xRn#L'),
        ]);

        setUserRole('administrator', $uid);
    }
}
