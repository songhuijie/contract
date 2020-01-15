        

<?php $__env->startSection("content"); ?>
    <div id="wrapper" style="margin-top:20px;">
        <div id="page-wrapper">
            <form class="layui-form" >

                <div class="layui-form-item">
                    <label class="layui-form-label">模板名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" required  lay-verify="required"  placeholder="请输入模板名称" autocomplete="off" class="layui-input" value="<?php if(!empty($template)): ?><?php echo e($template->title); ?><?php endif; ?>">
                    </div>
                </div>


                <div class="layui-form-item">
                    <label class="layui-form-label">排序 (0最小-99最大)</label>
                    <div class="layui-input-block">
                        <input type="text" name="sort" required  lay-verify="required"  placeholder="请输入排序" autocomplete="off" class="layui-input" value="<?php if(!empty($template)): ?><?php echo e($template->sort); ?><?php endif; ?>">
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">模板内容:</label>
                    <div class="layui-input-block">
                        <textarea name="content" id="qaContent" lay-verify="content"><?php if(!empty($template)): ?><?php echo e($template->content); ?> <?php endif; ?></textarea>
                    </div>
                </div>

                <?php if(!empty($template)): ?>
                    <input type="text" id="mold" hidden  value="edit" >
                    <input type="text" id="id" hidden value="<?php echo e($template->id); ?>" >
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
            var form = layui.form;

            var layedit = layui.layedit;
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

                    url = "/admin/template/"+$("#id").val();

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
                        url:"<?php echo e(url('admin/template')); ?>",
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

<?php echo $__env->make("admin.layout.modify", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\phpstudy_pro\WWW\contract\resources\views/admin/template/addTemplate.blade.php ENDPATH**/ ?>