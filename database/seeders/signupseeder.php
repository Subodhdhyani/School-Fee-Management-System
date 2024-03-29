<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class signupseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $store = new User;
        $store->name = "Admin";
        $store->email = "admin@ethereal.edu.in";
        $store->password = Hash::make('admin@12345');
        $store->save();



    }
}
