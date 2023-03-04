<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function deleteElements(Request $request)
    {
        $ids = $request->input('ids');
        $model = $request->input('model');
        if ($ids && $model) {
            $modelClass = new $model;
            $modelClass->destroy($ids);
        }
    }

}
