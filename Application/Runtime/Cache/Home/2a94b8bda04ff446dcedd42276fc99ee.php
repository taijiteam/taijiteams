<?php if (!defined('THINK_PATH')) exit();?><link href="http://www.qudaoplus.cn/statics/css/footer.css?v=1" rel="stylesheet" type="text/css" />

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>部分成员风采</title>
		<meta name="keywords" content="渠道PLUS" />
		<meta name="description" content="渠道PLUS" />
		<meta name="renderer" content="webkit">
		<meta http-equiv="x-ua-compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
        <link rel="shortcut icon" href="http://www.qudaoplus.cn/images/favicon.ico?v=1" type="image/x-icon"/>
		<link href="/Public/Club/statics/css/common.css" rel="stylesheet" type="text/css" />
        <link href="/Public/Club/statics/css/loading.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="/Public/Club/statics/css/index.master.css" />
		<link rel="stylesheet" href="/Public/Club/statics/css/vendor/fullpage/jquery.fullPage.css">
        <!--   add start   -->
        <link href="/Public/Club/statics/css/change.css" rel="stylesheet" type="text/css" />
        <link href="/Public/Club/statics/css/business.css" rel="stylesheet" type="text/css" />
        <link href="/Public/Club/statics/css/person_list.css" rel="stylesheet" type="text/css" />
        <!--   add end   -->
		<script type="text/javascript" src="/Public/Club/statics/css/vendor/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="/Public/Club/statics/css/vendor/fullpage/jquery.fullPage.min.js"></script>
		<script type="text/javascript" src="/Public/Club/statics/css/vendor/jquery.backstretch.js"></script>
		<script type="text/javascript" src="/Public/Club/statics/css/vendor/slick/slick.min.js"></script>
		<script type="text/javascript" src="/Public/Club/statics/css/vendor/jquery.cookie.js"></script>
		<script type="text/javascript" src="/Public/Club/statics/css/vendor/jquery.bpopup.min.js"></script>
		<script type="text/javascript" src="/Public/Club/statics/css/vendor/velocity.min.js"></script>
		<script type="text/javascript" src="/Public/Club/statics/css/vendor/velocity.ui.min.js"></script>
		<script type="text/javascript" src="/Public/Club/statics/css/vendor/preloadjs-0.6.1.min.js"></script>
		<script type="text/javascript" src="/Public/Club/statics/css/vendor/rem.min.js"></script>
		<script type="text/javascript" src="/Public/Club/statics/js/public.js"></script>
		<script type="text/javascript" src="/Public/Club/statics/js/resize.js"></script>

		<script type="text/javascript" src="/Public/Club/statics/js/jquery.touchSwipe.min.js"></script>

