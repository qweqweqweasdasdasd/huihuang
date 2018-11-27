@extends('admin/common/master')
@section('title','管理员')
@section('content')
<article class="page-container">
	<form class="form form-horizontal" >
	<input type="hidden" name="mg_id" value="{{$manager->mg_id}}">
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-1">管理员：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" value="{{$manager->mg_name}}" placeholder=""  name="mg_name">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-1">密码：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="password" class="input-text" autocomplete="off" value="{{$manager->password}}" placeholder="密码"  name="password" 
			style="width:230px;">
			<input class="btn btn-primary size-M repassword" type="button" value="机设密码">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-1">状态：</label>
		<div class="formControls col-xs-8 col-sm-9 skin-minimal">
			<div class="radio-box">
				<input name="status" type="radio" value="1" @if($manager->status == 1) checked @endif>
				<label for="sex-1">正常</label>
			</div>
			<div class="radio-box">
				<input type="radio"  name="status" value="2" @if($manager->status == 2) checked @endif>
				<label for="sex-2">禁用</label>
			</div>
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-1">角色：</label>
		<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:200px;">
			<select class="select" name="r_id" size="1">
				@foreach($roleNameAndId as $k => $v)
				<option value="{{$k}}"  @if($manager->r_id == $k) selected @endif>{{$v}}</option>
				@endforeach
			</select>
			</span> </div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-1">备注：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<textarea name="desc" cols="" rows="" class="textarea"  placeholder="说点什么...100个字符以内" dragonfly="true" onKeyUp="$.Huitextarealength(this,100)">{{$manager->desc}}</textarea>
			<p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
		</div>
	</div>
	<div class="row cl">
		<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-1">
			<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
		</div>
	</div>
	</form>
</article>
@endsection
@section('my-js')
<script type="text/javascript">
	//自作随机密码接口形式
	$('.repassword').on('click',function(obj){
		//ajax
		$.ajax({
			url:'/random',
			data:'',
			type:'get',
			dataType:'json',
			headers:{
				'X-CSRF-TOKEN':"{{csrf_token()}}"
			},
			success:function(msg){
				if(msg.code == 1){
					$('input[name="password"]').val(msg.data);
					$('input[type="password"]').attr('type','text');
				}
			}
		})
	});
	//提交form 表单
	$('form').on('submit',function(evt){
		var data = $(this).serialize();
		evt.preventDefault();
		var mg_id = $('input[name="mg_id"]').val();

		//ajax
		$.ajax({
			url:'/manager/'+ mg_id,
			data:data,
			type:'PATCH',
			headers:{
				'X-CSRF-TOKEN':"{{csrf_token()}}"
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
				});
				if(msg != ''){
					layer.alert(msg);
				}
			},
		})
	});
</script>
@endsection