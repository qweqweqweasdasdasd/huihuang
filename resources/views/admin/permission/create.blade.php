@extends('admin/common/master')
@section('title','权限')
@section('content')
<article class="page-container">
	<form action="" method="post" class="form form-horizontal" id="form-member-add">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">权限名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder=""  name="ps_name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">父级权限：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select class="select" size="1" name="ps_pid">
					@foreach($tree as $v)
					<option value="{{$v['ps_id']}}">{{ str_repeat('├─',$v['ps_level']).$v['ps_name'] }}</option>
					@endforeach

				</select>
				</span> 
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">控制器：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder="" name="ps_c">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">方法：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder="" name="ps_a">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">路由：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder="" name="ps_route">
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">备注：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<textarea name="desc" cols="" rows="" class="textarea"  placeholder="说点什么...最少输入10个字符" ></textarea>
				<p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
				<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
			</div>
		</div>
	</form>
</article>
@endsection
@section('my-js')
<script type="text/javascript">
	$('form').on('submit',function(evt){
		evt.preventDefault();
		var data = $(this).serialize();
		//ajax
		$.ajax({
			url:'/permission',
			data:data,
			dataType:'json',
			type:'post',
			headers:{
				'X-CSRF-TOKEN':'{{csrf_token()}}'
			},
			success:function(msg){
				if(msg.code == 0){
					layer.alert(msg.error,{title:'提示'});
				}else if(msg.code == 1){
					parent.self.location = parent.self.location;
				}
			},
			error:function(jqXHR, textStatus, errorThrown){
				var msg = '';
				$.each(JSON.parse(jqXHR.responseText),function(i,item){
					msg += item;
				})
				if(msg != ''){
					layer.alert(msg,{title:'提示'});
				};
			}
		})
		//alert('ok');
	});
</script>
@endsection