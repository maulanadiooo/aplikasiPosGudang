<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Supplier;
use App\Models\ItemHistory;
use App\Models\Member;
use App\Models\Item;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::orderBy('qty', 'desc')->get();
        $suppliers = Supplier::all();
        $members = Member::all();
        return view('transaction', compact('items', 'suppliers', 'members'));
    }
    public function api(Request $request)
    {
        if($request->transaction){
            $transactions = Transaction::select('transactions.*', 'item_histories.member_id as member_id', 'items.id as itemId', 'items.name as itemName', 'suppliers.name as supplierName', 'suppliers.id as supplierId', 'item_histories.status as historiesStatus')
            ->join('items', 'items.id', 'transactions.item_id')
            ->join('suppliers', 'suppliers.id', 'items.supplier_id')
            ->join('item_histories', 'item_histories.transaction_id', 'transactions.id')
            ->where('item_histories.status', $request->transaction)
            ->get();
        } else {
            $transactions = Transaction::select('transactions.*', 'item_histories.member_id as member_id', 'items.id as itemId', 'items.name as itemName', 'suppliers.name as supplierName', 'suppliers.id as supplierId', 'item_histories.status as historiesStatus')
            ->join('items', 'items.id', 'transactions.item_id')
            ->join('suppliers', 'suppliers.id', 'items.supplier_id')
            ->join('item_histories', 'item_histories.transaction_id', 'transactions.id')
            ->get();
        }
        

        foreach($transactions as $transaction){
            if($transaction->historiesStatus == 'out'){
                $txP = Member::select('name')
                    ->where('id', $transaction->member_id)
                    ->get();
                $price = Item::select('price_member')
                    ->where('id', $transaction->itemId)
                    ->pluck('price_member');
            } else {
                $txP = Supplier::select('name')
                    ->where('id', $transaction->supplierId)
                    ->get();
                $price = Item::select('price_supplier')
                    ->where('id', $transaction->itemId)
                    ->pluck('price_supplier');
            }
            $transaction->memberOrSupplier = $txP[0]->name;
            $transaction->qty = format_angka($transaction->qty);
            $transaction->totalPrice = format_IDR($price[0] * $transaction->qty);
            $transaction->price = format_IDR($price[0]);
            if($transaction->historiesStatus == 'in'){
                $transaction->historiesStatus = 'Transaction In';
            } else {
                $transaction->historiesStatus = 'Transaction Out';
            }
        }

        $datatables = datatables()->of($transactions)->addIndexColumn();

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
        $this->validate($request , [
            'item_id' => ['required', 'integer'],
            'qty' => ['required', 'integer']
        ]);
        
        $item = Item::where('id', $request->item_id)->first();
        $itemHistory = new ItemHistory;
        $transaction = new Transaction;
        if($request->member_id != 0 && $item->qty < $request->qty){
        
            exit();
        }
        $transaction->item_id = $request->item_id;
        $transaction->qty = $request->qty;
        if($transaction->save()){
        
            
            if($request->member_id == 0){
                $itemHistory->status = 'in';
                $itemHistory->supplier_id = $item->supplier_id; 

                $updateQty = $item->qty + $request->qty;
                $item->where('id', $request->item_id)->update(['qty' => $updateQty]);
            } else {
                $itemHistory->status = 'out';
                $itemHistory->member_id = $request->member_id; 

                $updateQty = $item->qty - $request->qty;
                $item->where('id', $request->item_id)->update(['qty' => $updateQty]);
            }
            $itemHistory->transaction_id = $transaction->id;
            $itemHistory->save();
            return redirect('transactions');
            
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        
        $this->validate($request , [
            'item_id' => ['required', 'integer'],
            'qty' => ['required', 'integer']
        ]);

        $item = Item::where('id', $transaction->item_id)->first();

        if($transaction->item_id == $request->item_id ){
            if($request->member_id == 0){
                $diffQty = $request->qty - $transaction->qty;
                $addQty = $item->qty + $diffQty;
                $item->where('id', $transaction->item_id)->update(['qty' => $addQty]);
            } else {
                $diffQty = $request->qty - $transaction->qty;
                $addQty = $item->qty - $diffQty;
                $item->where('id', $transaction->item_id)->update(['qty' => $addQty]);
            }
            $transaction->qty = $request->qty;
            $transaction->update();
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $itemHistory = ItemHistory::where('transaction_id', $transaction->id)->first();
        $item = Item::where('id', $transaction->item_id)->first();
        if($itemHistory->status == 'in'){   
            $updateQty = $item->qty - $transaction->qty;
            $item->qty = $updateQty;
            $item->update();
        } else {
            $updateQty = $item->qty + $transaction->qty;
            $item->qty = $updateQty;
            $item->update();
        }
        $itemHistory->delete();
        $transaction->delete();
    }
}
