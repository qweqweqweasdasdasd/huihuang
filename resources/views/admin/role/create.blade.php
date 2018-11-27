@extends('admin/common/master')
@section('title','角色')
@section('content')
<article class="page-container">
	<form class="form form-horizontal" id="form-admin-role-add">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-1">角色名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder="" name="r_name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-1">备注：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<textarea name="desc" cols="" rows="" class="textarea"  placeholder="说点什么...最少输入10个字符" onKeyUp="$.Huitextarealength(this,100)"></textarea>
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
	evt.preventDefault();
	
	$.ajax({
		url:'/role',
		data:data,
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