<!--		<script type="text/javascript" src="/Public/Club/statics/js/index.js"></script>-->

		<style type="text/css">
      .pt-box{
        min-height: 1px;
      }
      .menu-btn{
        display: none;
      }
      .person-content .pc-content .pcc-list{
        height: 264px;
      }
      .pc-content .pcc-list .pl-content{
        height: 224px;
      }
      .pl-content .text h2{
        margin: 28px 0;
      }
      /*footer{
        display: none;
      }*/
      @media (max-width: 1025px){
        .person-content .pc-content .pcc-list{
          height: 132px;
        }
        .pc-content .pcc-list .pl-content{
          height: 112px;
        }
        .pl-content .text h2{
          margin: 14px 0;
        }
        .pcc-list .pl-content img{
          margin-left: 2px;
        }
      }
    </style>
    <script>
        var $win = $(window),
            winHeight = $win.height();
    </script>
    <!-- <script type="text/javascript">
      function pushHistory() {
        var state = {
          title: "title",
          url: "#"
        };
        window.history.pushState(state, "title", "#");
      }
      pushHistory();

      setTimeout(function(){
            window.addEventListener("popstate", function(e){
                setTimeout(function(){
                    location.href="http://www.qudaoplus.cn/index.php?m=content&c=index&a=lists&catid=22"
                },1000)
            }, false)
        },1000);

    </script> -->
	</head>


	<body id="person-list">
    <?php if( !$info ){ ?>
    <style type="text/css">
        .loading{
          width: 100%;
          height: auto;
          position: relative;
          text-align: center;
          top: 40%;
          transform: translateY(-50%);
          overflow: hidden;
          zoom: 1;
        }
        h2 {
          color: #ccc;
          margin: 0;
          font: .8em verdana;
          text-transform: uppercase;
          letter-spacing: .1em;
        }
        .loading span {
          display: inline-block;
          vertical-align: middle;
          width: .6em;
          height: .6em;
          margin: .19em;
          background: #fff;
          border-radius: .6em;
          -webkit-animation: loading 1s infinite alternate;
                  animation: loading 1s infinite alternate;
        }
        .loading span:nth-of-type(2) {
          background: #fffef9;
          -webkit-animation-delay: 0.2s;
                  animation-delay: 0.2s;
        }
        .loading span:nth-of-type(3) {
          background: #f6f5ec;
          -webkit-animation-delay: 0.4s;
                  animation-delay: 0.4s;
        }
        .loading span:nth-of-type(4) {
          background: #d9d6c3;
          -webkit-animation-delay: 0.6s;
                  animation-delay: 0.6s;
        }
        .loading span:nth-of-type(5) {
          background: #d1c7b7;
          -webkit-animation-delay: 0.8s;
                  animation-delay: 0.8s;
        }
        .loading span:nth-of-type(6) {
          background: rgb(178, 163, 130);
          -webkit-animation-delay: 1.0s;
                  animation-delay: 1.0s;
        }
        .loading span:nth-of-type(7) {
          background: #dbce8f;
          -webkit-animation-delay: 1.2s;
                  animation-delay: 1.2s;
        }
        @-webkit-keyframes loading {
          0% {
            opacity: 0;
          }
          100% {
            opacity: 1;
          }
        }
        @keyframes loading {
          0% {
            opacity: 0;
          }
          100% {
            opacity: 1;
          }
        }
    </style>
    <div class="loading">
        <h2>正在为您加载</h2>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
    <?php } else { ?>
    
        <div class="person-alert">
            <div class="alert-content"><p>加载中，请稍候...</p></div>
        </div>

        <div class="go-top"></div>

        <!--头部内容-->
        <div class="header header-inside">
            <div class="person-nav">
                <ul>
                  <li class="active"><a>全部成员</a></li>
                  <li><a>商政名流</a></li>
                  <li><a>企业精英</a></li>
                  <li><a>文艺雅仕</a></li>
                  <li><a>名医专家</a></li>
                  
                </ul>
             </div>

        </div>

        <!--content-->
        <div class="person-content">
            <div class="pc-search">
                <form id="con-search" action="" onsubmit="return false;">
                    <input type="search" onkeyup="value=value.replace(/[^\u4E00-\u9FA5]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\u4E00-\u9FA5]/g,''))"  placeholder="请输入需要搜索的内容">
                </form>
                <div><b></b><span>搜索</span></div>
            </div>
            <div style="width: 100%;/* margin-bottom: 10px; */color: #999; text-align: right">按成员进驻时间排序</div>
            <div class="person-translate">

              <!--全部成员-->
                <div class="pt-box" id="">
                  <?php if($szml_info == null): ?><div style="text-align:center;color:#fff;">您的成员级别无法查看此信息</div>
                <?php else: ?>
                    <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><a href="/index.php/Home/Index/details/cardid/<?php echo ($v["CardId"]); ?>">
                      <div class="pc-content">
                          <div class="pcc-list">
                              <div class="pl-content">
                                <?php if( $v["ImagePath"] != null ): ?><img src="<?php echo ($v["ImagePath"]); ?>" alt="人">
                                <?php else: ?>
                                  <img src="/Public/Club/images/headimg.png" alt="人"><?php endif; ?>
                                  <div class="text">
                                      <h2><?php echo ($v["TrueName"]); ?></h2>
                                      <p><?php $v3 = explode(" ",$v[ExtValue3]); if( mb_strlen($v3[0],'utf-8') > 15 ){ echo mb_substr( $v3[0] , 0 , 15 ,'utf-8').'...';}else{ echo $v3[0]; } ?></p>
                                      <p><?php $v8 = explode(" ",$v[ExtValue8]); if( mb_strlen($v8[0],'utf-8') > 15 ){ echo mb_substr( $v8[0] , 0 , 15 ,'utf-8').'...';}else{ echo $v8[0]; } ?></p>
                                      <p>[<?php echo ($v["ExtValue25"]); ?>]</p>
                                      <b></b>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </a><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                </div>

              <!-- 商政名流 -->
              <div class="pt-box" id="">
                
                  <?php if(is_array($szml_info)): $i = 0; $__LIST__ = $szml_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><a href="/index.php/Home/Index/details/cardid/<?php echo ($v["CardId"]); ?>">
                      <div class="pc-content">
                        <div class="pcc-list">
                          <div class="pl-content">
                            <?php if( $v["ImagePath"] != null ): ?><img src="<?php echo ($v["ImagePath"]); ?>" alt="人">
                            <?php else: ?>
                              <img src="/Public/Club/images/headimg.png" alt="人"><?php endif; ?>
                            <div class="text">
                              <h2><?php echo ($v["TrueName"]); ?></h2>
                              <p><?php $v3 = explode(" ",$v[ExtValue3]); if( mb_strlen($v3[0],'utf-8') > 15 ){ echo mb_substr( $v3[0] , 0 , 15 ,'utf-8').'...';}else{ echo $v3[0]; } ?></p>
                              <p><?php $v8 = explode(" ",$v[ExtValue8]); if( mb_strlen($v8[0],'utf-8') > 15 ){ echo mb_substr( $v8[0] , 0 , 15 ,'utf-8').'...';}else{ echo $v8[0]; } ?></p>
                              <p>[<?php echo ($v["ExtValue25"]); ?>]</p>
                              <b></b>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a><?php endforeach; endif; else: echo "" ;endif; ?>
                
              </div>


                <!-- 企业精英 -->
                <div class="pt-box" id="">
                  <?php if(is_array($qyjy_info)): $i = 0; $__LIST__ = $qyjy_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><a href="/index.php/Home/Index/details/cardid/<?php echo ($v["CardId"]); ?>">
                      <div class="pc-content">
                          <div class="pcc-list">
                              <div class="pl-content">
                                  <?php if( $v["ImagePath"] != null ): ?><img src="<?php echo ($v["ImagePath"]); ?>" alt="人">
                                  <?php else: ?>
                                    <img src="/Public/Club/images/headimg.png" alt="人"><?php endif; ?>
                                  <div class="text">
                                      <h2><?php echo ($v["TrueName"]); ?></h2>
                                      <p><?php $v3 = explode(" ",$v[ExtValue3]); if( mb_strlen($v3[0],'utf-8') > 15 ){ echo mb_substr( $v3[0] , 0 , 15 ,'utf-8').'...';}else{ echo $v3[0]; } ?></p>
                                      <p><?php $v8 = explode(" ",$v[ExtValue8]); if( mb_strlen($v8[0],'utf-8') > 15 ){ echo mb_substr( $v8[0] , 0 , 15 ,'utf-8').'...';}else{ echo $v8[0]; } ?></p>
                                      <p>[<?php echo ($v["ExtValue25"]); ?>]</p>
                                      <b></b>
                                  </div>
                              </div>
                          </div>
                       </div>
                     </a><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>

                <!-- 文艺雅仕 -->
                <div class="pt-box" id="">
                  <?php if(is_array($wyys_info)): $i = 0; $__LIST__ = $wyys_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><a href="/index.php/Home/Index/details/cardid/<?php echo ($v["CardId"]); ?>">
                      <div class="pc-content">
                          <div class="pcc-list">
                              <div class="pl-content">
                                  <?php if( $v["ImagePath"] != null ): ?><img src="<?php echo ($v["ImagePath"]); ?>" alt="人">
                                  <?php else: ?>
                                    <img src="/Public/Club/images/headimg.png" alt="人"><?php endif; ?>
                                  <div class="text">
                                      <h2><?php echo ($v["TrueName"]); ?></h2>
                                      <p><?php $v3 = explode(" ",$v[ExtValue3]); if( mb_strlen($v3[0],'utf-8') > 15 ){ echo mb_substr( $v3[0] , 0 , 15 ,'utf-8').'...';}else{ echo $v3[0]; } ?></p>
                                      <p><?php $v8 = explode(" ",$v[ExtValue8]); if( mb_strlen($v8[0],'utf-8') > 15 ){ echo mb_substr( $v8[0] , 0 , 15 ,'utf-8').'...';}else{ echo $v8[0]; } ?></p>
                                      <p>[<?php echo ($v["ExtValue25"]); ?>]</p>
                                      <b></b>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </a><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>

                <!-- 名医专家 -->
                <div class="pt-box" id="">
                  <?php if(is_array($myzj_info)): $i = 0; $__LIST__ = $myzj_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><a href="/index.php/Home/Index/details/cardid/<?php echo ($v["CardId"]); ?>">
                      <div class="pc-content">
                          <div class="pcc-list">
                              <div class="pl-content">
                                  <?php if( $v["ImagePath"] != null ): ?><img src="<?php echo ($v["ImagePath"]); ?>" alt="人">
                                  <?php else: ?>
                                    <img src="/Public/Club/images/headimg.png" alt="人"><?php endif; ?>
                                  <div class="text">
                                      <h2><?php echo ($v["TrueName"]); ?></h2>
                                      <p><?php $v3 = explode(" ",$v[ExtValue3]); if( mb_strlen($v3[0],'utf-8') > 15 ){ echo mb_substr( $v3[0] , 0 , 15 ,'utf-8').'...';}else{ echo $v3[0]; } ?></p>
                                      <p><?php $v8 = explode(" ",$v[ExtValue8]); if( mb_strlen($v8[0],'utf-8') > 15 ){ echo mb_substr( $v8[0] , 0 , 15 ,'utf-8').'...';}else{ echo $v8[0]; } ?></p>
                                      <p>[<?php echo ($v["ExtValue25"]); ?>]</p>
                                      <b></b>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </a><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>

                

            </div>

        </div>
<?php } ?>
    </body>

