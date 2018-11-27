@extends('admin/common/master')
@section('title','角色')
@section('my-css')
<link rel="stylesheet" type="text/css" href="/admin/h-ui/static/h-ui.admin/css/page.css">
@endsection
@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 角色管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="cl pd-5 bg-1 bk-gray"> <span class="l"> <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a class="btn btn-primary radius" href="javascript:;" onclick="admin_role_add('添加角色','/role/create','800')"><i class="Hui-iconfont">&#xe600;</i> 添加角色</a> </span> <span class="r">共有数据：<strong>{{$count}}</strong> 条</span> </div>
	<table class="table table-border table-bordered table-hover table-bg">
		<thead >
			<tr>
				<th scope="col" colspan="6">角色管理</th>
			</tr>
			<tr class="text-c" >
				<th width="25"><input type="checkbox" value="" name="" id="header"></th>
				<!-- <th width="40">ID</th> -->
				<th width="150">角色名</th>
				<th>用户列表</th>
				<th width="300">描述</th>
				<th width="200">创建时间</th>
				<th width="70">操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach($role as $v)
			<tr class="text-c">
				<td><input type="checkbox" value="{{$v->r_id}}" name="ids"></td>
				<!-- <td>{{$v->r_id}}</td> -->
				<td>{{$v->r_name}}</td>
				<td>
					@foreach($v->managers as $vv)
						<span class="label label-default radius">{{$vv->mg_name}}</span>
					@endforeach
				</td>
				<td>{{$v->desc}}</td>
				<td>{{$v->created_at}}</td>
				<td class="f-14">
					<a title="分配权限" href="javascript:;" onclick="admin_role_permissoin('分配权限','/distribute/{{$v->r_id}}')" style="text-decoration:none"><i class="Hui-iconfont">&#xe68c;</i></a> 
					<a title="编辑" href="javascript:;" onclick="admin_role_edit('角色编辑','role/{{$v->r_id}}/edit')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> 
					<a title="删除" href="javascript:;" 
					onclick="admin_role_del(this,'{{$v->r_id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
	{{ $role->links() }}
</div>
@endsection
@section('my-js')
<script type="text/javascript" src="/admin/h-ui/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
/*角色权限添加*/
function admin_role_permissoin(title,url,w,h) {
	layer_show(title,url,w,h);
}
/*管理员-角色-添加*/
function admin_role_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-角色-编辑*/
function admin_role_edit(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-角色-删除*/
function admin_role_del(obj,id){
	layer.confirm('角色删除须谨慎，确认要删除吗？',function(index){
		
		$.ajax({
			url:'/role/'+id,
			type:'DELETE',
			contentType:"application/json",//设置请求参数类型为json字符串
			data:'',//将json对象转换成json字符串发送
			dataType:'json',
			headers:{
				'X-CSRF-TOKEN':'{{csrf_token()}}'
			},
			success:function(msg){
				$(obj).parents("tr").remove();
				layer.msg('已删除!',{icon:1,time:1000});
			}
		})
	});
}
/*批量删除*/
function datadel() {
	var ids = new Array();
	var checkbox = $('input[type="checkbox"]:checked');
	if(checkbox.length == 0){
		layer.alert('没有勾选数据的呢',{title:'提示'});
		return;
	}
	for (var i = 1; i < checkbox.length; i++) {
		ids.push(checkbox[i].value);

	}
	//ajax
	$.ajax({
		url:'/roleAll',
		data:{_ids:ids},
		type:'post',
		headers:{
			'X-CSRF-TOKEN':'{{csrf_token()}}'
		},
		success:function(msg){
			if(msg.code == 1){
				checkbox.not('#header').parents('tr').remove();
				debugger;
			}
		}
	})
}
</script>
@endsection