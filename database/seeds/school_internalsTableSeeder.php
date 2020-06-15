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
    	DB::table('school_internals')->insert(['name' => 'Adi',
    		'email' => 'Adi5249@gmail.com',
    		'phone' => '081286949930',
    		'password' => Hash::make('Adi123'),
    		'role_id' =>'1',
            'created_at' => new \DateTime('now'),
            'updated_at' => new \DateTime('now')

    ]);

        
    }
}
