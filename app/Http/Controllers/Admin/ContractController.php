<?php

namespace App\Http\Controllers\Admin;

use App\Libraries\Lib_make;
use App\Models\Contract;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContractController extends Controller
{


    public $contract;
    public function __construct(Contract $contract)
    {
        $this->contract = $contract;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.contract.index');
    }


    /**
     * ajax 请求列表数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request){
        $param = $request->all();
        $config = $this->contract->getContract($param);
        $user_list = Lib_make::getUserList();
        $template_list = Lib_make::getTemplate();

        foreach($config['data'] as $k=>&$v){

            $v['user_id'] = $user_list[$v['user_id']];
            if($v['specific_user_id'] == 0){
                $v['specific_user_id'] = '律师代写';
            }else{
                $v['specific_user_id'] = $user_list[$v['specific_user_id']];
            }
            if($v['template_id'] == 0){
                $v['template_id'] = '律师代写';
            }else{
                $v['template_id']= $template_list[$v['template_id']];
            }

        }
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
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function show(Contract $contract)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function edit(Contract $contract)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contract $contract)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contract $contract)
    {
        //
    }
}
