<?php
return [
    'adminEmail' => 'admin@example.com',
    'adminNav'   => [
        ['name' => '分类管理', 'action' => 'term', 'show' => true, 'params' => '','id'=>1,'pId'=>''],
        ['name' => '文章管理', 'action' => 'article', 'show' => true, 'params' => '','id'=>2,'pId'=>''],
        ['name' => '用户项目管理', 'action' => 'product', 'show' => true, 'params' => '','id'=>3,'pId'=>''],
        ['name' => '公司项目管理', 'action' => 'yyzc', 'show' => true, 'params' => '','id'=>4,'pId'=>''],
        ['name' => '会员管理', 'action' => 'member', 'show' => true, 'params' => '','id'=>5,'pId'=>''],
        ['name' => '轮动广告', 'action' => 'slider', 'show' => true, 'params' => '','id'=>6,'pId'=>''],
        ['name' => '支付管理', 'action' => 'order', 'show' => true, 'params' => '','id'=>7,'pId'=>''],
        ['name' => '订单管理', 'action' => 'invoice', 'show' => true, 'params' => '','id'=>8,'pId'=>''],
        ['name' => '用户管理', 'action' => 'user', 'show' => true, 'params' => '','id'=>9,'pId'=>''],
        ['name' => '角色管理', 'action' => 'role', 'show' => true, 'params' => '','id'=>10,'pId'=>''],
        ['name' => '系统设置', 'action' => 'setting', 'show' => true, 'params' => '','id'=>11,'pId'=>''],
        ['name' => '数据统计管理', 'action' => 'caiwu', 'show' => true, 'params' => '','id'=>12,'pId'=>''],
        ['name' => '程序初始化', 'action' => 'init/auth', 'show' => false, 'params' => '','id'=>13,'pId'=>''],
		['name' => '模板消息管理', 'action' => 'mubannews', 'show' => true, 'params' => '','id'=>14,'pId'=>''],
		['name' => 'Gii', 'action' => 'gii', 'show' => true, 'params' => '','id'=>15,'pId'=>''],

        	//分类管理二级
         	['name' => '分类列表', 'action' => 'term/index', 'show' => true, 'params' => '','id'=>1001,'pId'=>1],
            ['name' => '新增分类', 'action' => 'term/create', 'show' => true, 'params' => '','id'=>1002,'pId'=>1 ],
            ['name' => '编辑分类', 'action' => 'term/update', 'show' => true, 'params' => '','id'=>1003,'pId'=>1],
            ['name' => '查看分类', 'action' => 'term/view', 'show' => true, 'params' => '','id'=>1004,'pId'=>1],
            ['name' => '删除分类', 'action' => 'term/delete', 'show' => true, 'params' => '','id'=>1005,'pId'=>1],

            //文字管理二级
         	['name' => '文章列表', 'action' => 'article/index', 'show' => true, 'params' => '','id'=>1006,'pId'=>2],
            ['name' => '新增文章', 'action' => 'article/create', 'show' => true, 'params' => '','id'=>1007,'pId'=>2 ],
            ['name' => '编辑文章', 'action' => 'article/update', 'show' => true, 'params' => '','id'=>1008,'pId'=>2],
            ['name' => '查看文章', 'action' => 'article/view', 'show' => true, 'params' => '','id'=>1009,'pId'=>2],
            ['name' => '删除文章', 'action' => 'article/delete', 'show' => true, 'params' => '','id'=>1010,'pId'=>2],
            ['name' => '发布文章', 'action' => 'article/send', 'show' => true, 'params' => '','id'=>1061,'pId'=>2],
            ['name' => '取消发布', 'action' => 'article/unsend', 'show' => true, 'params' => '','id'=>1062,'pId'=>2],
            ['name' => '上传图片', 'action' => 'article/upload', 'show' => true, 'params' => '','id'=>2062,'pId'=>2],

            //用户项目管理二级
         	['name' => '项目列表', 'action' => 'product/index', 'show' => true, 'params' => '','id'=>1011,'pId'=>3],
            ['name' => '新增项目', 'action' => 'product/create', 'show' => true, 'params' => '','id'=>1012,'pId'=>3 ],
            ['name' => '编辑项目', 'action' => 'product/update', 'show' => true, 'params' => '','id'=>1013,'pId'=>3],
            ['name' => '查看项目', 'action' => 'product/view', 'show' => true, 'params' => '','id'=>1014,'pId'=>3],
            ['name' => '删除项目', 'action' => 'product/delete', 'show' => true, 'params' => '','id'=>1015,'pId'=>3],
            ['name' => '审核项目', 'action' => 'product/shenhe', 'show' => true, 'params' => '','id'=>1063,'pId'=>3],
            ['name' => '取消审核', 'action' => 'product/unshenhe', 'show' => true, 'params' => '','id'=>1064,'pId'=>3],
            ['name' => '拒绝审核', 'action' => 'product/jujue', 'show' => true, 'params' => '','id'=>1065,'pId'=>3],
            ['name' => '取消拒绝', 'action' => 'product/unjujue', 'show' => true, 'params' => '','id'=>1066,'pId'=>3],

            //公司项目管理二级
         	['name' => '项目列表', 'action' => 'yyzc/index', 'show' => true, 'params' => '','id'=>1016,'pId'=>4],
            ['name' => '新增项目', 'action' => 'yyzc/create', 'show' => true, 'params' => '','id'=>1017,'pId'=>4 ],
            ['name' => '编辑项目', 'action' => 'yyzc/update', 'show' => true, 'params' => '','id'=>1018,'pId'=>4],
            ['name' => '查看项目', 'action' => 'yyzc/view', 'show' => true, 'params' => '','id'=>1019,'pId'=>4],
            ['name' => '删除项目', 'action' => 'yyzc/delete', 'show' => true, 'params' => '','id'=>1020,'pId'=>4],

            //会员管理二级
         	['name' => '会员列表', 'action' => 'member/index', 'show' => true, 'params' => '','id'=>1021,'pId'=>5],
            ['name' => '新增会员', 'action' => 'member/create', 'show' => true, 'params' => '','id'=>1022,'pId'=>5 ],
            ['name' => '编辑会员', 'action' => 'member/update', 'show' => true, 'params' => '','id'=>1023,'pId'=>5],
            ['name' => '查看会员', 'action' => 'member/view', 'show' => true, 'params' => '','id'=>1024,'pId'=>5],
            ['name' => '删除会员', 'action' => 'member/delete', 'show' => true, 'params' => '','id'=>1025,'pId'=>5],
			['name' => '发送消息', 'action' => 'member/sendmes', 'show' => true, 'params' => '','id'=>525,'pId'=>5],

            //轮播图二级
         	['name' => '轮播广告列表', 'action' => 'slider/index', 'show' => true, 'params' => '','id'=>1026,'pId'=>6],
            ['name' => '新增轮播广告', 'action' => 'slider/create', 'show' => true, 'params' => '','id'=>1027,'pId'=>6 ],
            ['name' => '编辑轮播广告', 'action' => 'slider/update', 'show' => true, 'params' => '','id'=>1028,'pId'=>6],
            ['name' => '查看轮播广告', 'action' => 'slider/view', 'show' => true, 'params' => '','id'=>1029,'pId'=>6],
            ['name' => '删除轮播广告', 'action' => 'slider/delete', 'show' => true, 'params' => '','id'=>1030,'pId'=>6],
            //用户支付订单二级
         	['name' => '支付列表', 'action' => 'order/index', 'show' => true, 'params' => '','id'=>1031,'pId'=>7],
            ['name' => '新增支付', 'action' => 'order/create', 'show' => true, 'params' => '','id'=>1032,'pId'=>7 ],
            ['name' => '编辑支付', 'action' => 'order/update', 'show' => true, 'params' => '','id'=>1033,'pId'=>7],
            ['name' => '查看支付', 'action' => 'order/view', 'show' => true, 'params' => '','id'=>1034,'pId'=>7],
            ['name' => '删除支付', 'action' => 'order/delete', 'show' => true, 'params' => '','id'=>1035,'pId'=>7],
            //发货订单管理二级
         	['name' => '订单列表', 'action' => 'invoice/index', 'show' => true, 'params' => '','id'=>1036,'pId'=>8],
            ['name' => '新增订单', 'action' => 'invoice/create', 'show' => true, 'params' => '','id'=>1037,'pId'=>8 ],
            ['name' => '编辑订单', 'action' => 'invoice/update', 'show' => true, 'params' => '','id'=>1038,'pId'=>8],
            ['name' => '查看订单', 'action' => 'invoice/view', 'show' => true, 'params' => '','id'=>1039,'pId'=>8],
            ['name' => '删除订单', 'action' => 'invoice/delete', 'show' => true, 'params' => '','id'=>1040,'pId'=>8],
            ['name' => '发货', 'action' => 'invoice/fahuo', 'show' => true, 'params' => '','id'=>1067,'pId'=>8],
            //用户管理二级
         	['name' => '用户列表', 'action' => 'user/index', 'show' => true, 'params' => '','id'=>1041,'pId'=>9],
            ['name' => '新增用户', 'action' => 'user/create', 'show' => true, 'params' => '','id'=>1042,'pId'=>9 ],
            ['name' => '编辑用户', 'action' => 'user/update', 'show' => true, 'params' => '','id'=>1043,'pId'=>9],
            ['name' => '查看用户', 'action' => 'user/view', 'show' => true, 'params' => '','id'=>1044,'pId'=>9],
            ['name' => '删除用户', 'action' => 'user/delete', 'show' => true, 'params' => '','id'=>1045,'pId'=>9],

               //角色管理二级
          ['name' => '角色列表', 'action' => 'role/index', 'show' => true, 'params' => '','id'=>1046,'pId'=>10],
            ['name' => '新增角色', 'action' => 'role/create', 'show' => true, 'params' => '','id'=>1047,'pId'=>10 ],
            ['name' => '编辑角色', 'action' => 'role/update', 'show' => true, 'params' => '','id'=>1048,'pId'=>10],
            ['name' => '查看角色', 'action' => 'role/view', 'show' => true, 'params' => '','id'=>1049,'pId'=>10],
            ['name' => '删除角色', 'action' => 'role/delete', 'show' => true, 'params' => '','id'=>1050,'pId'=>10],

               //系统管理二级
          ['name' => '系统列表', 'action' => 'setting/index', 'show' => true, 'params' => '','id'=>1051,'pId'=>11],
            ['name' => '新增系统', 'action' => 'setting/create', 'show' => true, 'params' => '','id'=>1052,'pId'=>11 ],
            ['name' => '编辑系统', 'action' => 'setting/update', 'show' => true, 'params' => '','id'=>1053,'pId'=>11],
            ['name' => '查看系统', 'action' => 'setting/view', 'show' => true, 'params' => '','id'=>1054,'pId'=>11],
           // ['name' => '删除系统', 'action' => 'setting/delete', 'show' => true, 'params' => '','id'=>1055,'pId'=>11],

               //财务管理二级
          ['name' => '产品热度统计', 'action' => 'caiwu/index', 'show' => true, 'params' => '','id'=>1056,'pId'=>12],
            ['name' => '产品收支统计', 'action' => 'caiwu/shouzhi', 'show' => true, 'params' => '','id'=>1057,'pId'=>12 ],
            ['name' => '产品完成度统计', 'action' => 'caiwu/wanchengdu', 'show' => true, 'params' => '','id'=>1058,'pId'=>12],
            ['name' => '编辑支出', 'action' => 'caiwu/zhichu_money', 'show' => true, 'params' => '','id'=>1059,'pId'=>12],
            ['name' => '删除财务', 'action' => 'caiwu/delete', 'show' => true, 'params' => '','id'=>1060,'pId'=>12],
			
			//模板消息管理二级
         	['name' => '分类列表', 'action' => 'mubannews/index', 'show' => true, 'params' => '','id'=>1401,'pId'=>14],
            ['name' => '新增分类', 'action' => 'mubannews/create', 'show' => true, 'params' => '','id'=>1402,'pId'=>14 ],
            ['name' => '编辑分类', 'action' => 'mubannews/update', 'show' => true, 'params' => '','id'=>1403,'pId'=>14],
            ['name' => '查看分类', 'action' => 'mubannews/view', 'show' => true, 'params' => '','id'=>1404,'pId'=>14],
            ['name' => '删除分类', 'action' => 'mubannews/delete', 'show' => true, 'params' => '','id'=>1405,'pId'=>14],
       ],
	   
		
];
