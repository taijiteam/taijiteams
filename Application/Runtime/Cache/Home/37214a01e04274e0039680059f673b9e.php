<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
 	  <title>成员风采</title>
    <meta name="keywords" content="" />
		<meta name="description" content="" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0,user-scalable=yes">
    <link rel="stylesheet" href="http://www.qudaoplus.cn/statics/css/common.css" />
    <link rel="stylesheet" href="http://www.qudaoplus.cn/statics/css/business.master.css" />
    <link rel="stylesheet" href="http://www.qudaoplus.cn/statics/css/business.css" />
    <link href="http://www.qudaoplus.cn/statics/css/regulations.css" rel="stylesheet" />
    <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon"/>
    <script type="text/javascript" src="http://www.qudaoplus.cn/statics/css/vendor/jquery-1.10.2.min.js" ></script>
    <script type="text/javascript" src="http://www.qudaoplus.cn/statics/css/vendor/jquery.backstretch.js" ></script>
    <script type="text/javascript" src="http://www.qudaoplus.cn/statics/css/vendor/jquery.cookie.js" ></script>
    <script type="text/javascript" src="http://www.qudaoplus.cn/statics/css/vendor/slick/slick.min.js" ></script>
    <script type="text/javascript" src="http://www.qudaoplus.cn/statics/css/vendor/jquery.bpopup.min.js" ></script>
    <script type="text/javascript" src="http://www.qudaoplus.cn/statics/css/vendor/velocity.min.js" ></script>
    <script type="text/javascript" src="http://www.qudaoplus.cn/statics/css/vendor/velocity.ui.min.js" ></script>
    <script type="text/javascript" src="http://www.qudaoplus.cn/statics/css/vendor/preloadjs-0.6.1.min.js" ></script>
    <script type="text/javascript" src="http://www.qudaoplus.cn/statics/css/vendor/rem.min.js" ></script>
    <script type="text/javascript" src=".http://www.qudaoplus.cn/statics/css/vendor/iscroll.js" ></script>
    <script type="text/javascript" src="http://www.qudaoplus.cn/statics/js/public.js" ></script>
    <!-- <script type="text/javascript" src="http://www.qudaoplus.cn/statics/js/move.js" ></script> -->
    <script type="text/javascript" src="http://www.qudaoplus.cn/statics/js/business.js" ></script>
    <!--[if lte IE 9]>
    <script type="text/javascript" src="../vendor/respond.min.js" ></script>
    <script type="text/javascript" src="../vendor/html5shiv.min.js" ></script>
    <![endif]-->
    <style type="text/css">
        .menu-btn{
            display: none;
        }
        .header-inside .back{
            display: block;
            z-index: 99999;
            left: 35px !important;
        }
        body{
            background-color: #000;
        }
        .header-inside{
            top: 0;
        }
        .person-content{
            margin-top: 130px;
            z-index: 9
        }
        .pt-box{
            text-align: center;
            color: #fff;
            overflow: hidden;
            float: none !important;
        }
        .header-inside .top-nav-business li{
            width: 100%;
        }
        .pt-box .top-logo{
            height: 80px;
            margin-top: 50px;
        }
        .pt-box .people{
            height: 300px;
            margin-top: 50px;
        }
        .pt-box .people img{
            border: 2px solid #fff;
        }
        .pt-box .member{
            height: 16px;
            margin-bottom: 30px;
        }
        .pt-box img{
            width: auto;
            height: 100%;
        }
        .pt-box h2{
            font-size: 20px;
            margin: 30px auto 20px;
        }
        .pt-box p{
            width: 80%;
            margin: auto;
            font-size: 16px;
        }
        .bg-lion{
            width: 620px;
            height: 650px;
            position: fixed;
            right: 0;
            top: 150px;
            transform: translate(50%, 0);
        }
        .bg-lion img{
            width: auto;
            height: 100%;
        }
        .t-text{
            width: 100%;
            height: auto;
            /*display: none;*/
        }
        .t-text, .t-text tr, .t-text td{
            border: none;
        }
        .t-text .t-left{
            /*width: 65%;*/
            display: inline-block;
            text-align: right;
            padding-right: 5px;
        }
        .t-text .t-right{
            /*width: 35%;*/
            display: inline-block;
            text-align: left;
            padding-left: 5px;
        }
        @media (max-width: 768px){
            .header-inside .back{
                left: 5% !important;
            }
            .pt-box{
                background-image: url(http://www.qudaoplus.cn/statics/images/person_list/bg.jpg);
                background-repeat: no-repeat;
                background-size: auto 100%;
                background-position: center center;
            }
            .pt-box .top-logo{
                height: 60px;
                margin-top: 30px;
            }
            .pt-box p{
                font-size: 12px;
            }
            .pt-box .member{
                height: 11px;
            }
            .person-content{
                width: 100%;
            }
            .bg-lion{
                display: none;
            }
        }
		</style>
</head>
  <body>
    <!--导航菜单-->
     <div id="nav">
        <div class="nav-bg"></div>
        <ul class="nav-list">
          <li ><a  href="http://www.qudaoplus.cn" >首页</a><i class="line"></i></li>
          <li  ><a  href="http://www.qudaoplus.cn/index.php?m=content&c=index&a=lists&catid=18" >新闻列表</a><i class="line"></i></li>
          <li  ><a  href="http://www.qudaoplus.cn/index.php?m=content&c=index&a=lists&catid=12" >更多权益</a><i class="line"></i></li>
          <li  class="on"  ><a  href="http://www.qudaoplus.cn/index.php?m=content&c=index&a=lists&catid=20" >成员展示</a><i class="line"></i></li>
          <li ><a target="_blank"  href="http://www.qudaoplus.cn/contact.html" >联系我们</a><i class="line"></i></li>
        </ul>
      </div><!--头部内容-->
      <div class="header header-inside">
          <div class="header-top">
              <div class="menu-btn">
                  <span>菜单</span>
              </div>
              <div class="back"><a href="javascript:history.go(-1);"></a></div>
              <div class="business-logo">
                  <a href="javascript:" >
                      <div></div>
                  </a>
                  <span class="text"><p class="en">MEMBER</p><p>成员风采</p></span>
              </div>
           </div>
           <ul class="top-nav top-nav-business">
              <li class="on"><a >成员展示</a></li>
           </ul>
      </div>
      <link href="http://www.qudaoplus.cn/statics/css/person_list.css" rel="stylesheet" type="text/css" />
      <!--content-->
      <div class="person-content">
          <div class="person-translate">
              <div class="pt-box">
                  <div class="top-logo"><img src="http://www.qudaoplus.cn/statics/images/person_list/logo.png"></div>
                  <div class="people">
                    <?php if( $data[0][ImagePath] != null ): ?><img src="<?php echo ($data[0]["ImagePath"]); ?>">
                    <?php else: ?>
                      <img src="/Public/Club/images/headimg.jpg" alt="人"><?php endif; ?>
                  </div>
                  <h2><?php echo ($data[0]["TrueName"]); ?></h2>
                  <div class="member"><img src="http://www.qudaoplus.cn/statics/images/person_list/member.png"></div>
                  <table class="t-text">
                      <?php
 $v3 = explode(" ",$data[0][ExtValue3]); $v8 = explode(" ",$data[0][ExtValue8]); $left = json_encode($v3, JSON_UNESCAPED_UNICODE); $right = json_encode($v8, JSON_UNESCAPED_UNICODE); ?>

                        <tr style="text-align: center">
                            <td class="t-left"><?php echo ($left); ?></td>
                            <td class="t-right"><?php echo ($right); ?></td>
                        </tr>


                  </table>
              </div>
          </div>
      </div>
      <div class="bg-lion"><img src="http://www.qudaoplus.cn/statics/images/person_list/lion.png" alt=""></div>
  </body>
</html>
<script type="text/javascript">

  var left = eval('(' + $('.t-left').text() + ')'),
      right = eval('(' + $('.t-right').text() + ')');

  $('.t-text').html('');

  for(var i = 0; i < right.length; i++){
    $('.t-text').append('<tr><td class="t-left">'+( (!left[i]) ? ' ': left[i] )+'</td><td class="t-right">'+( (!right[i]) ? ' ': right[i] )+'</td></tr>')
  }

  $('.t-text').show();

</script>