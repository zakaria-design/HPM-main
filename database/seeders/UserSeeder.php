<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        User::create([
            'name'=>'mas direktur',
            'user_id'=>'HPM-0001',
            'email'=>'direktur@gmail.com',
            'alamat'=>'Bogor',
            'no_hp'=>'083871919823',
            'role'=>'direktur',
            'password' => Hash::make('123456789'),
        ]);
        User::create([
            'name'=>'mas admin',
            'user_id'=>'HPM-0002',
            'email'=>'admin@gmail.com',
            'alamat'=>'Bogor',
            'no_hp'=>'083823919823',
            'role'=>'admin',
            'password' => Hash::make('123456789'),
        ]);
        User::create([
            'name'=>'mas manager',
            'user_id'=>'HPM-0003',
            'email'=>'manager@gmail.com',
            'alamat'=>'Bogor',
            'no_hp'=>'083871919863',
            'role'=>'manager',
            'password' => Hash::make('123456789'),
        ]);
        User::create([
            'name'=>'mas karyawan',
            'user_id'=>'HPM-0004',
            'email'=>'karyawan@gmail.com',
            'alamat'=>'Bogor',
            'no_hp'=>'083871919823',
            'role'=>'karyawan',
            'password' => Hash::make('123456789'),
        ]);
    }
}
