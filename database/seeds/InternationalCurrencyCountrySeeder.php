<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InternationalCurrencyCountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $countryIdCo =  DB::table('international_countries')->where('iso', 'CO')->first()->id;
        $countryIdUs =  DB::table('international_countries')->where('iso', 'US')->first()->id;

        $rows = [
            [
                'currency' => 'PESOS COLOMBIANOS',
                'code' => 'COP',
                'symbol' => '$',
                'country_id' => $countryIdCo ,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'currency' => 'DOLAR USA',
                'code' => 'USD',
                'symbol' => '$',
                'country_id' => $countryIdUs ,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('international_currency_countries')->truncate();
        DB::table('international_currency_countries')->insert($rows);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
