@extends('admin/common/master')
@section('title','角色')
@section('content')
<article class="page-container">
	<form class="form form-horizontal" id="form-admin-role-add">
		<input type="hidden" name="r_id" value="{{$role->r_id}}">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-1">角色名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$role->r_name}}" placeholder="" name="r_name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-1">备注：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<textarea name="desc" cols="" rows="" class="textarea"  placeholder="说点什么...最少输入10个字符" onKeyUp="$.Huitextarealength(this,100)">{{$role->desc}}</textarea>
				<p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-1">
				<button type="submit" class="btn btn-success radius" id="admin-role-save" name="admin-role-save" style="width: 100px;"><i class="icon-ok"></i> 确定</button>
			</div>
		</div>
	</form>
</article>
@endsection
@section('my-js')
<script type="text/javascript">
//数据提交
$('#form-admin-role-add').on('submit',function(evt){
	var data = $(this).serialize();
	var r_id = $('input[type="hidden"]').val();
	evt.preventDefault();
	
	$.ajax({
		url:'/role/'+r_id,
		data:data,
		type:'PATCH',
		headers:{
			'X-CSRF-TOKEN':'{{csrf_token()}}'
		},
		success:function(msg){
			if(msg.code == 1){
				//parent.window.location.href = '/role';
				parent.self.location = parent.self.location;
			}
		},
		error:function(jqXHR, textStatus, errorThrown){
			var msg = '';
			$.each(JSON.parse(jqXHR.responseText),function(i,item){
				msg += item;
			});
			if(msg != ''){
				layer.alert(msg,{title:'提示'});
			}
		}
	})
});

</script>
@endsection