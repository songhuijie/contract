@extends("admin.layout.modify")

@section("content")
	<form class="layui-form layui-form-pane" style="width:80%;">
		<div class="layui-form-item">
			<label class="layui-form-label">用户组名</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="name" value="{{$role->name}}" lay-verify="required" placeholder="请输入用户组名称">
			</div>
		</div>
		<input type="hidden" name="id" value="{{$role->id}}">
		<div class="layui-form-item">
			<div class="layui-input-block">
				<button class="layui-btn" lay-submit type="button" lay-filter="editRole">立即提交</button>
				<button type="reset" class="layui-btn layui-btn-primary">重置</button>
		    </div>
		</div>
	</form>
	<script type="text/javascript" src="{{asset('/xianshangke/modul/rule/editRole.js')}}"></script>
@endsection

@section("js")

@endsection
