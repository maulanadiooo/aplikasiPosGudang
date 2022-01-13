<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class MemberController extends Controller
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
        return view('member');
    }

    public function api()
    {
        $members = Member::all();
        $datatables = datatables()->of($members)->addIndexColumn();

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
    
       $this->validate($request,[
            'name' => ['required'],
            'email' => ['required','email:rfc,dns'],
            'phone_number' => ['required', 'max:14', 'min:10'],
            'address' => ['required'],
            'gender' => ['required', 'max:1']
       ]);
        $member = new Member;

        $member->name = $request->name;
        $member->gender = $request->gender;
        $member->address = $request->address;
        $member->phone_number = filter_phone($request->phone_number);
        $member->email = $request->email;
        $member->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        $this->validate($request,[
            'name' => ['required'],
            'email' => ['required','email:rfc,dns'],
            'phone_number' => ['required', 'max:14', 'min:10'],
            'address' => ['required'],
            'gender' => ['required', 'max:1']
       ]);

       $member->name = $request->name;
       $member->gender = $request->gender;
        $member->address = $request->address;
        $member->phone_number = filter_phone($request->phone_number);
        $member->email = $request->email;
        $member->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
       $member->delete();
    }
}
