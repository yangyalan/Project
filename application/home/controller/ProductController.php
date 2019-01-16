<?php

namespace app\home\controller;

use think\Controller;
use think\Request;
use think\Session;
use app\common\model\Goods;
use app\common\model\User;
use app\common\model\Type;
use app\common\model\Friend;
use app\common\model\Config;
use app\tools\Cattree;

class ProductController extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index($id="")
    { 
        $session=session('home');
        $search = [];
        if(!empty($id)){
            $selec = Type::where('pid','=',$id)->column('id');
            $selec[] = (int)$id;
            $search[] = ['type_id', 'in' ,$selec];
        }
        $hot = Goods::where( $search )->select();
        $type = Type::select();
        // dump($hot);
        return view('/Product/list',['data'=>$session,'type'=>$type,'hot'=>$hot]);
    }

    public function single($id)
    {
        $session=session('home');
        $type=Type::select();
        $c=new Cattree($type);
        $type=$c->getTree();
        $hot=Goods::find($id);
        dump($hot);
        return view('/Product/single',['data'=>$session,'type'=>$type,'hot'=>$hot]);
    }
}
