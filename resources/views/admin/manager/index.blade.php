@extends('admin/common/master')
@section('title','管理员')
@section('my-css')
<link rel="stylesheet" type="text/css" href="/admin/h-ui/static/h-ui.admin/css/page.css">
@endsection
@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 管理员列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<form>
		<div class="text-c"> 日期范围：
			<input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" class="input-text Wdate" style="width:120px;" name="datemin" value="{{$datemin}}">
			-
			<input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" class="input-text Wdate" style="width:120px;" name="datemax" value="{{$datemax}}">
			<input type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" id="" name="key" value="{{$key}}">
			<button type="submit" class="btn btn-success"><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
		</div>
	</form>
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><!-- <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> --> <a href="javascript:;" onclick="admin_add('添加管理员','/manager/create','800','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加管理员</a></span> <span class="r">共有数据：<strong>{{$total}}</strong> 条</span> </div>
	<table class="table table-border table-bordered table-bg">
		<thead>
			<tr>
				<th scope="col" colspan="9">员工列表</th>
			</tr>
			<tr class="text-c">
				<!-- <th width="25"><input type="checkbox" name="" value=""></th> -->
				<th width="40">ID</th>
				<th width="150">登录名</th>
				<th width="90">所属角色</th>
				<th>描述</th>
				<th width="130">最后登录时间</th>
				<th width="100">是否已启用</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach($manager as $v)
			<tr class="text-c">
				<!-- <td><input type="checkbox" value="1" name=""></td> -->
				<td>{{$v->mg_id}}</td>
				<td>{{$v->mg_name}}</td>
				<td><span class="label label-default radius">{{$v->role->r_name}}</span></td>
				<td>{{$v->desc}}</td>
				<td>{{$v->last_login_time}}</td>
				<td class="td-status">{!! show_status($v->status,'正常','停用') !!}</td>
				<td class="td-manage"> <a title="编辑" href="javascript:;" onclick="admin_edit('管理员编辑','/manager/{{$v->mg_id}}/edit','1','800','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_del(this,'{{$v->mg_id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
<div id="page" style="margin-top: 10px; float: right;"></div>
</div>
@endsection
@section('my-js')
<script type="text/javascript" src="/admin/h-ui/lib/My97DatePicker/4.8/WdatePicker.js"></script> 
<script type="text/javascript" src="/admin/h-ui/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">

//分页逻辑的实现//
laypage({
	cont:'page',
	pages:"{{$pageTotal}}",
	curr:"{{$page}}",
	jump:function(e,first){
		if(!first){
			//debugger;
			location.href = '?page=' + e.curr + "&datemin={{$datemin}}&datemax={{$datemax}}&key={{$key}}";
		}
		console.log(e);
	}
});
/*管理员-状态*/
$('.status').on('click',function(obj){
	var status = $(this).attr('data-status');
	var mg_id = $(this).parents('tr').find('td:eq(0)').html();
	
	//ajax
	$.ajax({
		url:'/status',
		data:{_status:status,mg_id:mg_id},
		type:'post',
		dataType:'json',
		headers:{
			'X-CSRF-TOKEN':'{{csrf_token()}}'
		},
		success:function(msg){
			if(msg.code == 1){
				self.location.href = self.location.href;
			}
		}
	})
	console.log(mg_id);
});
/*管理员-增加*/
function admin_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-删除*/
function admin_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'DELETE',
			url: '/manager/'+id,
			dataType: 'json',
			headers:{
				'X-CSRF-TOKEN':"{{csrf_token()}}"
			},
			success: function(data){
				$(obj).parents("tr").remove();
				layer.msg('已删除!',{icon:1,time:1000});
			},
			error:function(data) {
				console.log(data.msg);
			},
		});		
	});
}

/*管理员-编辑*/
function admin_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}

</script>
@endsection