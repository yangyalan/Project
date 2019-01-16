<?php

namespace app\home\controller;

use think\Controller;
use think\Request;
use app\common\model\User;

class LoginController extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return view('/Login/login');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
    public function search_name()
    {
        $name=$_GET['username'];
        // dump($name);
        $data=User::where('username','=',$name)->find();
        if(empty($data))
        {

            return json_encode(['status'=>400]);
        }
        session('loginhome',true);
        session('home',$data);
        return json_encode(['status'=>200]);
    }
    public function search_pwd()
    {
        $pwd=md5($_GET['pwd']);
        // dump($name);
        $data=User::where('pwd','=',$pwd)->find();
        if(empty($data))
        {
            return json_encode(['status'=>400]);
        }
        return json_encode(['status'=>200]);
    }

    public function tuichu()
    {   
        session('home',null);
        $this->redirect('/home/index_index');
    }
}
