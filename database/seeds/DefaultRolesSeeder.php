<?php

use Illuminate\Database\Seeder;

use Fedn\Models\Role;

class DefaultRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::unguard(true);
        Role::create(['id'=>1, 'title'=>'Admin', 'description'=>'系统管理员']);
        Role::create(['id'=>2, 'title'=>'Webmaster', 'description'=>'网站管理员']);
        Role::create(['id'=>3, 'title'=>'Moderator', 'description'=>'内容管理员']);
        Role::create(['id'=>4, 'title'=>'Contributor', 'description'=>'投稿者']);
        Role::create(['id'=>5, 'title'=>'Subscriber', 'description'=>'订阅者']);
    }
}
