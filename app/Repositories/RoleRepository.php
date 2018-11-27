<?php 
namespace App\Repositories;

use App\Role;
use App\Permission;


class RoleRepository extends BaseRepository
{
	//获取角色的所有数据
	public function getRoleFeelds()
	{
		return Role::orderBy('created_at','desc')->paginate(5);
	}

	//获取角色的总数
	public function roleCount()
	{
		return Role::count();
	}

	//判断角色是否唯一性
	public function roleUnique($field)
	{
		return Role::where('r_name',$field)->count();
	}

	//数据标准
	public function normData($d,$id)
	{
		//获取权限的路由
		error_reporting(0);
		$ps_ca = Permission::select(\DB::raw("concat(ps_c,'-',ps_a) as ca"))
						->whereIn('ps_id',$d)
						->whereIn('ps_level',[1,2])
						->pluck('ca');
	
		$data = [
			'ps_ca'=>implode(',',$ps_ca->toArray()),
			'ps_ids'=>implode(',',$d),
		];
		return $data;
	}
}