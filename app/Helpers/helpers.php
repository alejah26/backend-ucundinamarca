<?php


namespace App\Helpers;

use App\Models\Configurations\ConfList;
use App\Models\Configurations\ConfListDetail;

use Carbon\Carbon;

/**
 * Retorna un registro de una lista por su código o Id
 *
 * @param $value
 * @param $column
 * @return array
 */
if (!function_exists('get_list')) {
    function get_list($value, $column = 'code'): array
    {
        $list = ConfList::where($column, '=', $value)
            ->get(['id', 'code', 'name']);

        return $list->toArray()[0];
    }
}

/**
 * Retorna un detalle de las lista por el codigo del padre
 *
 * @param $listCode
 * @return mixed
 */

if (!function_exists('get_list_details')) {
    function get_list_details($listCode)
    {

        $listParent = ConfList::where('code', '=', $listCode)->first();

        if (!$listParent) {

            return response()->json([
                'message' => 'Lista ' . $listCode . ' no existe!'
            ], 400);
        }

        $detail = ConfListDetail::where('list_id', '=', $listParent->id)->where('status', true)->get();

        if ($detail->count() == 0) {

            return response()->json([
                'message' => 'El detalle de la lista no existe!'
            ], 400);
        }

        return $detail->toArray();
    }
}

/**
 * Retorna un detalle especifico
 *
 * @param $parentCode
 * @param $code
 * @return object
 */

if (!function_exists('get_list_detail_item')) {
    function get_list_detail_item($parentCode, $code)
    {
        $listParent = ConfList::where('code', '=', $parentCode)->first();

        if (!$listParent) {

            return response()->json([
                'message' => 'Lista ' . $parentCode . ' no existe!'
            ], 400);
        }

        $detail = ConfListDetail::where('list_id', '=', $listParent->id)->where('code', $code)->first();

        if (is_null($detail)) {
            return response()->json([
                'message' => 'El detalle de la lista no existe!'
            ], 400);
        }

        return $detail;
    }
}
