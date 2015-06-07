<?php namespace Modules\Reset\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Core\Http\Controllers\BasePublicController;

class ResetController extends BasePublicController
{
    public function reset()
    {
        Artisan::call('cache:clear');

        DB::raw('SET foreign_key_checks = 0;');
        Schema::drop('users_groups');
        Schema::drop('throttle');
        Schema::drop('groups');
        Schema::drop('migrations');
        Schema::drop('users');
        Artisan::call('module:migrate-reset');

        Artisan::call('cache:clear');

        Artisan::call('migrate');
        Artisan::call('cache:clear');

        Artisan::call('module:migrate');
        Artisan::call('cache:clear');

        Artisan::call('module:seed', ['module' => 'Reset']);
        Artisan::call('cache:clear');

        return true;
    }
}
