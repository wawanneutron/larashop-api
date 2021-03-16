<?php

namespace App\Http\Controllers;

use App\City;
use App\Province;
use App\Http\Resources\Provinces as ProvincesResourceCollection;
use App\Http\Resources\Cities as CitiesResourceCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function provinces()
    {
        $provinces = Province::get();
        return new ProvincesResourceCollection($provinces);
    }

    public function cities()
    {
        $cities = City::get();
        return new CitiesResourceCollection($cities);
    }

    public function shipping(Request $request)
    {
        $user = Auth::user();
        $status = 'error';
        $message = '';
        $data = null;
        $code = 400;

        if ($user) {
            $this->validate($request, [
                'name' => 'required',
                'address' => 'required',
                'phone' => 'required',
                'province_id' => 'required',
                'city_id' => 'required'
            ]);
            $user->name = $request->name;
            $user->address = $request->address;
            $user->phone = $request->phone;
            $user->province_id = $request->province_id;
            $user->city_id = $request->city_id;
            if ($user->save()) {
                $status = 'success';
                $message = 'update shipping success';
                $code = 200;
                $data = $user->toArray();
            } else {
                $message = 'update shipping failed';
            }
        } else {
            $message = 'user not found';
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'code' => $code
        ]);
    }
}
