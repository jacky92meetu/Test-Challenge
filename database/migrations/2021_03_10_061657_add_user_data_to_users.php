<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AddUserDataToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('users')->insert(
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
                'user_type' => 'admin',
                'api_token' => 'testing_token_admin'
            ]
        );
        DB::table('users')->insert(
            [
                'name' => 'User',
                'email' => 'user@user.com',
                'password' => Hash::make('password'),
                'user_type' => 'user',
                'api_token' => 'testing_token_user'
            ]
        );
        DB::table('users')->insert(
            [
                'name' => 'Manager',
                'email' => 'manager@manager.com',
                'password' => Hash::make('password'),
                'user_type' => 'manager',
                'api_token' => 'testing_token_manager'
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
