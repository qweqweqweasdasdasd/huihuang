@extends('home/common/master')
@section('content')
<div class="header layout bg-blue">
  <div class="line text-center">
      <div class="x1 padding-small-top padding-small-bottom"></div>
      <div class="x9 padding-top padding-bottom text-big text-white">在线充值</div>
      <div class="x2 padding-small-top padding-small-bottom text-right"></div>
  </div>
</div>
<div class="padding">
    <form class="margin-big-top form-big" id="payform" action="/alipay" method="post">
    	{{ csrf_field() }}
	    <div class="form-group">
	        <div class="label"><label>充值金额</label></div>
	        <div class="field">
	            <input type="tel" class="input" name="money" id="money" size="30" maxlength="6" />
	            <div class="input-note text-big margin-top">最低充值金额为<span class="text-yellow"> 10.00 </span>元</div>
	        </div>
	    </div>
	    <div class="form-group margin-top">
	        <div class="label"><label>会员账号</label></div>
	        <div class="field">
	            <input name="username" id="username" class="input" type="text">
	        </div>
	        <div class="input-note text-big margin-top"><span class="text-yellow">*请填写正确的会员账号，否则无法及时到账!</span></div>
            @if (count($errors) > 0)
			    <div class="text-yellow">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif
	    </div>
	    <div class="form-button">
	        <button class="button button-block bg-blue margin-top" type="submit" id="toConfirm">支付宝充值</button>
	    </div>
    </form>
</div>
@endsection
@section('my-js')
@endsection
