<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;

class AssingRoleToUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:assign {user : User id} {role : Role id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign a role to a user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $userId = $this->argument('user');
        $roleId = $this->argument('role');

        $user = User::findOrFail($userId);
        $role = Role::findOrFail($roleId);

        $user->attachRole($role);

        $this->info("Role \"{$role->name}\" is assigned to \"{$user->first_name} {$user->second_name}\"");
    }
}
