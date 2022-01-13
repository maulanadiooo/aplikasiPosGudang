<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
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
        return view('supplier');
    }

    public function api()
    {
        $suppliers = Supplier::all();
        $datatables = datatables()->of($suppliers)->addIndexColumn();

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
            "address" => ['required'],
            "phone_number" => ['required', 'min:10', 'max:13'],
            "email" => ['required','email:rfc,dns']
        ]);

        $supplier = new Supplier;
         
         $supplier->name = $request->name;
         $supplier->address = $request->address;
         $supplier->phone_number = filter_phone($request->phone_number);
         $supplier->email = $request->email;
         $supplier->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $this->validate($request, [
            "name" => ['required'],
            "address" => ['required'],
            "phone_number" => ['required', 'min:10', 'max:13'],
            "email" => ['required','email:rfc,dns']
        ]);
         
         $supplier->name = $request->name;
         $supplier->address = $request->address;
         $supplier->phone_number = filter_phone($request->phone_number);
         $supplier->email = $request->email;
         $supplier->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
