<?php namespace Modules\User\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class ResetDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call("Modules\\Reset\\Database\\Seeders\\DemoUserSeeder");
        $this->call("Modules\\Reset\\Database\\Seeders\\DemoSettingSeeder");
    }
}
