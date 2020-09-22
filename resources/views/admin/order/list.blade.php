@extends('admin/common/master')
@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 订单管理 <span class="c-gray en">&gt;</span> 订单列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="text-c">
	<form>
	 <span class="select-box inline">
		<select name="cate" class="select" style="width: 150px;">
			<option value="0">全部分类</option>
			<option value="1">分类一</option>
			<option value="2">分类二</option>
		</select>
		</span> 日期范围：
		<input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}' })" id="logmin" class="input-text Wdate" style="width:120px;" name="minDate" value="{{$whereDate['minDate']}}">
		-
		<input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d' })" id="logmax" class="input-text Wdate" style="width:120px;" name="maxDate" value="{{$whereDate['maxDate']}}">
		<input type="text" name="order_no" placeholder=" 订单名称" style="width:250px" class="input-text" value="{{$whereDate['order_no']}}">
		<button  class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜订单</button>
	</div>
	</form>
	<div class="cl pd-5 bg-1 bk-gray mt-20" > 商户为空的情况是个人微信收款 <!-- <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> </span>  --><span class="r">共有数据：<strong>{{$total}}</strong> 条</span> </div>
	<div class="mt-20">
		<table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
			<thead>
				<tr class="text-c">
					<th width="50">ID</th>
					<th width="120">会员账号</th>
					<!-- <th width="200">订单号</th> -->
					<th width="250">商户订单</th>
					<!-- <th width="100">支付金额</th> -->
					<th width="100">实付款金额</th>
					<th width="150">支付时间</th>
					<th >备注</th>
					<th width="80">状态</th>
					<th width="120">操作</th>
				</tr>
			</thead>
			<tbody>
				@foreach($order as $v)
				<tr class="text-c">
					<td>{{$v->order_id}}</td>
					<td><span class="label label-default radius">{{$v->username}}</span></td>
					<!-- <td>{{$v->order_no}}</td> -->
					<td class="text-l" width="27%">
						订单: {{$v->trade_no}}<br/>
						usdt: {{$v->order_no}}<br/>
					</td>
					<!-- <td><span class="label label-default radius">{{$v->amount}}</span></td> -->
					<td>
						{{$v->trade_amount}}
					</td>
					<td>{{$v->trade_time}}</td>
					<td>{{$v->tips}}</td>
					<td class="td-status">{!! order_status($v->pay_type) !!}</td>
					<td class="f-14 td-manage">
						@if($v->pay_type == 3 || $v->pay_type == 6)
						@else
							<a style="text-decoration:none" class="btn btn-warning radius size-MINI budan"  href="javascript:;" title="手动补单">手动补单</a>
						@endif
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<br/>
	<span class="r"><div id="page"></div></span>
</div>
@endsection
@section('my-js')
<script type="text/javascript" src="/admin/h-ui/lib/My97DatePicker/4.8/WdatePicker.js"></script> 
<script type="text/javascript" src="/admin/h-ui/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
laypage({
	cont:'page',
	pages:"{{$pageTotal}}",
	curr:"{{$page}}",
	jump:function(e,first){
		if(!first){
			//debugger;
			location.href = '?page=' + e.curr + "&minDate={{$whereDate['minDate']}}&maxDate={{$whereDate['maxDate']}}&order_no={{$whereDate['order_no']}}" ;
		}
		console.log(e);
	}
});


//手动补单
$('.budan').on('click',function(obj){
	var order_id = $(this).parents('tr').find('td:eq(0)').html();
	//ajax
	$.ajax({
		url:'/order/budan',
		data:{order_id:order_id},
		dataType:'json',
		type:'post',
		headers:{
			'X-CSRF-TOKEN':"{{csrf_token()}}"
		},
		success:function(msg){
			if(msg.code == 1){
				self.location.href = self.location.href;
			}
		}
	})
});

</script>
@endsection