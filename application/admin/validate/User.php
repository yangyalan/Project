<?php

namespace app\admin\validate;

use think\Validate;

class User extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [

        'username' => 'require|max:10|min:4',
        'pwd'      => 'length:4,10',
        'phone'    => 'number|max:11',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'username.require' => '用户名不允许为空',
        'username.max' => '用户名不能超过10位',
        'username.min' => '用户名最少为4位',
        'pwd.length' => '密码要在4-10位之间',
        'phone.number'=> '手机号只能是数字',
        'phone.max'=> '手机号格式不正确',
    ];
}
