<?php
return array(
	//'配置项'=>'配置值'
  'TMPL_PARSE_STRING' =>  array(
            '__Club__'     => __ROOT__.'/Public/Club/', // 增加新的JS类库路径替换规则
            '__JS__'       => __ROOT__.'/Public/Club/js/', // 增加新的JS类库路径替换规则
            '__css__'      => __ROOT__.'/Public/Club/css/', // 增加新的JS类库路径替换规则
            '__img__'      => __ROOT__.'/Public/Club/images/',
            '__upload__'   => __ROOT__.'/Public/Uploads/',
    ),

  'URL_CASE_INSENSITIVE' =>true, //表示URL访问不区分大小写

    // 加载扩展配置文件 多个用,隔开
   'LOAD_EXT_CONFIG' => 'db',
);