</html>
<script type="text/javascript">

    $(document).ready(function(){

        var group = '<?php echo $group; ?>';

        var $goTop = $('.go-top'),
            $alert = $('.person-alert'),
            $alertTxt = $alert.find('p'),
            $nav = $('.person-nav'),
            $navLi = $nav.find('li'),
            $content = $('.person-content'),
            $translateBox = $content.find('.person-translate'),
            $list = $translateBox.find('.pt-box'),
            $listLi = $list.find('.pc-content'),
            $alert = $('.person-alert'),
            $alertTxt = $alert.find('p'),
            $searchBox = $('.pc-search'),
            $searchTxt = $searchBox.find('input'),
            $searchBtn = $searchBox.find('div');

        var listHeight = $listLi.height();

        //列表数据条数，最后一个是搜索
        var list = [0, 0, 0, 0, 0, 0];

        for(var i = 0; i < $navLi.size(); i++){
          list[i] = $list.eq(i).find('.pc-content').size();
          if(i == $navLi.size() - 1){
            changeWinHeight(list[0]);
          }
        }

        //传的页数
        var ajaxPage = [2, 2, 2, 2, 2, 0];
        var loadList = [0, 0, 0, 0, 0, 0];

        var nowpage = 0, thispage = 0, oldpage = 0, loadOver = true, difference, search;

        $list.width($content.width());
        $translateBox.width($list.size() * $content.width());
        $content.height(list[nowpage] * listHeight + 97);

        //移动判断动画
        function personAnimate(num){
            $translateBox.css({transform: 'translate('+num * -20+'%, 0)', transitionDuration: .8+'s'});
        }

        //标签切换
        function tableTranslate(num){
            $navLi.eq(num).addClass('active').siblings().removeClass('active');
        }

        //切换之后跳到页面顶部并更改页面高度
        function changeWinHeight(num){
            if(loadOver){
                $(document).scrollTop(0);
            }
            $content.height(num * listHeight + 97);
        }

        //弹窗显示与提示内容
        function alertShow(txt){
            $alertTxt.text(txt);
            $alert.fadeIn();
        }

        //加载事件
        function contentLoad(content, num){
            loadOver = false;

            alertShow('加载中，请稍候...');

            var thisUrl;

            // console.log(num);

            if(num >= 1 && num <= 4){
                thisUrl = "<?php echo U('Index/cation');?>";
            }
            else if (num == 0) {
                thisUrl = "<?php echo U('Index/index');?>";
            }
            else {
                thisUrl = "<?php echo U('Index/search');?>";
            }

            $.ajax({
                type: "GET",
                url: thisUrl,
                data:{
                    type : content,
                    page : ajaxPage[num],
                    group :group
                },
                error: function(request) {
                    alert("Connection error");
                },
                success: function(data) {
                    data = eval( '(' +data+ ')' );
                    if (data.state == '-1') {
                      alertShow(data.message);
                      $alert.fadeOut();
                      loadOver = true;
                    }else if(data.state == 0 && data.data.length==0){
                      alertShow('没有更多');
                      $alert.fadeOut();
                      loadOver = true;
                    }
                    else {
                      if(data.data.length == 10){
                        ajaxPage[num] = ajaxPage[num] + 2;
                      }
                      else {
                        ajaxPage[num] = ajaxPage[num] + 1;
                      }

                      var html = [];

                      for(var i = 0; i < data.data.length; i++){
                          html += '<a href="/index.php/Home/Index/details/cardid/'+data.data[i].CardId+'"><div class="pc-content"><div class="pcc-list"><div class="pl-content"><img src="'+ (data.data[i].ImagePath ? data.data[i].ImagePath : "/Public/Club/images/headimg.png" ) +'" alt="人"><div class="text"><h2>'+data.data[i].TrueName+'</h2><p>'+((data.data[i].ExtValue3.split(" "))[0].length < 15 ? (data.data[i].ExtValue3.split(" "))[0]: (data.data[i].ExtValue3.split(" "))[0].substring(0,15) + '...' )+'</p><p>' + ( (data.data[i].ExtValue8.split(" "))[0].length < 15 ? (data.data[i].ExtValue8.split(" "))[0] : (data.data[i].ExtValue8.split(" "))[0].substring(0,15) + '...' ) + '</p><p>['+data.data[i].ExtValue25+' ]</p><b></b></div></div></div></div></a>';
                      }

                      $list.eq(nowpage).append(html);
                      $alert.fadeOut();
                      changeWinHeight(list[num] + data.data.length,list[num]);
                      list[num] = list[num] + data.data.length;
                      loadOver = true;
                    }
                }
            });
        }

        //移动端禁止滑动
        $alert.bind("touchmove",function(e){
            e.preventDefault();
        });

        $win.on({
            wheel : function(e){
                if(!loadOver){
                    e.preventDefault();
                }
            }
        });

        //标签点击事件
        $navLi.click(function(){
            oldpage = nowpage;
            nowpage = $(this).index();
            if(nowpage == 4 && search){
              window.location.href = window.location.href;
//              window.location.href = window.location.href + Math.random().toString(36).substr(2);
                // search = false;
                // list[5] = 0;
                // $searchTxt.val('');
                // $list.eq(nowpage).html('');
                // list[nowpage] = 0;
                // ajaxPage[nowpage] = 0;
                // contentLoad($navLi.eq(nowpage).text(), list[nowpage]);
            }
            else{
                changeWinHeight(list[nowpage], list[oldpage]);
            }

            tableTranslate(nowpage);
            personAnimate(nowpage);
        });

        //给予添加插件事件监听
        $translateBox.swipe({
            excludedElements: "button, input, select, textarea, .noSwipe" ,
            swipeLeft: function(event, direction, distance, duration, fingerCount, fingerData){
                oldpage = nowpage;
                nowpage = nowpage + 1;
                if(nowpage >= 0 && nowpage < 5){
                    if(nowpage == 4 && search){
                        window.location.href = window.location.href + '&refresh=' + Math.random().toString(36).substr(2);
                        // search = false;
                        // list[5] = 0;
                        // $searchTxt.val('');
                        // $list.eq(nowpage).html('');
                        // list[nowpage] = 0;
                        // contentLoad($navLi.eq(nowpage).text(), list[nowpage]);
                    }
                    else{
                        changeWinHeight(list[nowpage], list[oldpage]);
                    }
                    personAnimate(nowpage);
                    tableTranslate(nowpage);
                }
                else{
                    nowpage = oldpage;
                }
            },

            swipeRight: function(event, direction, distance, duration, fingerCount, fingerData){
                oldpage = nowpage;
                nowpage = nowpage - 1;
                if(nowpage >= 0 && nowpage < 5){
                    changeWinHeight(list[nowpage], list[oldpage]);
                    personAnimate(nowpage);
                    tableTranslate(nowpage);
                }
                else{
                    nowpage = oldpage;
                }
            },
            threshold: 100
        });

        //滑到底部加载事件
        $win.scroll(function(){
            if($(document).scrollTop() > 100){
                $goTop.fadeIn();
            }
            else{
                $goTop.hide();
            }
            if($(document).scrollTop() + winHeight >= $(document).height()){
              if(loadOver){
                if(nowpage == 4 && search){
                    contentLoad($searchTxt.val(), 5);
                }
                else{
                    contentLoad($navLi.eq(nowpage).text(), nowpage);
                }
              }
            }
        });

        $goTop.click(function(){
            $(document).scrollTop(0);
        });

        //点击搜索
        $searchBtn.click(function(){
            search = true;
            list[5] = 0;
            nowpage = 4;
            ajaxPage[5] = 0;
            $list.eq(nowpage).html('');
            tableTranslate(nowpage);
            personAnimate(nowpage);
            contentLoad($searchTxt.val(), 5);
        });

        $('#con-search').bind('search', function () {
            $searchBtn.click();
            $(this).find('input').blur();
        });


    });

</script>

<?php $id = $_REQUEST['id']; ?>
<footer>
  <ul>
      <a href="http://www.qudaoplus.cn/merber_all_show/index.php/home/Personnal/central"><li class="core"><em></em><span>成员中心</span></li></a>
      <a href="/Home/Home/index"><li class="vip on"><em></em><span>成员专享</span></li></a>
      <!-- <a href="http://www.qudaoplus.cn/index.php?m=content&c=index&a=lists&catid=32"><li class="activity"><em></em><span>精彩活动</span></li></a> -->
      <a href="http://www.qudaoplus.cn/index.php?m=content&c=index&a=lists&catid=25"><li class="steward"><em></em><span>联系管家</span></li></a>
  </ul>
</footer>