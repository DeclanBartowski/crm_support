<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arUsers = [
            [
                'name' => 'admin',
                'password' => Hash::make('12345678'),
                'is_admin' => 1,
            ],
            [
                'name' => 'user',
                'password' => Hash::make('12345678'),
            ],
        ];
        foreach ($arUsers as $arUser) {
            User::updateOrCreate(['name' => $arUser['name']],$arUser);
        }
    }
}
