<?php

namespace app\home\controller;

use think\Controller;
use think\Request;
use app\common\model\User;

class RegisterController extends Controller
{
   
    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return view('/Register/register');
    }

     public function register()
    {
        $name=$_GET['username'];
        // dump($name);
        $data=User::where('username','=',$name)->find();
        if(empty($data))
        {

            return json_encode(['status'=>400]);
        }
        return json_encode(['status'=>200]);
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        
        $data=$request->post();
        // dump($data);
        $validate=new \app\admin\validate\User;
        if  (!$validate->check($data))  {                      
            return $this->error($validate->getError()); 
        }   
        if($data['pwd'] != $data['repwd'])
        {
            return $this->error('密码不一致','/home/register_create');
            die();
        }  
       
        try {
             User::create($data,true);
        } catch (\Exception $e) {
            return $this->error('添加失败','/home/register_create');
        }
            
             session('loginhome',true);
             session('home',$data);
             echo '<script>
                alert("注册成功");
            </script>';
             // $this->display('/home/index_index');
             $this->redirect('/home/index_index');

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
}
