<?php namespace Modules\Reset\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\User\Repositories\UserRepository;

class DemoUserSeeder extends Seeder
{
    /**
     * @var UserRepository
     */
    private $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function run()
    {
        Model::unguard();

        $this->user->createWithRoles([
            'email' => 'john@doe.com',
            'password' => 'demo',
            'first_name' => 'John',
            'last_name' => 'Doe',
        ], [1], true);
    }
}
