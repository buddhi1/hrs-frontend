<?php

class UserTableSeeder extends Seeder
{

public function run()
{


   DB::table('users')->delete();
   User::create(array(
       'name' => 'ash',
       'password' => Hash::make('pass'),
       'permission_id' => 1,
   ));
}
}

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UserTableSeeder');
	}

}
