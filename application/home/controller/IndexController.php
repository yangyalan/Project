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

class IndexController extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        
        $session=session('home');
        $type=Type::select();
        $c=new Cattree($type);
        $type=$c->getTree();
        $hot=Goods::select();
        // dump($hot);
        return view('Index/index',['data'=>$session,'type'=>$type,'hot'=>$hot]);
    }

}
