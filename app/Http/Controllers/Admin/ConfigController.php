<?php

namespace App\Http\Controllers\Admin;

use App\Libraries\Lib_make;
use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfigController extends Controller
{

    public $config;
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        return view('admin.config.index');

    }

    /**
     * ajax 请求列表数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request){
        $param = $request->all();
        $config = $this->config->getConfig($param);
        return ajaxSuccess($config['data'], $config['count']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.config.addConfig');
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
        $int = $this->config->insert($data);
        Lib_make::getConfig(false);
        if (!$int) return ajaxError('添加失败' );
        return ajaxSuccess();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Config  $config
     * @return \Illuminate\Http\Response
     */
    public function show(Config $config)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Config  $config
     * @return \Illuminate\Http\Response
     */
    public function edit(Config $config)
    {
        //
        return view('admin.config.addConfig',compact('config'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Config  $config
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Config $config)
    {
        //
        $all = $request->all();


        if($all['key'] == 'rotation'){
            unset($all['file']);
            $all['value'] = json_encode($all['value']);
        }
        if($all['key'] == 'attorney_instructions'){
            $all['value'] = json_encode(explode("\n",$all['value']));
        }
        $int = $config->update($all);
        Lib_make::getConfig(false);
        if (!$int) return ajaxError('添加失败' );
        return ajaxSuccess();
    }

    /**
     * Remove the specified resource from storage.
     * @param Config $config
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Config $config)
    {
        //
        $int = $config->delete();
        if (!$int) return ajaxError('添加失败' );
        return ajaxSuccess();
    }
}
