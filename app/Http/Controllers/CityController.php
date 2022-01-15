<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        try {
            $result = ["status" => "success"];
            $cities =  City::all()->toArray();
            $result["data"] = array_reverse($cities);
        } catch (\Exception $e) {
            $result["status"] = "error";
            $result["error"] = $e->getMessage();
        }
        return $result;
    }

    public function store(Request $request)
    {
        try {
            $result = ["status" => "success"];
            $atributes = $request->all();
            City::create($atributes);
            $cities =  City::all()->toArray();
            $result["data"] = array_reverse($cities);
        } catch (\Exception $e) {
            $result["status"] = "error";
            $result["error"] = $e->getMessage();
        }
        return $result;
    }
}
