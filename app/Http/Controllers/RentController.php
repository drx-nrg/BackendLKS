<?php

namespace App\Http\Controllers;

use App\Models\rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rents = rent::all();

        if(!$rents){
            return response()->json([
                "message" => "Get all failed"
            ], 400);
        }

        return response()->json([
            "message" => "Get all rent success",
            "rents" => $rents
        ]);
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
            "tenant" => "required",
            "no_car" => "required",
            "date_borrow" => "required|date",
            "date_return" => "required|date",
            "down_payment" => "required|integer",
            "discount" => "required|integer",
            "total" => "required|integer"
        ]);

        if($validation->fails())
        {
            return response()->json([
                "message" => "Invalid Field",
                "errors" => $validation->errors()
            ], 422);
        }

        $input = $request->all();
        $input["total"] = $request->down_payment - $request->discount;

        $rent = rent::create($input);

        return response()->json([
            "message" => "Create Rent Success",
            "rent" => $rent
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rent = rent::findorFail($id);

        if(!$rent){
            return response()->json([
                "message" => "Failed to get rent data"
            ], 400);
        }

        return response()->json([
            "message" => "Get rent data with $id success",
            "rent" => $rent
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function edit(rent $rent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            "tenant" => "required",
            "no_car" => "required",
            "date_borrow" => "required|date",
            "date_return" => "required|date",
            "down_payment" => "required|integer",
            "discount" => "required|integer",
            "total" => "required|integer"
        ]);

        if($validation->fails())
        {
            return response()->json([
                "message" => "Invalid Field",
                "errors" => $validation->errors()
            ], 422);
        }

        $rent = rent::where('id', $id)->firstorfail()->update($request->all());

        if(!$rent){
            return response()->json([
                "message" => "Failed Update Data"
            ]);
        }
        return response()->json([
            "message" => "Update rent data success",
            "rent" => $rent
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rent = rent::findOrFail($id)->delete();
        
        if(!$rent){
            return response()->json([
                "message" => "Rent not found"
            ], 422);
        }
        
        return response()->json([
            "message" => "Delete Rent Success",
            "rent" => $rent
        ]);
    }
}
