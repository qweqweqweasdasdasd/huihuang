<?php 
namespace App\Repositories;

use DB;

class BaseRepository
{
	public $model = '';
	public $id = '';
	public $page = '';
	public $size = '';
	public $form = '';

	//创建数据通用方法
	public function BaseSave($d)
	{
		return DB::table($this->model)->insert($d);
	}

	//删除指定的数据(模拟删除数据)
	public function BaseDelete($id)
	{
		return DB::table($this->model)->where($this->id,$id)->update(['deleted_at'=>date('Y-m-d H:i:s')]);
	}

	//获取指定的一条数据
	public function getInfoById($id)
	{
		return DB::table($this->model)->where($this->id,$id)->first();
	}

	//更新指定的数据
	public function updateByIdWithData($d,$id)
	{	
		return DB::table($this->model)->where($this->id,$id)->update($d);
	}

	//通过id批量删除数据
	public function baseDeleteAll($ids)
	{
		foreach ($ids as $k => $v) {
			$this->BaseDelete($v);
		}
		return true;
	}

	//公共修改状态
	public function BaseSetStatus($data)
	{

		$data['_status'] == 1? $data['_status'] = 2 : $data['_status'] = 1;


		return DB::table($this->model)->where($this->id,$data['mg_id'])->update(['status'=>$data['_status']]);
	}

	//通用分页规则 当前页 和显示多少
	public function currPageAndSize($data)
	{
		 //分页逻辑 当前页
        $this->page = !empty($data['page']) ? $data['page'] : '1';
        //显示的数量
        $this->size = !empty($data['size']) ? $data['size'] : config('code.size');
        //起始位置
        $this->form = ($this->page-1) * $this->size;
	}
}