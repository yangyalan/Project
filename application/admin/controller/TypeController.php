<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\common\model\Type;
use app\tools\Cattree;
class Typecontroller extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function show()
    {
        $search=[];
        if(!empty($_GET['name']))
        {
            $biaoshi=1;
            // dump($_GET);
            $search[]=['name','like',"%{$_GET['name']}%"];
            // dump($search);
            $res=Type::where($search)->select();
           
        }else{
            $biaoshi=0;
            $data=Type::select();
            $c=new Cattree($data);
            $res=$c->getTree();
        }
        // dump($search);
        
        // dump($res);
        return view('/Type/typeshow',['data'=>$res,'biaoshi'=>$biaoshi]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create($id='')
    {
        $data=Type::select();
        $c=new Cattree($data);
        $res=$c->getTree();
        return view('Type/typecreate',['data'=>$res,'id'=>$id]);
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
        // die();
        try {
            Type::create($data,true);
        } catch (\Exception $e) {
            return $this->error('添加失败','/admin/type_show');
        }
        return $this->success('添加成功','/admin/type_show');
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
        $data=Type::find($id);
        return view('/Type/typeupdate',['data'=>$data]);
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
        try {
            Type::update($data,['id'=>$id]);
        } catch (\Exception $e) {
            return $this->error('修改失败！','/admin/type_edit');
        }

        return $this->success('修改成功','/admin/type_show');
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        // echo 11;
        $data=Type::where(['pid'=>$id])->find();
        // dump($data);
        if($data['pid'] == $id)
        {
            $this->error('分类下有子分类不可以删除');
        }
            
        $data=Type::destroy($id);
        if($data){
           return $this->success('删除成功','/admin/type_show');
        
        }else{
            return $this->error('删除失败','/admin/type_show');
        
        }

    }
}
