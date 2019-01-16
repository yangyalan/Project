<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\common\model\Config;

class ConfigController extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function show()
    {
        $data=Config::select();
        return view('/Config/showconfig',['data'=>$data]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return view('/Config/createconfig');
    }

    /**1
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $data=$request->post();
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
            Config::create($data,true);
        } catch (\Exception $e) {
            return $this->error('添加失败');
        }
        return $this->success('添加成功','/admin/config_show');
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function status(Request $request, $id)
    {
        $enable = Config::find($id);
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
             Config::update($status,['id'=>$id]);
        } catch (Exception $e) {
            return $this->error('/admin/config_show');
        }
            return $this->redirect('/admin/config_show');
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $row=Config::find($id);
        return view('/Config/updateconfig',['row'=>$row]);
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
        // dump($data);
        $file=$request->file();
        // dump($_FILES['pic']['name']);
        // die();
        if(!empty($_FILES['pic']['name'])){
            if(is_array($file)){
                $files = $request->file('pic');
                $info=$files->move('image');//移动图片路径 //存放图片文件夹
                // halt($info);
                $res =Config::find($id);
                $newname = 'image/'.$res['pic'];
                unlink($newname);
                //获取图片名字
                $filename=$info->getSaveName();
                $data['pic'] = $filename;
               
            }else{
                $res =Config::find($id);
                $data['pic'] = $res['pic'];
            }
        }
        try {
              Config::update($data,['id'=>$id]);
        } catch (\Exception $e) {
                return $this->error('修改失败！','/admin/config_edit');
        }

            return $this->success('修改成功','/admin/config_show');
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
