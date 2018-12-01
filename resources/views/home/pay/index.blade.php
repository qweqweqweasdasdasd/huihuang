@extends('home/common/master')
@section('content')

<div class="header layout bg-blue">
  <div class="line text-center">
      <div class="x1 padding-small-top padding-small-bottom"></div>
      <div class="x9 padding-top padding-bottom text-big text-white">自动补单</div>
      <div class="x2 padding-small-top padding-small-bottom text-right"></div>
  </div>
</div>
<div class="padding">
    <form class="margin-big-top form-big" id="payform" method="post">
    	<div class="form-group">
	        <div class="label"><label>用户名</label></div>
	        <div class="field">
	            <input type="text" class="input" name="input_username" id="input_username" size="30"  />
	        </div>
	    </div>
	    <div class="form-group">
	        <div class="label"><label>充值金额</label></div>
	        <div class="field">
	            <input type="text" class="input" name="money" id="money" size="30" />
	        </div>
	    </div>
	    <div class="form-group margin-top">
	        <div class="label"><label>商户单号</label></div>
	        <div class="field">
	            <input name="trade_no" id="trade_no" class="input" type="text">
	        </div>
	    </div>
	    <div class="form-button">
	        <button class="button button-block bg-blue margin-top" type="submit" id="toConfirm">确认补入</button>
	    </div>
    </form>
</div>
@endsection
@section('my-js')
<script type="text/javascript">
	$('#payform').on('submit',function(evt){
		var data = $(this).serialize();
		evt.preventDefault();

		//ajax
		$.ajax({
			url:'/budan',
			data:data,
			type:'post',
			dataType:'json',
			headers:{
				'X-CSRF-TOKEN':"{{csrf_token()}}"
			},
			success:function(msg){
				if(msg.code == 0){
					layer.alert(msg.error,{title:'提示'});
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
	});
</script>
@endsection
