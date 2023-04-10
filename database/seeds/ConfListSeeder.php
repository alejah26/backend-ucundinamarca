<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfListSeeder extends Seeder
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
                'code' => 'TIPDOC',
                'name' => 'Tipos de Documento',
                'description' => 'Tipos de Documento de personas o empresas',
                'status' => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'code' => 'TIPCUE',
                'name' => 'Tipo de Cuenta',
                'description' => 'Tipos de Cuenta de los usuarios (Persona o Empresa)',
                'status' => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        DB::table('conf_lists')->truncate();

        DB::table('conf_lists')->insert($rows);

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

    }
}