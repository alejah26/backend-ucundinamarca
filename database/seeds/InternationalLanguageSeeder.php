<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InternationalLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [
                'code' => 'es',
                'name' => 'Spanish',
                'native_name' => 'Español',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'code' => 'en',
                'name' => 'English',
                'native_name' => 'Inglés',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        DB::table('international_languages')->truncate();

        DB::table('international_languages')->insert($rows);
    }
}
