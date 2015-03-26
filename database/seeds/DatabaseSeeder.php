<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('UserTableSeeder');
        $this->call('RoleTableSeeder');
        $this->call('StatusTableSeeder');
        $this->call('StatusClaimTableSeeder');
	}

}

class StatusTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('status')->delete();

        App\Status::create([
            'code' =>'N',
            'title'=>'Новая',
            'sort'=>'1',
        ]);

        App\Status::create([
            'code' =>'D',
            'title'=>'Проект в работе',
            'sort'=>'2',
        ]);

        App\Status::create([
            'code' =>'C',
            'title'=>'Решена',
            'sort'=>'3',
        ]);

        App\Status::create([
            'code' =>'Z',
            'title'=>'Отменена',
            'sort'=>'4',
        ]);
    }
}

class RoleTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->delete();

        App\Role::create([
            'title'=>'Admin',
            'code'=>'admin',
            'description'=>'Администратор системы',
            'sort'=>'0',
            'visible'=>false,
        ]);

        App\Role::create([
            'title'=>'Оператор',
            'code'=>'operator',
            'description'=>'Оператор Call центра',
            'sort'=>'1',
            'visible'=>true,
        ]);

        App\Role::create([
            'title'=>'Менеджер',
            'code'=>'manager',
            'description'=>'Менеджер проекта',
            'sort'=>'2',
            'visible'=>true,
        ]);

        App\Role::create([
            'title'=>'Заказчик',
            'code'=>'client',
            'description'=>'Заказчик',
            'sort'=>'3',
            'visible'=>true,
        ]);
    }
}

class UserTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->delete();

        App\User::create([
            'email' => 'alexeev.sker@gmail.com',
            'password'=>bcrypt('password'),
            'name'=>'Антон Алексеев',
            'role_id'=>1
        ]);

        App\User::create([
            'email' => 'operator@goodline.ru',
            'password'=>bcrypt('operator'),
            'name'=>'Тест Оператор',
            'phone'=>'88800',
            'role_id'=>2
        ]);


        App\User::create([
            'email' => 'manager@goodline.ru',
            'password'=>bcrypt('manager'),
            'name'=>'Тест Менеджер',
            'phone'=>'89003332211',
            'role_id'=>3
        ]);

        App\User::create([
            'email' => 'client@goodline.ru',
            'password'=>bcrypt('client'),
            'name'=>'Тест Клиент',
            'phone'=>'89003332200',
            'role_id'=>4
        ]);

        App\User::create([
            'email' => 'client2@goodline.ru',
            'password'=>bcrypt('client2'),
            'name'=>'Тест Клиент2',
            'phone'=>'89003332200',
            'role_id'=>4
        ]);

    }
}


class StatusClaimTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('status_claim')->delete();

        App\StatusClaim::create([
            'code' =>'N',
            'title'=>'Новая',
            'sort'=>'1',
        ]);

    }
}
