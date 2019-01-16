<?php

namespace app\common\model;

use think\Model;

class User extends Model
{
    //数据表明
    protected $table = 'user';
    //表主键
    protected $pk = 'uid';

    public function setPwdAttr($pwd)
    {
    	return md5($pwd);
    }
    
}
