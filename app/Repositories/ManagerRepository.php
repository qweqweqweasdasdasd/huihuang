<?php 
namespace App\Repositories;

use Hash;
use App\Role;
use App\Manager;

class ManagerRepository extends BaseRepository
{
	//判断管理员是否修改了密码
	public function changePassword($password,$id) //true => 修改了 false => 没有修改
	{
		if( $password != Manager::where('mg_id',$id)->value('password') ){
			return true;
		}
		return false;
	}

	//判断用户的密码是否一致	 true => 密码一致  &&  false => 密码不一致
	public function checkPasswordSameById($id,$password)
	{
		$passworded = Manager::find($id)->password;
		if(Hash::check($password,$passworded)){
			return true;
		};
		return false;
	}

	//获取到角色和角色id
	public function roleNameAndId()
	{
		return Role::orderBy('created_at','desc')->pluck('r_name','r_id');
	}

	//判断管理员是否唯一 存款为true 不存在为false
	public function managerUnique($field)
	{
		return Manager::where('mg_name',$field)->count();
	}

	//获取所有的数据
	public function getManagerByCondition($condition,$form,$size)
	{

		return Manager::with('role')->where(function($query) use($condition){
							if(  !empty($condition['datemin']) && !empty($condition['datemax']) && ($condition['datemax']>$condition['datemin']) ){
								$query->where('created_at','>',$condition['datemin'])
									  ->where('created_at','<',$condition['datemax']);
							}

							if( !empty($condition['key']) ){
								$query->where(['mg_name'=>$condition['key']]);
							}
						})
						->limit($size)	//
						->offset($form)	//
						->get();
	}

	//获取总数
	public function getManagerByCondetionCount($condition)
	{
		return Manager::where(function($query) use($condition){
							if(  !empty($condition['datemin']) && !empty($condition['datemax']) && ($condition['datemax']>$condition['datemin']) ){
								$query->where('created_at','>',$condition['datemin'])
									  ->where('created_at','<',$condition['datemax']);
							}

							if( !empty($condition['key']) ){
								$query->where(['mg_name'=>$condition['key']]);
							}
						})->count();
	}
}