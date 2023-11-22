<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run():void
    {
$admins = [
    [
        'name'=>'su su',
        'email' => 'su@gmail.com',
        'phone'=>'09334342432',
        'address'=>'Yangon',
        'role'=>'admin',
        'gender'=>'female',
        'password'=>Hash::make('11111111')
    ],
    [
        'name'=>'aye aye',
        'email' => 'aye@gmail.com',
        'phone'=>'09334344332',
        'address'=>'Yangon',
        'role'=>'admin',
        'gender'=>'female',
        'password'=>Hash::make('11111111')
    ],


    ];

    foreach($admins as $admin){
        User::create($admin);
    }




    }
}
