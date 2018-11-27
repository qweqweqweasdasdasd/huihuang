<?php 
namespace App\Repositories;

use App\Permission;

class PermissionRepository extends BaseRepository
{
	//获取到权限的层级列表(树形结构)
	public function getPnameTree()
	{
		return generateTree(Permission::get()->toArray());
	}

	//获取到权限的总数
	public function count()
	{
		return Permission::count();
	}

	//判断权限名称是否一致
	public function permissionUique($psName)	 //重复return true 不重复 return false
	{
		return Permission::where('ps_name',$psName)->count();
	}

	//设置权限分级数字
	public function setLevel($data)
	{
		$level = Permission::where('ps_id',$data['ps_pid'])->value('ps_level');
		$data['ps_level'] = (string)(Permission::where('ps_id',$data['ps_pid'])->value('ps_level')+1);
		$data['created_at'] = date('Y-m-d H:i:s',time());
		return $data;
	}

	//是否有父类的元素		// 存在 => true && 不存在 => false
	public function isHaveFather($id)
	{
		return !!(Permission::where('ps_pid',$id)->count());		
	}

	//获取指定的层级权限
	public function permission_level($n)
	{
		return Permission::where('ps_level',$n)->orderBy('created_at','desc')->get();
	}
}