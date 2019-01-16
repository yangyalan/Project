<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\common\model\User;

class UserController extends Controller
{

    //加载添加用户数据页面
    public function create()
    {
        // $data=User::select();
        // dump($data);
        return view('User/usercreate');
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
        // dump($data['pwd']);
        // dump($data['repwd']);
        $validate=new \app\admin\validate\User;
        if  (!$validate->check($data))  {                      
            return $this->error($validate->getError()); 
        }   
        if($data['pwd'] != $data['repwd'])
        {
            return $this->error('密码不一致','/admin/user_create');
            die();
        }  
       
        try {
             User::create($data,true);
        } catch (\Exception $e) {
            return $this->error('添加失败','/admin/user_create');
        }
        
             $this->success('添加成功','/admin/user_show');
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
    public function show()
    {
        $search=[];
        if(!empty($_GET['username']))
        {
            $search[]=['username','like',"%{$_GET['username']}%"];
        }
        if(!empty($_GET['level']))
        {
             $search[]=['level','=',"{$_GET['level']}"];
        }
         $search[]=['status','=','1'];
        $data=User::where($search)->paginate(3)->appends($_GET);
        // dump($data);
        return view('/User/usershow',['data'=>$data]);
    }
    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $data= User::find($id);
        // dump($data);
        return view('/User/edit',['data'=>$data]);
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
        // dump($request->post());
        // dump($id);
        $data=$request->post();
        $validate=new \app\admin\validate\User;
        if  (!$validate->check($data))  {                      
            return $this->error($validate->getError()); 
        }   
        try {
            User::update($data,['uid'=>$id]);
        } catch (\Exception $e) {
            return $this->error('修改失败！','/admin/user_edit');
        }

        return $this->success('修改成功','/admin/user_show');
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
       // dump($id);
       $data = User::destroy($id);
       if($data)
       {
            return $this->success('删除成功！','/admin/user_show');
       }else{
             return $this->error('删除失败！','/admin/user_show');
       }
    }

    public function pwd($id)
    {
        dump($id);
        $data= User::find($id);
        return view('/User/pwd',['data'=>$data]);
    }
    public function pwdupdate(Request $request, $id)
    {
        $row=User::find($id);
        // dump($row);
        $res=$request->post();
        $res['oldpwd']=md5($res['oldpwd']);
        $res['pwd']=md5($res['pwd']);
        // dump($res['oldpwd']);
        // die();
        if($res['oldpwd'] != $row['pwd'])
        {
            return $this->error('原密码输入错误');
        }
        if($res['oldpwd'] == $res['pwd'])
        {
             return $this->error('新密码与原密码相同');
        }
         try {
            User::update($res,['uid'=>$id]);
        } catch (\Exception $e) {
            return $this->error('修改失败');
        }

        return $this->success('修改成功','/admin/user_show');
    }

    public function status(Request $request, $id)
    {
        $enable = User::find($id);
       // dump($enable);
       $status = [];
       if ($enable['status'] == 1) {
            $status['status'] = 2;
                $s = "禁用";
       }else{
            $status['status'] = 1;
                $s = "启用";
       }
       try {
             User::update($status,['uid'=>$id]);
        } catch (Exception $e) {
            return $this->error('/admin/user_show');
        }
            return $this->redirect('/admin/user_show');
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
        return json_encode(['status'=>200]);
    }
}
