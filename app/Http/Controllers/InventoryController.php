<?php

namespace App\Http\Controllers;

use App\Inventory;
use Illuminate\Http\Request;
use App\Unit;

class InventoryController extends Controller
{
     public function __construct(){
     $this->middleware(['auth']);
     }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($property_id, $unit_id)
    {
        $unit = Unit::findOrFail($unit_id);

        $inventories = Inventory::where('unit_id_foreign', $unit_id)->get();

       return view('webapp.inventories.create', compact('unit', 'inventories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'item' => 'required',
            'remarks' => 'required',
            'quantity' => 'required',
        ]);

        Inventory::create([
            'unit_id_foreign' => $request->unit_id_foreign,
            'item' => $request->item, 
            'remarks' => $request->remarks,
            'quantity' => $request->quantity,
            'current_inventory' => $request->quantity
        ]);

        return back()->with('success', 'Inventory is added successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $property_id, $unit_id)
    {

        return $request->all();
        
      $this->validate($request, [
            'current_inventory' => 'required',
        ]);

        Inventory::where('inventory_id', $request->item_id)
        ->update([
            'current_inventory' => $request->current_inventory
        ]);

        return redirect('/property/'.$property_id.'/room/'.$unit_id.'/#inventory')->with('success', 'Inventory is updated successfully!');
   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}
