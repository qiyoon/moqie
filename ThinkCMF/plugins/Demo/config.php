<?php
// +----------------------------------------------------------------------
// | TIGO [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.tigonetwork.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
return array (
	'text' => array (// 在后台插件配置表单中的键名 ,会是config[text]
		'title' => '文本:', // 表单的label标题
		'type' => 'text',// 表单的类型：text,password,textarea,checkbox,radio,select等
		'value' => 'hello,TIGO!',// 表单的默认值
		'tip' => '这是文本组件的演示' //表单的帮助提示
	),
	'password' => array (// 在后台插件配置表单中的键名 ,会是config[password]
		'title' => '密码:',
		'type' => 'password',
		'value' => '',
		'tip' => '这是密码组件' 
	),
	'select' => array (// 在后台插件配置表单中的键名 ,会是config[select]
		'title' => '下拉列表:',
		'type' => 'select',
		'options' => array (//select 和radio,checkbox的子选项
			'1' => 'TIGOX',// 值=>显示
			'2' => 'TIGO',
			'3' => '跟猫玩糗事',
			'4' => '门户应用' 
		),
		'value' => '1',
		'tip' => '这是下拉列表组件' 
	),
	'checkbox' => array (
		'title' => '多选框',
		'type' => 'checkbox',
		'options' => array (
			'1' => 'genmaowan.com',
			'2' => 'www.tigonetwork.com' 
		),
		'value' => 1,
		'tip' => '这是多选框组件' 
	),
	'radio' => array (
		'title' => '单选框',
		'type' => 'radio',
		'options' => array (
			'1' => 'TIGOX',
			'2' => 'TIGO' 
		),
		'value' => '1',
		'tip' => '这是单选框组件' 
	),
	'textarea' => array (
		'title' => '多行文本',
		'type' => 'textarea',
		'value' => '这里是你要填写的内容',
		'tip' => '这是多行文本组件' 
	) 
);
					