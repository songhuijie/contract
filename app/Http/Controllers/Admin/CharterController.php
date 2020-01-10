<?php

namespace App\Http\Controllers\Admin;

use App\Models\Charter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CharterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.charter.index');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Charter  $charter
     * @return \Illuminate\Http\Response
     */
    public function show(Charter $charter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Charter  $charter
     * @return \Illuminate\Http\Response
     */
    public function edit(Charter $charter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Charter  $charter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Charter $charter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Charter  $charter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Charter $charter)
    {
        //
    }
}
