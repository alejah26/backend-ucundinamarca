<?php

use Flynsarmy\CsvSeeder\CsvSeeder;
use Illuminate\Support\Facades\DB;

class InternationalCountrySeeder extends CsvSeeder
{
    public function __construct()
    {
        $this->table =  "international_countries";
        $this->insert_chunk_size = 1;
        $this->filename = base_path().'/database/seeds/csvs/data_paises.csv';
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::disableQueryLog();
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table($this->table)->truncate();
        $this->csv_delimiter = ';';
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        parent::run();
    }
}
