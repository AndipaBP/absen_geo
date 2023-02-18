<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Officer;


class UserOfficerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $db_user = new User;
        $db_user->username = '123456789';
        $db_user->email = 'tes@gmail.com';
        $db_user->password = bcrypt('123456');
        $db_user->save();

        $db_officer = new Officer;
        $db_officer->users_id = $db_user->id;
        $db_officer->nik = $db_user->username;
        $db_officer->nama_lengkap = "Andipa Batara Putra";
        $db_officer->jabatan = "Programmer Newbie";
        $db_officer->no_hp = "0123456789";
        $db_officer->save();



        
    }
}
