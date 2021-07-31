<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class PersonController extends Controller
{

    public function get()
    {
        try {
            $person = DB::select("CAll get_person()");
            return response()->json($person,200);

        } catch (\Throwable $th) {
            return response()->json($th,500);
        }
        

    }
    public function create(Request $request )
    {
        $request->validate([
            'document_number' =>'required|unique:person,document_number',
         ]);
       try  {
        $person =  DB::insert("call update_person (:document_number_p,:first_name_p,:second_name_p,:last_name_p,:address_p,:telephone_p,:city_p,:dates_p)" ,[
            "document_number_p" =>$request->document_number,
            "first_name_p"=> $request->first_name,
            "second_name_p"=>$request->second_name,
            "last_name_p" => $request->last_name,
            "address_p"=> $request->address,
            "telephone_p"=>$request->telephone,
            "city_p" =>$request->city,
            "dates_p"=>Carbon::now()->timezone('America/Bogota')
        ]); 
        return response()->json(200);

       } catch (\Throwable $th) {
           return response()->json($th,500);
       }
    }
    public function update(Request $request)
    {

        $request->validate([
            'document_number' =>'unique:person,document_number,'.$request->id,
         ]);
        try {
            $person =  DB::insert("call update_person (:id_p,:document_number_p,:first_name_p,:second_name_p,:last_name_p,:address_p,:telephone_p,:city_p,:dates_p)" ,[
                "id_p" =>$request->id,
                "document_number_p" =>$request->document_number,
                "first_name_p"=> $request->first_name,
                "second_name_p"=>$request->second_name,
                "last_name_p" => $request->last_name,
                "address_p"=> $request->address,
                "telephone_p"=>$request->telephone,
                "city_p" =>$request->city,
                "dates_p"=>Carbon::now()->timezone('America/Bogota')

            ]); 
            return response()->json(200);
        } catch (\Throwable $th) {
            return response()->json($th,500);

        }
    }
    public function destroy(Request $request)
    {
        try {
            $person =  DB::delete("call delete_person (:id_p)" ,[
                "id_p" =>  $request->id
            ]); 
            return response()->json(200);
        } catch (\Throwable $th) {
            return response()->json($th,500);
        }
    }
}
