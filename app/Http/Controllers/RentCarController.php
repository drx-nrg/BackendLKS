<?php

namespace App\Http\Controllers;

use App\Models\rent_car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RentCarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rent_cars = rent_car::all();

        if(!$rent_cars){
            return response()->json([
                "message" => "Get all rent cars failed"
            ], 400);
        }

        return response()->json([
            "message" => "Get all rent cars success",
            "rent_cars" => $rent_cars
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "name" => "required",
            "no_car" => "required",
            "location" => "required",
            "capacity" => "required|integer",
            "slug" => "required",
            "description" => "required",
            "rental_price" => "required|integer"
        ]);

        if($validation->fails()){
            return response()->json([
                "message" => "Invalid Field",
                "errors" => $validation->errors()
            ], 422);
        }

        $rent_car = rent_car::create($request->all());

        return response()->json([
            "message" => "Create new rent car success",
            "rent_car" => $rent_car
        ], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\rent_car  $rent_car
     * @return \Illuminate\Http\Response
     */
    public function show(rent_car $rent_car)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\rent_car  $rent_car
     * @return \Illuminate\Http\Response
     */
    public function edit(rent_car $rent_car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\rent_car  $rent_car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, rent_car $rent_car)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\rent_car  $rent_car
     * @return \Illuminate\Http\Response
     */
    public function destroy(rent_car $rent_car)
    {
        //
    }
}
