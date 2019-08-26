<?php if (!defined('THINK_PATH')) exit();?><html class="x-admin-sm">
  <head>
    <meta charset="UTF-8">
    <title>渠道plus微管家</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="stylesheet" href="/Public/Admin/css/font.css">
    <link rel="stylesheet" href="/Public/Admin/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/Admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/Public/Admin/js/xadmin.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/cookie.js"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a>
          <cite>导航元素</cite></a>
      </span>
      <button class="layui-btn" id="export" style="float: right"><i class="layui-icon"></i>导出成员积分</button>
    </div>
    <div class="x-body">
      <div class="layui-row">
        <form method="post" action="<?php echo U('Sort/sortSearch');?>" class="layui-form layui-col-md12 x-so" >
          <input class="layui-input"  autocomplete="off" placeholder="开始日" name="start" id="start">
          <input class="layui-input"  autocomplete="off" placeholder="截止日" name="end" id="end">
          <input type="text" name="username"  placeholder="请输入用户名" autocomplete="off" class="layui-input">
          <!-- <button class="layui-btn" id="btn" lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button> -->
          <input id="btn" type="submit" class="layui-btn" lay-filter="add" lay-submit="" value="查找">
        </form>
      </div>
      <xblock>
        <!--<button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>-->
        <span class="x-right" style="line-height:40px">共有数据：<span style="color: red"><?php echo ($count); ?></span> 条</span>
      </xblock>
      <table class="layui-table x-admin" id="a">
        <thead>
          <tr>
           <!-- <th>
              <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>-->
            <th>序号</th>
            <th>姓名</th>
            <th>性别</th>
            <th>电话</th>
            <th>酒积分</th>
            <th>机场积分</th>
            <th>医疗积分</th>
            <th>兑换积分</th>
            <th>金币积分</th>
            <th style="color: red">总积分</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          <?php if(is_array($res)): $k = 0; $__LIST__ = $res;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><tr>
              <td><?php echo ($k); ?></td>
              <td><?php echo ($vo["m_cname"]); ?></td>
              <td><?php echo ($vo["m_sex"]); ?></td>
              <td><?php echo ($vo["m_phone"]); ?></td>
              <td><?php echo ($vo["a_jiu_sort"]); ?></td>
              <td><?php echo ($vo["a_jichang_sort"]); ?></td>
              <td><?php echo ($vo["a_doctor_sort"]); ?></td>
              <td><?php echo ($vo["a_consume_sort"]); ?></td>
              <td><?php echo ($vo["a_jinbi_sort"]); ?></td>
              <td style="color: red"><?php echo ($vo["m_integrals"]); ?></td>
              <td class="td-statuss">
                  <span class="layui-btn layui-btn-normal layui-btn-mini" onclick="x_admin_show('详情','<?php echo U('Sort/sortDefatu');?>?id=<?php echo ($vo["a_aid"]); ?>',500,420)"  href="javascript:;">积分编辑</span>
                <a href="/Admin/Sort/sort_log?mid=<?php echo ($vo["m_id"]); ?>"><span class="layui-btn layui-btn-normal layui-btn-mini">详情记录</span></a>
              </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
        <thead>
          <tr>
            <!--<td>
              <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='2'><i class="layui-icon">&#xe605;</i></div>
            </td>-->
            <td><?php echo ($k); ?></td>
            <td><?php echo ($vo["m_cname"]); ?></td>
            <td><?php echo ($vo["m_sex"]); ?></td>
            <td><?php echo ($vo["m_phone"]); ?></td>
            <td><?php echo ($vo["a_jiu_sort"]); ?></td>
            <td><?php echo ($vo["a_jichang_sort"]); ?></td>
            <td><?php echo ($vo["a_doctor_sort"]); ?></td>
            <td><?php echo ($vo["a_consume_sort"]); ?></td>
            <td><?php echo ($vo["a_jinbi_sort"]); ?></td>
            <td style="color: red"><?php echo ($vo["m_integrals"]); ?></td>
            <td class="td-statuss">
                <span class="layui-btn layui-btn-normal layui-btn-mini" onclick="x_admin_show('详情','<?php echo U('Sort/sortDefatu');?>?id=<?php echo ($vo["a_aid"]); ?>',500,420)"  href="javascript:;">积分编辑</span>
              <a href="/Admin/Sort/sort_log?mid=<?php echo ($vo["m_id"]); ?>"><span class="layui-btn layui-btn-normal layui-btn-mini">详情记录</span></a>
            </td>
          </tr>
        </thead>
      </table>
      <div class="page">
        <div>
          <?php echo ($page); ?>
        </div>
      </div>

    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>
      var table=document.getElementById("a");//获取table对象
      // console.log(table.rows);
      var rows=table.rows;//获取行对象
      // console.log(rows);
      var cells=table.cells;//获取列对象
      // console.log(cells);
      var colums = table.rows[0].cells.length;//获取列数  
      // console.log(colums);
      $(".count").append("<td>合计</td>");
      for(var j=1;j<colums;j++){
        var sum=0;
        
      };
     


      layui.use('laydate', function(){
        var laydate = layui.laydate;

        //执行一个laydate实例
        laydate.render({
          elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
          elem: '#end' //指定元素
        });
      });

       /*用户-停用*/
      function member_stop(obj,id){
        var title =   $(obj).attr('id');
        //alert(active);
        $.ajax({
          type:"post",
          url:"<?php echo U('Business/BusinessActive');?>",
          data:{
            'id': title,
          },
          dataType:'json',
          success:function(data){
            alert(JSON.stringify(data));

          },
        });
        if ($(obj).attr('title')=='隐藏') {
          layer.confirm('确认要启用吗？',function(index) {
             $(obj).attr('title', '展示');
              $(obj).find('i').html('&#xe601;');
            $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('展示');
            layer.msg('已展示!', {icon: 1, time: 1000});
          });
        }else if($(obj).attr('title')=='展示'){
            layer.confirm('确认要隐藏吗？',function(index){
                //发异步把用户状态进行更改
                $(obj).attr('title','隐藏')
                $(obj).find('i').html('&#xe62f;');
                $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('隐藏');
                layer.msg('已隐藏!',{icon: 5,time:1000});
            });
        }
      }

      /*用户-删除*/
      function member_del(obj,id){
        var id = id;
        //alert(id);
        //发异步删除数据
        $.ajax({
          url:"<?php echo U('Index/memberDel');?>",
          type:"post",
          data:{
            'id': id,
          },
          dataType:'json',
          success:function(data){
            alert(JSON.stringify(data));

          },
        });
          layer.confirm('确认要删除吗？',function(index){
              //发异步删除数据
              $(obj).parents("tr").remove();
              layer.msg('已删除!',{icon:1,time:1000});
          });
      }
      //用户编辑
      function member_Edit (obj,id) {
        var id = id;
        //alert(id)
        $.ajax({
          url:"<?php echo U('Index/memberEdit');?>",
          type:"post",
          data:{
            'id': id,
          },
          dataType:'json',
          success:function(data){
            alert(JSON.stringify(data));

          },
        });
        //多窗口模式，层叠置顶
        layer.open({
          type: 2 //此处以iframe举例
          ,title: '会员编辑'
          ,area: ['600px', '400px']
          ,shade: 0
          ,maxmin: true
          ,content: "<?php echo U('Index/memberEdit');?>"
          ,btn2: function(){
            layer.closeAll();
          }

          ,zIndex: layer.zIndex //重点1
          ,success: function(layero){
            layer.setTop(layero); //重点2
          }
        });
      }

      function delAll (argument) {

        var data = tableCheck.getData();

        layer.confirm('确认要删除吗？'+data,function(index){
            //捉到所有被选中的，发异步进行删除
            layer.msg('删除成功', {icon: 1});
            $(".layui-form-checked").not('.header').parents('tr').remove();
        });
      }


    </script>
    <script>
      $(function () {
        $('#export').click(function () {
          window.location.href = "/Admin/Sort/exportList?order_type=4";
        });
      })
    </script>
    <script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
      })();
    </script>
    <script>
     /* //提交
      $("#btn").click(function() {
        var cname  = $('input[name="username"]').val();
        //alert(cname)
        $.ajax({
          url:"<?php echo U('Member/memberSearch');?>",
          type:"post",
          contentType: "application/x-www-form-urlencoded; charset=utf-8",//解决中文乱码问题
          data: {
            'm_cname' : cname,
          },
          dataType: "json",
          success:function(data){
            //alert(JSON.stringify(data));
            if (data == 1){
              alert(11)
              location = "<?php echo U('Index/memberSearch');?>";
            }else{
              layer.msg('搜索姓名的呦！',function(){});
            }
          },
        });
      });*/
    </script>
  </body>

</html>