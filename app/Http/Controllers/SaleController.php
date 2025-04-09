<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Sale;
use App\Models\SaleItem;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Sale::all();

        return response()->json([
            'message' => 'Sales retrieved successfully',
            'data' => Sale::all(),
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
                'customer_id' => 'required|integer|exists:customers,id',
                'branch_id' => 'required|integer|exists:branches,id',
                'sale_date' => 'required|date',
                'total_amount' => 'required|numeric|min:0',
                'items.*.item_id' => 'required|integer|exists:items,id',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.unit_price' => 'required|numeric|min:0',
                'items.*.discount' => 'required|numeric|min:0',
            ]);

            $Sale = Sale::create([
                'customer_id' => $validatedData['customer_id'],
                'branch_id' => $validatedData['branch_id'],
                'sale_date' => $validatedData['sale_date'],
                'total_amount' => $validatedData['total_amount'],
            ]);

            foreach($validatedData['items'] as $item) {
                   SaleItem::create([
                    'sale_id' => $Sale->id,
                    'item_id' => $item['item_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'discount' => $item['discount'],
                ]);


            }
            DB::commit();

            return response()->json([
                'message' => 'Branch created successfully',
                'data' => $Sale,
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
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        try{
            DB::beginTransaction();
            $validatedData = $request->validate([
                'customer_id' => 'required|integer|exists:customers,id',
                'branch_id' => 'required|integer|exists:branches,id',
                'sale_date' => 'required|date',
                'total_amount' => 'required|numeric|min:0',
            ]);
            $sale->update($validatedData);
            DB::commit();
            return response()->json([
                'message' => 'sale updated successfully',
                'data' => $sale,
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
    public function destroy(Sale $sale)
    {
        try{
            DB::beginTransaction();
            $sale->delete();
            DB::commit();
            return response()->json([
                'message' => 'Branch deleted successfully',
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
