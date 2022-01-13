<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\ItemHistory;
use App\Models\Item;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalMember = Member::count();
        $totalTransaction = Transaction::count();
        $totalSupplier = Supplier::count();
        $totalItem = Item::count();


        $label_line = ['Transaction In', 'Transaction Out'];
        $data_line = [];

        foreach($label_line as $key => $value){
                $data_line[$key]['label'] = $label_line[$key];
                $data_line[$key]['backgroundColor'] = $key == 0 ? 'rgba(60,141,188,0.9)' : 'rgba(210, 214, 222, 1)';
                $data_line[$key]['borderColor'] = $key == 0 ? 'rgba(60,141,188,0.8)' : 'rgba(210, 214, 222, 1)';
                $data_month = [];

                foreach(range(1,12) as $month) {
                        if($key == 0 ){
                        $data_month[] = Transaction::select(ItemHistory::raw("count(*) as total"))
                                ->join('item_histories', 'item_histories.transaction_id', 'transactions.id')
                                ->where('status', 'in')
                                ->whereMonth('item_histories.created_at', $month)
                                ->first()->total;
                        } else {
                        $data_month[] = Transaction::select(ItemHistory::raw("count(*) as total"))
                                ->join('item_histories', 'item_histories.transaction_id', 'transactions.id')
                                ->where('status', 'out')
                                ->whereMonth('item_histories.created_at', $month)
                                ->first()->total;       
                        }
                        
                }
                $data_line[$key]['data'] = $data_month;
        }
        return view('home', compact('totalMember', 'totalSupplier', 'totalTransaction', 'totalItem', 'data_line'));
    }
}
