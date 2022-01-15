<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class CountryController extends Controller
{
    public function index()
    {
        try {
            $result = ["status" => "success"];
            $countries = Country::all()->toArray();
            $result["data"] = array_reverse($countries);
        } catch (\Exception $e) {
            $result["status"] = "error";
            $result["error"] = $e->getMessage();
        }
        return $result;
    }

    public function indexAll() {
        try {
            $result = ["status" => "success"];
            $countries =  Country::all()->toArray();
            $cities =  City::all()->toArray();
            $locations = Location::all()->toArray();
            $result["data"] = collect([
                array_reverse($countries),
                array_reverse($cities),
                array_reverse($locations)
            ]);
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
            Country::create($atributes);
        } catch (\Exception $e) {
            $result["status"] = "error";
            $result["error"] = $e->getMessage();
        }
        return $result;
    }

    public function txt() {
        try {
            $content = "";
            $countries = Country::all();
            foreach ($countries as $country) {
                $cities = City::where('country_id', $country->id)->get();
                $content = "{$content}Country: {$country->name};\n";
                foreach ($cities as $city) {
                    $content = "{$content}City: {$city->name};\n";
                    $locations = Location::where('city_id', $city->id)->get();
                    foreach ($locations as $location) {
                        $content = "{$content}Location: {$location->name};\n";
                    }
                }
                $content = "{$content}\n";
            }
            Storage::disk('local')->put('file.txt', $content);
        } catch (\Exception $e) {
            $result["status"] = "error";
            $result["error"] = $e->getMessage();
        }
        return $result['data'] = Storage::download('file.txt');
    }
}
