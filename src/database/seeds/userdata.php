<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class userdata extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('userdata')->insert([
            'name' => "admin",
            'username' => "admin",
            'password' => bcrypt('admin'),
            'level' => "admin",
        ]);
        DB::table('userdata')->insert([
            'name' => "dokter",
            'username' => "dokter",
            'password' => bcrypt('dokter'),
            'level' => "dokter",
        ]);
        DB::table('userdata')->insert([
            'name' => "apoteker",
            'username' => "apoteker",
            'password' => bcrypt('apoteker'),
            'level' => "apoteker",
        ]);

        $level = ['dokter','apoteker','pasien'];
        
        $randname = ['Mochammad','Zayyan','Ramadhan','Budi','Yono','Ahmad','Susi','Emilia','Rosa'];
        $randname2 = ['Sulis','Mawar','Fajar','Olive','Madun','Joko','Jaya','Kiki','Wendi'];

        
        for ($i=1; $i <= 20 ; $i++) { 
            $is_divorced=false;
            $name1 = $randname;
            $name2 = $randname2;
            if ($i%2==0) {
                $is_divorced=true;
                $name1 = $randname2;
                $name2 = $randname;
            }
            $getname = $name1[rand(0,8)]." ".$name2[rand(0,8)];
            $getuname = str_replace(" ","",$getname);
            DB::table('userdata')->insert([
                'name' => $getname,
                'username' => $getuname,
                'level' => $level[rand(0,2)],
            ]);
        }
    }
}
