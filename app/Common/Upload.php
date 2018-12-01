<?php 
namespace App\Common;

use OSS\OssClient;
use OSS\Core\OssException;
/**
 * 图片上传工具类
 */
class Upload
{
	protected $file;
	protected $filename;
	protected $max_size = 1000000;
	protected $allow_format = ['jpeg','png','jpg'];

	public function __construct($file)
	{
		$this->file = $file;
	}

	//上传方法
	public function up()
	{
		//获取到后缀判断是否符合要求
		$res = $this->check_allow_format();
		if(!$res){
			return ['code'=>config('code.error'),'error'=>'文件的格式为jpg,png,jpeg'];
		}

		//判断文件大小是否符合要求
		$res = $this->check_max_size();
		if(!$res){
			return ['code'=>config('code.error'),'error'=>'文件大小为1000000b'];
		}

		//生成新的文件名称
		$this->filename = date('YmdHis',time()).time().'.'.$this->ext;

		$basepath = "./upload/". date('m-d',time());

		if(!is_dir($basepath)){
			mkdir($basepath,0777,true);
		}
		$pathinfo = $basepath . '/' . $this->filename;

		move_uploaded_file($this->file['tmp_name'],$pathinfo);
		$show_path = ltrim($pathinfo,'.');
		return ['code'=>config('code.success'),'data'=>$show_path];
	}

	//检查文件大小
	public function check_max_size()
	{
		if($this->file['size'] > $this->max_size){
			return false;
		}
		return true;
	}

	//判断文件的后缀是否符合要求
	public function check_allow_format()
	{
		$arr = explode('.',$this->file['name']);
		if( !in_array($arr['1'],$this->allow_format) ){
			return false;
		}
		$this->ext = $arr['1'];
		return true;
	}

}
