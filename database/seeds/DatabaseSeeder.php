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
        $this->call('ProjectsSeeder');
        $this->call('ClaimSeeder');
	}

}

class StatusTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('status')->delete();

        App\Status::create([
            'code' =>'N',
            'title'=>'Новый',
            'sort'=>'1',
        ]);

        App\Status::create([
            'code' =>'D',
            'title'=>'Проект в работе',
            'sort'=>'2',
        ]);

        App\Status::create([
            'code' =>'C',
            'title'=>'Завершен',
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
            'password'=>'password',
            'name'=>'Антон Алексеев',
            'role_id'=>1
        ]);

        App\User::create([
            'email' => 'operator@goodline.ru',
            'password'=>'operator',
            'name'=>'Тест Оператор',
            'phone'=>'88800',
            'role_id'=>2
        ]);


        App\User::create([
            'email' => 'manager@goodline.ru',
            'password'=>'manager',
            'name'=>'Тест Менеджер',
            'phone'=>'89003332211',
            'role_id'=>3
        ]);

        App\User::create([
            'email' => 'client@goodline.ru',
            'password'=>'client',
            'name'=>'Тест Клиент',
            'phone'=>'89003332200',
            'role_id'=>4
        ]);

        App\User::create([
            'email' => 'client2@goodline.ru',
            'password'=>'client2',
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

        App\StatusClaim::create([
            'code' =>'P',
            'title'=>'Обработанная',
            'sort'=>'2',
        ]);

        App\StatusClaim::create([
            'code' =>'С',
            'title'=>'Выполнена',
            'sort'=>'3',
        ]);

        App\StatusClaim::create([
            'code' =>'Z',
            'title'=>'Отменена',
            'sort'=>'4',
        ]);

    }
}

class ProjectsSeeder extends Seeder{
    public function run()
    {
        DB::table('projects')->delete();
        $faker = Faker\Factory::create();
        for($k=0;$k<20;$k++)
        {
            App\Project::create([

                'status'=>"N",
                'text'=>$faker->paragraph(4),
                'title'=>$faker->name(),
                'manager_id'=>3,
                'client_id'=>$faker->numberBetween(4,5)
            ]);
        }


    }
}


class ClaimSeeder extends Seeder{
    public function run()
    {
        DB::table('claims')->delete();
        $faker = Faker\Factory::create();
        for($k=0;$k<20;$k++)
        {
            App\Claim::create([

                'status'=>"N",
                'text'=>$faker->paragraph(4),
                'name'=>$faker->name,
                'phone'=>$faker->phoneNumber,
                'operator_id'=>3,
                'project_id'=>$faker->numberBetween(1,20)
            ]);
        }


    }
}