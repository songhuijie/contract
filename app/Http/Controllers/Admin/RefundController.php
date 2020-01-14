<?php

namespace App\Http\Controllers\Admin;

use App\Models\Refund;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RefundController extends Controller
{

    public $refund;
    public function __construct(Refund $refund)
    {
        $this->refund = $refund;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.refund.index');
    }

    /**
     * ajax 请求列表数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request){
        $param = $request->all();
        $breach = $this->refund->getRefund($param);
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
     * @param  \App\Models\Refund  $refund
     * @return \Illuminate\Http\Response
     */
    public function show(Refund $refund)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Refund  $refund
     * @return \Illuminate\Http\Response
     */
    public function edit(Refund $refund)
    {
        //
        return view('admin.refund.addRefund',compact('refund'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Refund  $refund
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Refund $refund)
    {
        //
        $all = $request->all();
        $int = $refund->update($all);
        if (!$int) return ajaxError('添加失败' );
        return ajaxSuccess();
    }

    /**
     * Remove the specified resource from storage.
     * @param Refund $refund
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Refund $refund)
    {
        //
        $int = $refund->delete();
        if (!$int) return ajaxError('添加失败' );
        return ajaxSuccess();
    }
}
