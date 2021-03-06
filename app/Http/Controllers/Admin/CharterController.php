<?php

namespace App\Http\Controllers\Admin;

use App\Models\Charter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CharterController extends Controller
{

    public $charter;
    public function __construct(Charter $charter)
    {
        $this->charter = $charter;
    }

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
     * ajax 请求列表数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request){
        $param = $request->all();
        $breach = $this->charter->getCharter($param);
        return ajaxSuccess($breach['data'], $breach['count']);
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
