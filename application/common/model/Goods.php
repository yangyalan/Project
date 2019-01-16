<?php

namespace app\common\model;

use think\Model;
use app\common\model\Type;

class Goods extends Model
{
    //数据表名
    protected $table='data_goods';
    //主键
    protected $pk='id';
    //关联查询 分类名字
    public function typelink()
    {
    	//关联模型            
    	return $this->belongsTo('Type','type_id','id');
    }

    //关联查询 所有商品
    // public function shop()
    // {
    //     //关联模型            
    //     return $this->belongsTo('Type','type_id','id');
    // }
}
