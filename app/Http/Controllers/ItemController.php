<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::all();

        return view('item', compact('suppliers'));
    }

    public function api()
    {
        $items = Item::with('supplier')->get();
        foreach ($items as  $item ){
            
            $item->qty = format_angka($item->qty);
            $item->price_members = $item->price_member;
            $item->price_suppliers = $item->price_supplier;
            $item->price_member = format_IDR($item->price_member);
            $item->price_supplier = format_IDR($item->price_supplier);
        }
        $datatables = datatables()->of($items)->addIndexColumn();



        return $datatables->make(true);
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
        $this->validate($request, [
            "name" => ['required'],
            "supplier_id" => ['required', 'integer'],
            "qty" => ['required', 'integer'],
            "price_supplier" => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            "price_member" => ['required', 'regex:/^\d+(\.\d{1,2})?$/']
        ]);

        Item::create($request->all());
        return redirect('items');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $this->validate($request, [
            "name" => ['required'],
            "supplier_id" => ['required', 'integer'],
            "qty" => ['required', 'integer'],
            "price_supplier" => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            "price_member" => ['required', 'regex:/^\d+(\.\d{1,2})?$/']
        ]);

        $item->update($request->all());
        return redirect('items');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();
    }
}
