@extends('admin/common/master')
@section('title','登录')
@section('my-css')
<link href="/admin/h-ui/static/h-ui.admin/css/H-ui.login.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<input type="hidden" id="TenantId" name="TenantId" value="" />
<div class="loginWraper">
  <div id="loginform" class="loginBox">
    <form class="form form-horizontal" >
    	{{ csrf_field() }}
      <div class="row cl">
        <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
        <div class="formControls col-xs-8">
          <input  name="mg_name" type="text" placeholder="账户" class="input-text size-L">
        </div>
      </div>   
       <div class="row cl">
        <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
        <div class="formControls col-xs-8">
          <input  name="password" type="password" placeholder="密码" class="input-text size-L">
          <!-- <br/>{{$errors->first('password')}} -->
        </div>
      </div>   
      <div class="row cl">
      	<label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe6c7;</i></label>
        <div class="formControls col-xs-8">
          <input class="input-text size-L" type="text" placeholder="手机号" style="width:220px;" name="tel">  
          <input class="btn btn-primary size-L sendsms" type="button" value="发送短信" style="width: 135px;">
      	</div>
      </div>
      <div class="row cl">
        <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe63f;</i></label>
        <div class="formControls col-xs-8">
          <input  name="sms" type="text" placeholder="短信验证码" class="input-text size-L">
        </div>
      </div> 
      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          <input  type="submit" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
          <input  type="reset" class="btn btn-default radius size-L" value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
@section('my-js')
<script type="text/javascript">
  //发送短信信息
  $('.sendsms').on('click',function(){
  	var tel = $('input[name="tel"]').val();
  	var mg_name = $('input[name="mg_name"]').val();

  	//ajax
  	$.ajax({
  		url:'/sendSMS',
  		data:{tel:tel,mg_name:mg_name},
  		type:'post',
  		headers:{
  			'X-CSRF-TOKEN':'{{csrf_token()}}'
  		},
  		success:function(msg){
        if(msg.code == 1){
          $('.sendsms').val('发送成功');
          $('.sendsms').attr('disabled','disabled');
          $('.sendsms').attr('class','btn btn-default size-L sendsms');
        }
  			if(msg.code == 0){
  				layer.alert(msg.error);
  			}
  		}
  	})
  	//alert('ok');
  });
  //提交事件
  $('form').on('submit',function(evt){
	    var data = $(this).serialize();
	    evt.preventDefault();

	    //ajax
	    $.ajax({
	      url:'/checkadmin',
	      data:data,
	      type:'post',
	      dataType:'json',
	      header:{
	        'X-CSRF-TOKEN':'{csrf_token()}'
	      },
	      success:function(msg){
	        if(msg.code == 1){
	          window.location.href = '/index/index';
	        }else if(msg.code == 0){
	          layer.alert(msg.error,'提示');
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