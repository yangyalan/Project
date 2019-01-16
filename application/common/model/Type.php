<?php

namespace app\common\model;

use think\Model;

class Type extends Model
{
    //数据表名
    protected $table='data_type';
    //主键
    protected $pk='id';

    public function getTypenameAttr()
    {					
    	$n=substr_count($this->path,',')-1;
		$space=str_repeat('|-->',$n);
		$name=$space.$this['name'];
		// dump($this['name']);die();

		return $name;
    }
}
