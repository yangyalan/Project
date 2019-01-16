<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\common\model\Friend;

class FriendController extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function show()
    {
        $search=[];
        if(!empty($_GET['linkname']))
        {
            $search[]=['linkname','like',"%{$_GET['linkname']}%"];
        }
        if(!empty($_GET['status']))
        {
             $search[]=['status','=',"{$_GET['status']}"];
        }
         // $search[]=['status','=','1'];
        $data=Friend::where($search)->paginate(3)->appends($_GET);
        return view('/Friend/showfriend',['data'=>$data]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return view('/Friend/createfriend');
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
        $validate=new \app\admin\validate\Friend;
        if  (!$validate->check($data))  {                      
            return $this->error($validate->getError()); 
        } 
        //获取上传文件
        $file=$request->file('pic');
        //移动图片路径
        $info=$file->move('image');//存放图片文件夹
        //获取图片名字
        $filename=$info->getSaveName();
        $data['pic']=$filename;
        // dump($data);
        // die;
        try {
            Friend::create($data,true);
        } catch (\Exception $e) {
            return $this->error('添加失败');
        }
        return $this->success('添加成功','/admin/friend_show');
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
        $row=Friend::find($id);
        return view('/Friend/updatefriend',['row'=>$row]);
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
        $data=$request->post();
        $validate=new \app\admin\validate\Friend;
        if  (!$validate->check($data))  {                      
            return $this->error($validate->getError()); 
        } 
        // dump($data);
        $file=$request->file();
        // dump($_FILES['pic']['name']);
        // die();
        if(!empty($_FILES['pic']['name'])){
            if(is_array($file)){
                $files = $request->file('pic');
                $info=$files->move('image');//移动图片路径 //存放图片文件夹
                // halt($info);
                $res =Friend::find($id);
                $newname = 'image/'.$res['pic'];
                unlink($newname);
                //获取图片名字
                $filename=$info->getSaveName();
                $data['pic'] = $filename;
               
            }else{
                $res =Friend::find($id);
                $data['pic'] = $res['pic'];
            }
        }
        try {
              Friend::update($data,['id'=>$id]);
        } catch (\Exception $e) {
                return $this->error('修改失败！','/admin/friend_edit');
        }

            return $this->success('修改成功','/admin/friend_show');
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $data = Friend::destroy($id);
       if($data)
       {
            return $this->success('删除成功！','/admin/friend_show');
       }else{
             return $this->error('删除失败！','/admin/friend_show');
       }
    }
    
     public function status(Request $request, $id)
    {
        $enable = Friend::find($id);
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
             Friend::update($status,['id'=>$id]);
        } catch (Exception $e) {
            return $this->error('/admin/friend_show');
        }
            return $this->redirect('/admin/friend_show');
    }
}
