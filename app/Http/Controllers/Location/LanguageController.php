<?php

namespace App\Http\Controllers\Location;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
    public function translations(Request $request)
    {
        $data = [
                 'auth' => trans('auth'),
                 'web' => trans('web'),
                 'messages' => trans('messages')
        ];

        return   response()->json($data);
    }
}
