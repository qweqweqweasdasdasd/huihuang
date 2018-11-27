@extends('admin/common/master')
@section('title','权限分配')
@section('content')
<article class="page-container">
	<form action="" method="post" class="form form-horizontal" id="form-admin-role-add">
		<input type="hidden" name="r_id" value="{{$role->r_id}}">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">角色名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$role->r_name}}" placeholder="" readonly="readonly" name="r_name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">备注：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$role->desc}}" placeholder="" name="desc">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">网站角色：</label>
			<div class="formControls col-xs-8 col-sm-9">
				@foreach($permission_i as $v)
				<dl class="permission-list">
					<dt>
						<label>
							<input type="checkbox" value="{{$v->ps_id}}" name="quanxun[]" id="" @if(in_array($v->ps_id,$ps_ids_arr)) checked @endif>
							{{$v->ps_name}}</label>
					</dt>
					<dd>
						@foreach($permission_ii as $vv)
						@if($vv->ps_pid == $v->ps_id)
						<dl class="cl permission-list2">
							<dt>
								<label class="">
									<input type="checkbox" value="{{$vv->ps_id}}" name="quanxun[]" id="" @if(in_array($vv->ps_id,$ps_ids_arr)) checked @endif>
									{{$vv->ps_name}}</label>
							</dt>
							<dd>
								@foreach($permission_iii as $vvv)
								@if($vvv->ps_pid == $vv->ps_id)
								<label class="">
									<input type="checkbox" value="{{$vvv->ps_id}}" name="quanxun[]" id="" @if(in_array($vvv->ps_id,$ps_ids_arr)) checked @endif>
									{{$vvv->ps_name}}</label>
								@endif
								@endforeach
							</dd>
						</dl>
						@endif
						@endforeach
					</dd>
				</dl>
				@endforeach
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
				<button type="submit" class="btn btn-success radius" id="admin-role-save" name="admin-role-save"><i class="icon-ok"></i> 确定</button>
			</div>
		</div>
	</form>
</article>
@endsection
@section('my-js')
<script type="text/javascript">
/*提交form表单*/
$('form').on('submit',function(evt){
	evt.preventDefault();
	var data = $(this).serialize();
	//ajax
	$.ajax({
		url:'',
		data:data,
		dataType:'json',
		type:'post',
		headers:{
			'X-CSRF-TOKEN':'{{csrf_token()}}'
		},
		success:function(msg){
			if(msg.code == 1){
				//parent.window.location.href = '/role';
				parent.self.location = parent.self.location;
			}else if(msg.code == 0){
				layer.alert(msg.error,{title:'提示'});
			}
		}
	})
});

$(function(){
	$(".permission-list dt input:checkbox").click(function(){
		$(this).closest("dl").find("dd input:checkbox").prop("checked",$(this).prop("checked"));
	});
	$(".permission-list2 dd input:checkbox").click(function(){
		var l =$(this).parent().parent().find("input:checked").length;
		var l2=$(this).parents(".permission-list").find(".permission-list2 dd").find("input:checked").length;
		if($(this).prop("checked")){
			$(this).closest("dl").find("dt input:checkbox").prop("checked",true);
			$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",true);
		}
		else{
			if(l==0){
				$(this).closest("dl").find("dt input:checkbox").prop("checked",false);
			}
			if(l2==0){
				$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",false);
			}
		}
	});
});
</script>
@endsection
