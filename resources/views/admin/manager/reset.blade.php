@extends('admin/common/master')
@section('title','密码修改')
@section('content')
<div class="pd-20">
  <form class="Huiform" >
    <table class="table table-border table-bordered table-bg">
      <thead>
        <tr>
          <th colspan="2">修改密码</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th class="text-r" width="20%">旧密码：</th>
          <td><input name="oldpassword"  class="input-text" type="password" autocomplete="off" placeholder="密码" tabindex="1" > 
          </td>
        </tr>
        <tr>
          <th class="text-r" width="20%">新密码：</th>
          <td><input name="password"  class="input-text" type="password" autocomplete="off" placeholder="设置密码" tabindex="2"  > 
          </td>
        </tr>
        <tr>
          <th class="text-r" width="20%">再次输入新密码：</th>
          <td><input name="password_confirmation"  class="input-text" type="password" autocomplete="off" placeholder="确认新密码" tabindex="3" > 
          </td>
        </tr>
        <tr>
          <th></th>
          <td>
            <button type="submit" class="btn btn-success radius" id="admin-password-save" name="admin-password-save"><i class="icon-ok"></i> 确定</button>
          </td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
@endsection
@section('my-js')
<script type="text/javascript">
	$('form').on('submit',function(evt){
		var data = $(this).serialize();
		evt.preventDefault();
		//ajax
		$.ajax({
			url:'/doreset',
			data:data,
			dataType:'json',
			type:'post',
			headers:{
				'X-CSRF-TOKEN':"{{csrf_token()}}"
			},
			success:function(msg){
				if(msg.code == 1){
				  //debugger;
          parent.window.location.href = '/login';
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
				};
			}
		})
	});
</script>
@endsection