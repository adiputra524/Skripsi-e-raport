<?php

use Illuminate\Database\Seeder;
use \Cake\Auth\DefaultPasswordHasher;
class school_internalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    
    {
    	DB::table('school_internals')->insert(['name' => 'adi',
    		'email' => 'adiputra5249@gmail.com',
    		'phone' => '081286949930',
    		'password' => Hash::make('localhostPassword'),
    		'role_id' =>'1'

    ]);

        
    }
}
