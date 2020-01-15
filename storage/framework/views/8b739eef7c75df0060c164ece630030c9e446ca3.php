<!DOCTYPE html>
 <html>
 <head>
      <title>HTML5 Canvas画印章</title>
     <script src="https://www.jq22.com/jquery/jquery-2.1.1.js"></script>
     </head>
 <body>
     <lable style="display: inline-block;margin:50px;font-size: 18px;">印章文字:
     <input type="text" id="textname" style="height: 30px;width: 200px;" />
         <lable style="display: inline-block;margin:50px;font-size: 18px;">下方文字:
     <input type="text" id="textname2" style="height: 30px;width: 200px;" />
     </lable>
     <input type="button" id="changename" value="修改" />
     <div>
     <canvas id="canvas" width="400" height="400" style="margin-left: 130px;border: 1px solid #666666;"></canvas>
    </div>
 <script>
      // canvas绘制图像的原点是canvas画布的左上角
        var canvas = document.getElementById("canvas");
        var context = canvas.getContext('2d');

        $("body").on("click","#changename",function(){
                    drawText($("#textname").val(),$("#textname2").val());
                    EvenCompEllipse(context1, canvas1.width/2, canvas1.height/2, 100, 50);
            });
        // 绘制圆形印章
        function drawText(companyName="智慧应用软件工作室",text= '测试') {
                   // 清除画布法一
                   context.globalAlpha=1;
                   context.fillStyle="#ffffff";
                   context.fillRect(0,0,400,400);


                var text = text;
                var companyName = companyName;

               // 绘制印章边框
                var width = canvas.width / 2;
                var height = canvas.height / 2;
                console.log(width);
                console.log(height);
                context.lineWidth = 5;
                context.strokeStyle = "#f00";
                context.beginPath();
                context.arc(width, height, 90, 0, Math.PI * 2);//宽、高、半径
                context.stroke();

                //画五角星
                create5star(context,width,height,25,"#f00",0);

                 // 绘制印章名称
                 context.font = '8px 宋体';
                 context.textBaseline = 'middle';//设置文本的垂直对齐方式
                 context.textAlign = 'center'; //设置文本的水平对对齐方式
                 context.lineWidth=1;
                 context.fillStyle = '#f00';
                 context.save();
                 context.translate(width,height+60);// 平移到此位置,
                 context.scale(1,2);//伸缩要先把远点平移到要写字的位置，然后在绘制文字
                 context.fillText(text,0,0);//原点已经移动
                 context.restore();

                 // 绘制印章单位
                 context.translate(width,height);// 平移到此位置,
                 context.font = '13px 楷体'
                 var  count = companyName.length;// 字数
                 var  angle = 4*Math.PI/(3*(count - 1));// 字间角度
                 var chars = companyName.split("");
                 var c;
                for (var i = 0; i < count; i++) {
                        c = chars[i];// 需要绘制的字符
            //绕canvas的画布圆心旋转
                        if (i == 0) {
                                context.rotate(5 * Math.PI / 6);
                            } else{
                                context.rotate(angle);
                            }
                        context.save();
                        context.translate(66, 0);// 平移到此位置,此时字和x轴垂直，公司名称和最外圈的距离
                        context.rotate(Math.PI / 2);// 旋转90度,让字平行于x轴
                        context.scale(1,2);//伸缩画布，实现文字的拉长
                        context.fillText(c, 0, 0);// 此点为字的中心点
                        context.restore();
                    }
                // 设置画布为最初的位置为原点，旋转回平衡的原位置，用于清除画布
                context.rotate(-Math.PI/6);
                context.translate(0-canvas.width/2,0-canvas.height/2);



                //绘制五角星
                 /**
         89          * 创建一个五角星形状. 该五角星的中心坐标为(sx,sy),中心到顶点的距离为radius,rotate=0时一个顶点在对称轴上
         90          * rotate:绕对称轴旋转rotate弧度
         91          */
                 function create5star(context, sx, sy, radius, color, rotato) {
                         context.save();
                         context.fillStyle = color;
                         context.translate(sx, sy);//移动坐标原点
                         context.rotate(Math.PI + rotato);//旋转
                         context.beginPath();//创建路径
                         var x = Math.sin(0);
                         var y = Math.cos(0);
                         var dig = Math.PI / 5 * 4;
                         for (var i = 0; i < 5; i++) {//画五角星的五条边
                                 var x = Math.sin(i * dig);
                                 var y = Math.cos(i * dig);
                                 context.lineTo(x * radius, y * radius);
                             }
                         context.closePath();
                         context.stroke();
                         context.fill();
                         context.restore();
                     }
             }

     </script>
 </body>
 </html><?php /**PATH D:\phpstudy_pro\WWW\contract\resources\views/test.blade.php ENDPATH**/ ?>