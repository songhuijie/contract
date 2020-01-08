<?php

namespace App\Http\Controllers\Admin;

use App\Models\Breach;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BreachController extends Controller
{

    public $breach;
    public function __construct(Breach $breach)
    {
        $this->breach = $breach;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.breach.index');
    }


    /**
     * ajax 请求列表数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request){
        $param = $request->all();
        $breach = $this->breach->getBreach($param);
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
        return view('admin.breach.addBreach');
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
        $data = $request->all();
        $data['register_time'] = strtotime($data['register_time']);
        $data['release_time'] = strtotime($data['release_time']);
        $int = $this->breach->insert($data);
        if (!$int) return ajaxError('添加失败' );
        return ajaxSuccess();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Breach  $breach
     * @return \Illuminate\Http\Response
     */
    public function show(Breach $breach)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Breach  $breach
     * @return \Illuminate\Http\Response
     */
    public function edit(Breach $breach)
    {
        //

        return view('admin.breach.addBreach',compact('breach'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Breach  $breach
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Breach $breach)
    {
        //
        $all = $request->all();

        $all['register_time'] = strtotime($all['register_time']);
        $all['release_time'] = strtotime($all['release_time']);
        $int = $this->breach->where('id',$breach->id)->update($all);
        if (!$int) return ajaxError('添加失败' );
        return ajaxSuccess();
    }

    /**
     * Remove the specified resource from storage.
     * @param Breach $breach
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Breach $breach)
    {
        //
        $int = $breach->delete();
        if (!$int) return ajaxError('添加失败' );
        return ajaxSuccess();
    }
}
