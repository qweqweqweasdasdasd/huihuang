@extends('admin/common/master')
@section('title','权限')
@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 权限中心 <span class="c-gray en">&gt;</span> 权限管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<!-- <div class="text-c"> 日期范围：
		<input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
		-
		<input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" class="input-text Wdate" style="width:120px;">
		<input type="text" class="input-text" style="width:250px" placeholder="输入会员名称、电话、邮箱" id="" name="">
		<button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜权限</button>
	</div> -->
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><!-- <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> --> <a href="javascript:;" onclick="member_add('添加权限','/permission/create','','510')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加权限</a></span> <span class="r">共有数据：<strong>{{$count}}</strong> 条</span> </div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<!-- <th width="25"><input type="checkbox" name="" value=""></th> -->
				<th width="80">ID</th>
				<th width="150">权限名</th>
				<th width="200">路由</th>
				<th >级别</th>
				<!-- <th >描述</th> -->
				<th width="200">加入时间</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach($tree as $k => $v)
			<tr class="text-c">
				<!-- <td><input type="checkbox" value="1" name=""></td> -->
				<td>{{++$k}}</td>
				<td>{{ str_repeat('├─',$v['ps_level']).$v['ps_name'] }}</td>
				<td>{{$v['ps_route']}}</td>
				<td>{!!permission_status($v['ps_level'])!!}</td>
				<!-- <td>{{$v['desc']}}</td> -->
				<td>{{$v['created_at']}}</td>
				<td class="td-manage"><a title="编辑" href="javascript:;" onclick="member_edit('编辑','permission/{{$v["ps_id"]}}/edit','4','','510')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a><a title="删除" href="javascript:;" onclick="member_del(this,'{{$v["ps_id"]}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
	</div>
</div>
@endsection
@section('my-js')
<script type="text/javascript" src="/admin/h-ui/lib/My97DatePicker/4.8/WdatePicker.js"></script> 
<script type="text/javascript" src="/admin/h-ui/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
/*权限-添加*/
function member_add(title,url,w,h){
	layer_show(title,url,w,h);
}

/*权限-编辑*/
function member_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}
/*密码-修改*/
function change_password(title,url,id,w,h){
	layer_show(title,url,w,h);	
}
/*权限-删除*/
function member_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'DELETE',
			url: '/permission/'+id,
			dataType: 'json',
			headers:{
				'X-CSRF-TOKEN':'{{csrf_token()}}'
			},
			success: function(msg){
				if(msg.code == 1){
					$(obj).parents("tr").remove();
					layer.msg('已删除!',{icon:1,time:1000});
				}else if(msg.code == 0){
					layer.alert(msg.error,{title:'提示'});
				}
				
			},
			error:function(data) {
				console.log(data.msg);
			},
		});		
	});
}
</script> 
@endsection