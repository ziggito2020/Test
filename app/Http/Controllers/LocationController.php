<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        try {
            $result = ["status" => "success"];
            $locations = Location::all()->toArray();
            $result["data"] = array_reverse($locations);
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
            Location::create($atributes);
            $locations = Location::all()->toArray();
            $result["data"] = array_reverse($locations);
        } catch (\Exception $e) {
            $result["status"] = "error";
            $result["error"] = $e->getMessage();
        }
        return $result;
    }
}
