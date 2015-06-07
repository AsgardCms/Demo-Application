<?php namespace Modules\Reset\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\User\Repositories\RoleRepository;
use Modules\User\Repositories\UserRepository;

class DemoUserSeeder extends Seeder
{
    /**
     * @var UserRepository
     */
    private $user;
    /**
     * @var RoleRepository
     */
    private $role;

    public function __construct(UserRepository $user, RoleRepository $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function run()
    {
        Model::unguard();

        $role = $this->role->findByName('Admin');

        $this->user->createWithRoles([
            'email' => 'john@doe.com',
            'password' => 'demo',
            'first_name' => 'John',
            'last_name' => 'Doe',
        ], [$role->id], true);
    }
}
