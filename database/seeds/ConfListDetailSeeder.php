<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfListDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listId = App\Helpers\get_list('TIPDOC')['id'];

        $rowsTypeDocs = [
            [
                'list_id' => $listId ,
                'code' => 'RC',
                'name' => 'Registro civil de nacimiento',
                'status' => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'list_id' => $listId ,
                'code' => 'CC',
                'name' => 'Cédula de ciudadanía',
                'status' => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'list_id' => $listId ,
                'code' => 'NI',
                'name' => 'Nit',
                'status' => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'list_id' => $listId ,
                'code' => 'TI',
                'name' => 'Tarjeta de Identidad',
                'status' => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'list_id' => $listId ,
                'code' => 'CE',
                'name' => 'Cédula de Extranjería',
                'status' => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'list_id' => $listId ,
                'code' => 'PA',
                'name' => 'Pasaporte',
                'status' => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'list_id' => $listId ,
                'code' => 'CD',
                'name' => 'Carnet diplomática',
                'status' => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'list_id' => $listId ,
                'code' => 'AI',
                'name' => 'Adulto sin identificación',
                'status' => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'list_id' => $listId ,
                'code' => 'SI',
                'name' => 'Salvoconducto',
                'status' => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'list_id' => $listId ,
                'code' => 'PE',
                'name' => 'Permiso especial de permanencia',
                'status' => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        $listId = App\Helpers\get_list('TIPCUE')['id'];

        $rowsTypeAccounts = [
            [
                'list_id' => $listId ,
                'code' => 'EMP',
                'name' => 'Empresa',
                'status' => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'list_id' => $listId ,
                'code' => 'PER',
                'name' => 'Persona',
                'status' => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        DB::table('conf_list_details')->truncate();

        DB::table('conf_list_details')->insert($rowsTypeDocs);
        DB::table('conf_list_details')->insert($rowsTypeAccounts);

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}