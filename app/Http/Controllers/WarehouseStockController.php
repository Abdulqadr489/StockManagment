<?php

namespace App\Http\Controllers;

use App\Models\WarehouseStock;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        WarehouseStock::all();

        return response()->json([
            'message' => 'WarehouseStocks retrieved successfully',
            'data' => WarehouseStock::all(),
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validate([
                'item_id' => 'required|integer|exists:items,id',
                'quantity' => 'required|integer',
            ]);

            $branch = WarehouseStock::create($validatedData);

            DB::commit();

            return response()->json([
                'message' => 'WarehouseStock created successfully',
                'data' => $branch,
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
    public function show(WarehouseStock $warehouseStock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WarehouseStock $warehouseStock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WarehouseStock $warehouse_stock)
    {
        try{
            DB::beginTransaction();
            $validatedData = $request->validate([
              'item_id' => 'required|integer|exists:items,id',
                'quantity' => 'required|integer',
            ]);
            $warehouse_stock->update($validatedData);
            DB::commit();
            return response()->json([
                'message' => 'WarehouseStock updated successfully',
                'data' => $warehouse_stock,
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
    public function destroy(WarehouseStock $warehouse_stock)
    {
        try{
            DB::beginTransaction();
            $warehouse_stock->delete();
            DB::commit();
            return response()->json([
                'message' => 'WarehouseStock deleted successfully',
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
