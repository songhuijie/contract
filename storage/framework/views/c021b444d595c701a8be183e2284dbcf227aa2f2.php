<?php $__env->startSection("content"); ?>
    <div id="wrapper" style="margin-top:20px;">
        <div id="page-wrapper">
            <form class="layui-form" >

                <div class="layui-form-item">
                    <label class="layui-form-label">被执行人名</label>
                    <div class="layui-input-block">
                        <input type="text" name="executor_name" required  lay-verify="required"  placeholder="请输入被执行人名" autocomplete="off" class="layui-input" value="<?php if(!empty($breach)): ?><?php echo e($breach->executor_name); ?><?php endif; ?>">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">性别</label>
                    <div class="layui-input-block">

                        <?php if(!empty($breach)): ?>
                            <input type="radio" name="sex" value="1" title="男" <?php if(!empty($breach)): ?><?php echo e($breach->sex == 1 ? 'checked':''); ?><?php endif; ?>>
                            <input type="radio" name="sex" value="2" title="女" <?php if(!empty($breach)): ?><?php echo e($breach->sex == 2 ? 'checked':''); ?><?php endif; ?>>
                        <?php else: ?>
                            <input type="radio" name="sex" value="1" title="男" checked>
                            <input type="radio" name="sex" value="2" title="女" >
                        <?php endif; ?>


                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">年龄</label>
                    <div class="layui-input-block">
                        <input type="text" name="age" required  lay-verify="required"  placeholder="请输入年龄" autocomplete="off" class="layui-input" value="<?php if(!empty($breach)): ?><?php echo e($breach->age); ?><?php endif; ?>">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">身份证号</label>
                    <div class="layui-input-block">
                        <input type="text" name="ID_card" required  lay-verify="required"  placeholder="请输入身份证号" autocomplete="off" class="layui-input" value="<?php if(!empty($breach)): ?><?php echo e($breach->ID_card); ?><?php endif; ?>">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">省份</label>
                    <div class="layui-input-block">
                        <input type="text" name="province" required  lay-verify="required"  placeholder="请输入省份" autocomplete="off" class="layui-input" value="<?php if(!empty($breach)): ?><?php echo e($breach->province); ?><?php endif; ?>">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">执行法院</label>
                    <div class="layui-input-block">
                        <input type="text" name="executor_court" required  lay-verify="required"  placeholder="请输入执行法院" autocomplete="off" class="layui-input" value="<?php if(!empty($breach)): ?><?php echo e($breach->executor_court); ?><?php endif; ?>">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">案号</label>
                    <div class="layui-input-block">
                        <input type="text" name="case_number" required  lay-verify="required"  placeholder="请输入案号" autocomplete="off" class="layui-input" value="<?php if(!empty($breach)): ?><?php echo e($breach->case_number); ?><?php endif; ?>">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">立案时间</label>
                    <div class="layui-input-block">
                        <input type="text" name="register_time" id="register_time" required  lay-verify="required"  placeholder="请输入立案时间" autocomplete="off" class="layui-input" value="<?php if(!empty($breach)): ?><?php echo e($breach->register_time); ?><?php endif; ?>">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">执行依据文号</label>
                    <div class="layui-input-block">
                        <input type="text" name="symbol_number" required  lay-verify="required"  placeholder="请输入执行依据文号" autocomplete="off" class="layui-input" value="<?php if(!empty($breach)): ?><?php echo e($breach->symbol_number); ?><?php endif; ?>">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">做出执行依据单位</label>
                    <div class="layui-input-block">
                        <input type="text" name="execution_unit" required  lay-verify="required"  placeholder="请输入做出执行依据单位" autocomplete="off" class="layui-input" value="<?php if(!empty($breach)): ?><?php echo e($breach->execution_unit); ?><?php endif; ?>">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">生效法律文书确定的义务</label>
                    <div class="layui-input-block">
                        <input type="text" name="obligation" required  lay-verify="required"  placeholder="请输入生效法律文书确定的义务" autocomplete="off" class="layui-input" value="<?php if(!empty($breach)): ?><?php echo e($breach->obligation); ?><?php endif; ?>">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">被执行人的履行情况</label>
                    <div class="layui-input-block">
                        <input type="text" name="performance" required  lay-verify="required"  placeholder="请输入被执行人的履行情况" autocomplete="off" class="layui-input" value="<?php if(!empty($breach)): ?><?php echo e($breach->performance); ?><?php endif; ?>">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">失信执行人行为具体情况</label>
                    <div class="layui-input-block">
                        <input type="text" name="circumstances" required  lay-verify="required"  placeholder="请输入失信执行人行为具体情况" autocomplete="off" class="layui-input" value="<?php if(!empty($breach)): ?><?php echo e($breach->circumstances); ?><?php endif; ?>">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">发布时间</label>
                    <div class="layui-input-block">
                        <input type="text" name="release_time"  id="release_time" required  lay-verify="required"  placeholder="请输入发布时间" autocomplete="off" class="layui-input" value="<?php if(!empty($breach)): ?><?php echo e($breach->release_time); ?><?php endif; ?>">
                    </div>
                </div>




                <?php if(!empty($breach)): ?>
                    <input type="text" id="mold" hidden  value="edit" >
                    <input type="text" id="id" hidden value="<?php echo e($breach->id); ?>" >
                <?php endif; ?>

                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit="" lay-filter="formDemo">立即提交</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </form>


        </div>


    </div>

    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });

        layui.use(['util','form','laydate', 'laypage', 'layer', 'table', 'carousel', 'upload', 'element', 'slider','layedit'], function(){
            var laydate = layui.laydate //日期
                ,laypage = layui.laypage //分页
                ,layer = layui.layer //弹层
                ,table = layui.table //表格
                ,carousel = layui.carousel //轮播
                ,upload = layui.upload //上传
                ,element = layui.element //元素操作
                ,slider = layui.slider //滑块
            var layedit = layui.layedit;
            var form = layui.form;

            laydate.render({
                elem: '#register_time' //指定元素
                ,type: 'datetime'
            });
            laydate.render({
                elem: '#release_time' //指定元素
                ,type: 'datetime'
            });
            layedit.set({
                uploadImage: {
                    url: '/layer/upload' //接口url
                    ,type: 'post' //默认post
                    ,multiple: true
                }
            });
            var editIndex = layedit.build('qaContent'); // 建立编辑器

            form.verify({
                content:function () {
                    layedit.sync(editIndex);
                }
            });
//执行实例 多图上传
            upload.render({
                elem: '#test2'
                ,method: 'post'
                ,multiple: true //是否允许多文件上传。设置 true即可开启。不支持ie8/9
                ,url: '<?php echo e(URL("file/img")); ?>' //上传接口
                ,done: function(index, upload){
                    //获取当前触发上传的元素，一般用于 elem 绑定 class 的情况，注意：此乃 layui 2.1.0 新增
                    if(index.code!=0){
                        layer.msg("上传错误",{icon:5});
                    }else{
                        layer.msg("上传成功",{icon:6});
                        img="../"+index.data;
                        $("#img2").append('<img src="'+img+'" name="img[]" width="20%"><input type="text" value="'+index.data+'" hidden name="rotation[]">')
                    }
                }
            });
            //监听提交
            form.on('submit(formDemo)', function(data){

                var date=data.field;

                if(date.key==""||date.describe==""||date.value==""){
                    layer.msg("不能为空,请填写完整",{icon:5});return false;
                }

                if($("#mold").val()!=undefined){
                    // date.id=$("#id").val();

                    url = "/admin/breach/"+$("#id").val();

                    $.ajax({
                        data:date,
                        type: 'put',
                        datatype:"json",
                        url:url,
                        success:function(res){
                            console.log(res);
                            if(res.code==0){
                                parent.layer.msg(res.msg);
                                setTimeout(function(){
                                    parent.layer.closeAll();
                                    parent.location.reload();
                                },1000)
                            }else{
                                parent.layer.msg(res.msg);
                            }

                        }
                    });
                }else{
                    $.ajax({
                        data:date,
                        type:"post",
                        datatype:"json",
                        url:"<?php echo e(url('admin/breach')); ?>",
                        success:function(res){
                            console.log(res);
                            if(res.code==0){
                                parent.layer.msg(res.msg);
                                setTimeout(function(){
                                    parent.layer.closeAll();
                                    parent.location.reload();
                                },1000)
                            }else{
                                parent.layer.msg(res.msg);
                            }

                        }
                    });
                }

                return false;
            });
            //底部信息
            // var footerTpl = lay('#footer')[0].innerHTML;
            // lay('#footer').html(layui.laytpl(footerTpl).render({}))
            // .removeClass('layui-hide');
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("admin.layout.modify", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\phpstudy_pro\WWW\contract\resources\views/admin/breach/addBreach.blade.php ENDPATH**/ ?>