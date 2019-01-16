<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\common\model\Type;
use app\common\model\Goods;
use app\tools\Cattree;

class GoodsController extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function show()
    {
        $search=[];
        if(!empty($_GET['shopname']))
        {
            $search[]=['shopname','like',"%{$_GET['shopname']}%"];
        }
        if(!empty($_GET['status']))
        {
             $search[]=['status','=',"{$_GET['status']}"];
        }
        $data=Goods::where($search)->paginate(3)->appends($_GET);
        return view('Goods/goodsshow',['data'=>$data]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $data=Type::select();
        $c=new Cattree($data);
        $data=$c->getTree();
        // dump($data);
        return view('Goods/goodscreate',['data'=>$data]);
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
        //获取上传文件
        $file=$request->file('pic');
        //移动图片路径
        $info=$file->move('image');//存放图片文件夹
        //获取图片名字
        $filename=$info->getSaveName();
       
        
        // 缩放图片
        // $image=\think\Image::open('image/'.$filename);
        // $newfilename=str_replace('\\','/suo_',$filename);
        // $image->thumb(150,150)->save('image/'.$newfilename);
        // dump($filename);
        // $name=explode('\\',$filename);
        // dump($name);

        // $del='image/'.$name[0].'/'.$name[1];
        // unlink($del);
         $data['pic']=$filename;
         // dump($data);
         // die;
        try {
            Goods::create($data,true);
        } catch (\Exception $e) {
            return $this->error('添加失败');
        }
        return $this->success('添加成功','/admin/goods_show');
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $data=Type::select();
        $c=new Cattree($data);
        $data=$c->getTree();
        $row=Goods::find($id);
        // dump($row);
        // die();
        return view('Goods/updategoods',['data'=>$data,'row'=>$row]);
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
                $res =Goods::find($id);
                $newname = 'image/'.$res['pic'];
                unlink($newname);
                //获取图片名字
                $filename=$info->getSaveName();
                $data['pic'] = $filename;
               
            }else{
                $res =Goods::find($id);
                $data['pic'] = $res['pic'];
            }
        }
        try {
              Goods::update($data,['id'=>$id]);
        } catch (\Exception $e) {
                return $this->error('修改失败！','/admin/goods_edit');
        }

            return $this->success('修改成功','/admin/goods_show');

    }


    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {   

        $res =Goods::find($id);
        $raw='image/'.$res['pic'];
        unlink($raw);
        $data = Goods::destroy($id);
        if($data)
        {
            return $this->success('删除成功！','/admin/goods_show');
        }else{
            return $this->error('删除失败！','/admin/goods_show');
       }
    }
}
