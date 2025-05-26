<?php

namespace Modules\Database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Database\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
           [
               'username' =>"supersuper",
               'password' =>Hash::make("jasamedikaadadibandungjawabarat")
           ],
            [
                'username' =>"pendafatar",
                'password'=>Hash::make("jasamedikaadadibandungjawabarat")
            ],
            [
                'username' =>'dokter',
                'password'=>Hash::make("jasamedikaadadibandungjawabarat")
            ],
            [
                'username' =>'perawat',
                'password'=>Hash::make("jasamedikaadadibandungjawabarat")
            ],
            [
                'username' =>'apoteker',
                'password'=>Hash::make("jasamedikaadadibandungjawabarat")
            ]
        ];
        foreach ($datas as $data){
            User::create($data);
        }
    }
}
