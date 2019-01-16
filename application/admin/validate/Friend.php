<?php

namespace app\admin\validate;

use think\Validate;

class Friend extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'linkname'=>'max:12',
        'url' => 'require|length:12,30',


    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        
        'linkname.max'=>'链接名最长位4位',
        'url.require'=>'地址不允许为空',
        'url.max'=>'地址长为10-30',


    ];
}
