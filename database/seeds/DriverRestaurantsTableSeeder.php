<?php

use Illuminate\Database\Seeder;

class DriverRestaurantsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('driver_restaurants')->delete();
        
        \DB::table('driver_restaurants')->insert(array (
            0 => 
            array (
                'user_id' => 22,
                'restaurant_id' => 1,
            ),
            1 => 
            array (
                'user_id' => 22,
                'restaurant_id' => 2,
            ),
            2 => 
            array (
                'user_id' => 22,
                'restaurant_id' => 3,
            ),
            3 => 
            array (
                'user_id' => 22,
                'restaurant_id' => 4,
            ),
        ));
        
        
    }
}