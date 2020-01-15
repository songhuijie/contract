<?php

namespace App\Http\Controllers\Admin;

use App\Events\Notice;
use App\Libraries\Lib_config;
use App\Models\Certification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CertificationController extends Controller
{

    public $certification;
    public function __construct(Certification $certification)
    {
        $this->certification = $certification;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.certification.index');
    }


    /**
     * ajax 请求列表数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request){
        $param = $request->all();
        $breach = $this->certification->getCertification($param);
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
        return view('admin.certification.addCertification');

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
     * @param  \App\Models\Certification  $certification
     * @return \Illuminate\Http\Response
     */
    public function show(Certification $certification)
    {
        //
        $Information = $certification->Information;
        return view('admin.certification.info',compact('Information'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Certification  $certification
     * @return \Illuminate\Http\Response
     */
    public function edit(Certification $certification)
    {
        //
        return view('admin.certification.addCertification',compact('certification'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Certification  $certification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Certification $certification)
    {
        //
        $all = $request->all();

        if($all['status'] == 1){
            event(new Notice($certification->user_id,[],Lib_config::NOTIFICATION_TYPE_IDENTITY));
        }
        $int = $certification->update($all);

        if (!$int) return ajaxError('更新失败' );
        return ajaxSuccess();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Certification  $certification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Certification $certification)
    {
        //
    }
}
