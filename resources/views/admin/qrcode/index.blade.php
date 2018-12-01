@extends('admin/common/master')
@section('title','权限')
@section('content')
<link rel="stylesheet" href="/admin/layui/css/layui.css" media="all">
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 支付配置 <span class="c-gray en">&gt;</span> 二维码配置 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="panel panel-default">
	<div class="panel-header">二维码放置区</div>
		<div class="panel-body">
			<form action="" method="post" class="form form-horizontal" id="form-member-add">
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2"></label>
					<div class="formControls col-xs-8 col-sm-9"> 
						<img src="{{$pic->picture}}" id="pathinfo" style="width: 300px;">
					</div>
				</div>
				<div class="mt-40"></div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2"></label>
					<div class="formControls col-xs-8 col-sm-9"> 
						<button type="button" class="layui-btn" id="test1">
						<i class="layui-icon">&#xe67c;</i>上传图片
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
@section('my-js')
<script type="text/javascript" src="/admin/layui/layui.all.js"></script> <!--/_footer 作为公共模版分离出去-->
<script>
layui.use('upload', function(){
  var upload = layui.upload;
   
  //执行实例
  var uploadInst = upload.render({
    elem: '#test1' //绑定元素
    ,url: '/qrcode/images' //上传接口
    ,accept: 'images'
    ,method: 'post'
    ,headers: {
    	'X-CSRF-TOKEN':"{{csrf_token()}}"
    }
    ,done: function(res){
      if(res.code == 1){
      	$('#pathinfo').attr('src',res.path);
      }
      if(res.code == 0){
      	layer.alert(res.error,{'title':'提示信息'});
      }
      console.log(res);
    }
    ,error: function(){
      //请求异常回调
    }
  });
});
</script>
@endsection