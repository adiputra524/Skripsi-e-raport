<?php

use Illuminate\Database\Seeder;
class tbl_studentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_students')->insert([
            'nama' => 'dina',
    		'nis' => '20015678093',
    		'email' => 'dina52424@gmail.com',
    		'password' => Hash::make('Alex123'),
    		'phone' => '08128319134',
    		'class_id' =>'2',
            'created_at' => new \DateTime('now'),
            'updated_at' => new \DateTime('now')


    ]);
    }
}
