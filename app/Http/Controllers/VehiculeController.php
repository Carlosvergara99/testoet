<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class VehiculeController extends Controller
{
    public function get()
    {
        try {
             $vehicule = DB::select("CAll get_vehicle()");
            return response()->json($vehicule,200);

        } catch (\Throwable $th) {
            return response()->json($th,500);
        }
    }
    
    public function create(Request $request)
    {
        $request->validate([
            'license_plate' =>'required|unique:vehicle,license_plate',
         ]);
         try {
            $person =   DB::insert("call create_vehicle (:license_plate_v,:color_v,:brand_v,:vehicle_type_v,:driver_id_v,:owner_id_v,:dates_v)" ,[
                "license_plate_v" =>$request->license_plate,
                "color_v"=> $request->color,
                "brand_v"=>$request->brand,
                "vehicle_type_v" => $request->vehicle_type,
                "driver_id_v"=> $request->driver_id,
                "owner_id_v"=>$request->owner_id,
                "dates_v"=>Carbon::now()->timezone('America/Bogota')
            ]); 
            return response()->json(200);
         } catch (\Throwable $th) {
            return response()->json($th,500);
         }
    }
    public function update(Request $request)
    {
        $request->validate([
            'license_plate' =>'unique:vehicle,license_plate,'.$request->id
         ]);

        try {
            $vehicle= DB::insert("call update_vehicle (:id_v,:license_plate_v,:color_v,:brand_v,:vehicle_type_v,:driver_id_v,:owner_id_v,:dates_v)" ,[
                "id_v"=>$request->id,
                "license_plate_v" =>$request->license_plate,
                "color_v"=> $request->color,
                "brand_v"=>$request->brand,
                "vehicle_type_v" => $request->vehicle_type,
                "driver_id_v"=> $request->driver_id,
                "owner_id_v"=>$request->owner_id,
                "dates_v"=>Carbon::now()->timezone('America/Bogota')
            ]); 
            return response()->json(200);
         } catch (\Throwable $th) {
            return response()->json($th,500);
         }

    }
    public function destroy(Request $request)
    {
        try {
            $vehicle =  DB::delete("call delete_vehicle (:id_v)" ,[
                "id_v" =>  $request->id
            ]); 
            return response()->json(200);
        } catch (\Throwable $th) {
            return response()->json($th,500);

        }
    }
}
