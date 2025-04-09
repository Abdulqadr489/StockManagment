<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
      /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Transfer::all();

        return response()->json([
            'message' => 'transfer retrieved successfully',
            'data' => Transfer::all(),
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validate([
                'brunch_id' => 'required|integer|exists:branches,id',
                'transfer_date' => 'required|date',
                'status' => 'required|string|in:pending,completed,cancelled',
            ]);

            $transfer = Transfer::create($validatedData);

            DB::commit();

            return response()->json([
                'message' => 'Transfer created successfully',
                'data' => $transfer,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Error creating branch',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(Transfer $branch)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transfer $branch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transfer $transfer)
    {
        try{
            DB::beginTransaction();
            $validatedData = $request->validate([
                'brunch_id' => 'required|integer|exists:branches,id',
                'transfer_date' => 'required|date',
                'status' => 'required|string|in:pending,completed,cancelled',
            ]);
            $transfer->update($validatedData);
            DB::commit();
            return response()->json([
                'message' => 'Branch updated successfully',
                'data' => $transfer,
            ], 200);

        }catch(ErrorException $e)
        {
            return response()->json([
                'error' => 'An error occurred while processing your request.',
                'message' => $e->getMessage(),
            ], 500);
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transfer $transfer)
    {
        try{
            DB::beginTransaction();
            $transfer->delete();
            DB::commit();
            return response()->json([
                'message' => 'transfer deleted successfully',
            ], 200);

        }catch(ErrorException $e)
        {
            return response()->json([
                'error' => 'An error occurred while processing your request.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
