<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});
//和后台登录
Route::rule('/admin/index_login','admin/IndexController/login');
//判断用户名是否正确
Route::rule('/admin/search_name', 'admin/UserController/search_name');
//验证码
Route::rule('/admin/code', 'admin/IndexController/code');
//用户登录密码
Route::rule('/admin/dologin','admin/IndexController/dologin');
//后台首页
Route::rule('/admin/index_index','admin/IndexController/index')->middleware('CheckAdmin');
//后台加载用户添加
Route::get('/admin/user_create','admin/UserController/create')->middleware('CheckAdmin');
//处理添加的用户数据
Route::rule('/admin/user_save','admin/UserController/save')->middleware('CheckAdmin');
//用户数据显示 
Route::rule('/admin/user_show','admin/UserController/show')->middleware('CheckAdmin'); 
//删除用户
Route::rule('/admin/user_delete/:id','admin/UserController/delete')->middleware('CheckAdmin'); 
//加载修改用户信息页面
Route::rule('/admin/user_edit/:id','admin/UserController/edit')->middleware('CheckAdmin'); 
//处理修改用户数据
Route::rule('/admin/user_update/:id','admin/UserController/update')->middleware('CheckAdmin'); 
//加载密码页面
Route::rule('/admin/user_pwd/:id','admin/UserController/pwd')->middleware('CheckAdmin'); 
//处理修改密码数据
Route::rule('/admin/user_pwdupdate/:id','admin/UserController/pwdupdate')->middleware('CheckAdmin'); 
//用户的启用于禁用
Route::rule('/admin/user_status/:id','admin/UserController/status')->middleware('CheckAdmin'); 
//分类组管理
Route::group(['name'=>'/admin/','prefix'=>'admin/TypeController/'],function()
{
	//分类显示
	Route::rule('type_show','show','get');
	//分类添加页面 
	Route::rule('type_create/[:id]','create');
	//处理添加分类数据
	Route::rule('type_save','save');
	//加载修改分类页面
	Route::rule('type_edit/:id','edit');
	//处理修改分类数据
	Route::rule('type_update/:id','update');
	//删除分类
	Route::rule('type_delete/:id','delete');
})->middleware('CheckAdmin');
//商品组管理
Route::group(['name'=>'/admin/','prefix'=>'admin/GoodsController/'],function()
{
	//商品显示
	Route::rule('goods_show','show','get');
	//商品添加页面 
	Route::rule('goods_create','create');


	//处理添加商品数据
	Route::rule('goods_save','save');
	//加载修改商品页面
	Route::rule('goods_edit/:id','edit');
	//处理修改商品数据
	Route::rule('goods_update/:id','update');
	//删除分类
	Route::rule('goods_delete/:id','delete');
})->middleware('CheckAdmin');
// 网站配置组管理
Route::group(['name'=>'/admin/','prefix'=>'admin/ConfigController/'],function()
{
	//网站配置显示
	Route::rule('config_show','show','get');
	//网站配置添加页面 
	Route::rule('config_create','create');
	//网站配置添加商品数据
	Route::rule('config_save','save');
	//网站配置修改商品页面
	Route::rule('config_edit/:id','edit');
	//网站配置修改商品数据
	Route::rule('config_update/:id','update');
	//网站配置分类
	Route::rule('config_delete/:id','delete');
	//禁用启用
	Route::rule('config_status/:id','status');
})->middleware('CheckAdmin');
// 友情链接配置组管理
Route::group(['name'=>'/admin/','prefix'=>'admin/FriendController/'],function()
{
	//友情链接配置显示
	Route::rule('friend_show','show','get');
	//友情链接配置添加页面 
	Route::rule('friend_create','create');
	//友情链接配置添加商品数据
	Route::rule('friend_save','save');
	//友情链接配置修改商品页面
	Route::rule('friend_edit/:id','edit');
	//友情链接配置修改商品数据
	Route::rule('friend_update/:id','update');
	//友情链接配置分类
	Route::rule('friend_delete/:id','delete');
	//禁用启用
	Route::rule('friend_status/:id','status');
})->middleware('CheckAdmin');


//前台路由
Route::group(['name'=>'/home/','prefix'=>'home/IndexController/'],function()
{
	//前台首页显示
	Route::rule('index_index','index');
});
//前台注册
Route::group(['name'=>'/home/','prefix'=>'home/RegisterController/'],function()
{
	//前台首页显示
	Route::rule('register_create','create');
	//
	Route::rule('register_save','save');
	Route::rule('register_name','register
		');
});
//前台登录
Route::group(['name'=>'/home/','prefix'=>'home/LoginController/'],function()
{
	//前台登录显示
	Route::rule('denglu','create');
	//前台推出
	Route::rule('exit','tuichu');
});

//判断用户名是否正确
Route::rule('/home/search_name', 'home/LoginController/search_name');
//判断密码是否正确
Route::rule('/home/search_pwd', 'home/LoginController/search_pwd');
//商品组
Route::group(['name'=>'/home/','prefix'=>'home/ProductController/'],function()
{
	//商品列表显示
	Route::rule('product_list/[:id]','index');
	//商品单个显示
	Route::rule('product_single/:id','single');
});

