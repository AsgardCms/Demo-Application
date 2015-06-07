<?php namespace Modules\Reset\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Setting\Repositories\SettingRepository;

class DemoSettingSeeder extends Seeder
{
    /**
     * @var SettingRepository
     */
    private $setting;

    public function __construct(SettingRepository $setting)
    {
        $this->setting = $setting;
    }

    public function run()
    {
        Model::unguard();

        $data = [
            'core::site-name' => 'AsgardCms-Demo',
        ];

        $this->setting->createOrUpdate($data);
    }
}
