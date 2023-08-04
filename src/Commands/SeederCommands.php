<?php

namespace Locomotif\Admin\Commands;

use Illuminate\Console\Command;

class SeederCommands extends Command{

    protected $signature = 'locomotif:seed';
    protected $description = 'Seeds default tables for Locomotif CMS';

    public function handle()
    {
        $this->call('db:seed', ['--class'=>'Locomotif\\Admin\\Database\\Seeders\\RolesTableSeeder']);
        $this->call('db:seed', ['--class'=>'Locomotif\\Admin\\Database\\Seeders\\RootUserSeed']);
        $this->call('db:seed', ['--class'=>'Locomotif\\Admin\\Database\\Seeders\\LocalitatiTableSeeder']);
        
        // Your custom command logic here
        $this->info('Seeders for Locomotif CMS done!');
    }
}


?>