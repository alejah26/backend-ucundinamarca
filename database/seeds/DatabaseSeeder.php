<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ConfListSeeder::class);
        $this->call(ConfListDetailSeeder::class);
       /* $this->call(InternationalCountrySeeder::class); //CSV
        $this->call(InternationalLanguageSeeder::class);
        $this->call(InternationalRegionSeeder::class);
        $this->call(InternationalMunicipalitySeeder::class); //CSV
        $this->call(InternationalCurrencyCountrySeeder::class);*/
    }
}