<?php

namespace App\Http\Controllers\Admin;

use App\Models\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TemplateController extends Controller
{

    public $template;
    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.template.index');
    }

    /**
     * ajax 请求列表数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request){
        $param = $request->all();
        $breach = $this->template->getTemplate($param);
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
        return view('admin.template.addTemplate');
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
        unset($data['file']);
        $int = $this->template->insert($data);
        if (!$int) return ajaxError('添加失败' );
        return ajaxSuccess();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function show(Template $template)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function edit(Template $template)
    {
        //
        return view('admin.template.addTemplate',compact('template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Template $template)
    {
        //

        $all = $request->all();
        unset($all['file']);
        $int = $template->update($all);
        if (!$int) return ajaxError('更新失败' );
        return ajaxSuccess();
    }

    /**
     * Remove the specified resource from storage.
     * @param Template $template
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Template $template)
    {
        //
        $int = $template->delete();
        if (!$int) return ajaxError('删除失败' );
        return ajaxSuccess();
    }
}
