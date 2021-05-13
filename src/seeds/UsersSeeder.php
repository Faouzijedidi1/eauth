<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if(config()->get('auth::auth.enable_roles')){
            $roles = array();
            foreach(config()->get('auth::auth.seed_roles') as $role) {
                $roles[] = array(
                    'name' => $role['name'],
                    'description' => $role['description']
                );
            }
            DB::table('roles')->insert($roles);
        }

        $users = array();
    	foreach(config()->get('auth::auth.seed_users') as $user) {
			$users[] = array(
				'name' => $user['name'],
				'email' => $user['email'],
				'password' => bcrypt($user['password'])
			);
     	}
    	DB::table('users')->insert($users);

        if(config()->get('auth::auth.enable_roles')){
            $user_roles = array();
            foreach(config()->get('auth::auth.seed_users') as $user) {
                foreach ($user["roles"] as $role) {
                    $user_roles[] = array(
                        'role_id' => (DB::table('roles')->select('id')->where('name',$role)->pluck('id'))[0],
                        'user_id' => (DB::table('users')->select('id')->where('name',$user['name'])->pluck('id'))[0]
                    );
                }
            }
            DB::table('role_user')->insert($user_roles);
        }
    }
}
