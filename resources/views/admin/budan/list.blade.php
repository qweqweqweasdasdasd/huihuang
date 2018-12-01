@extends('admin/common/master')
@section('title','补单')
@section('content')
<link rel="stylesheet" type="text/css" href="/admin/page.css">
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 管理员列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<form>
	<div class="text-c"> <!-- 日期范围： -->
		<!-- <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
		-
		<input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" class="input-text Wdate" style="width:120px;"> -->
		<input type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" name="trade_no" value="{{$trade_no}}">
		<button type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜订单</button>
	</div>
	</form>
	<div class="cl pd-5 bg-1 bk-gray mt-20"><span class="r">共有数据：<strong>{{$count}}</strong> 条</span> </div>
	<table class="table table-border table-bordered table-bg mt-20">
		<thead>
			<tr>
				<th scope="col" colspan="9">补单列表</th>
			</tr>
			<tr class="text-c">
				<th width="50">ID</th>
				<th width="120">会员账号</th>
				<th width="250">商户订单</th>
				<th width="100">提交金额</th>
				<th width="150">申请时间</th>
				<th >备注</th>
				<th width="80">状态</th>
			</tr>
		</thead>
		<tbody>
			@foreach($budan as $v)
			<tr class="text-c">
				<td>{{$v->b_id}}</td>
				<td><span class="label label-default radius">{{$v->input_username}}</span></td>
				<td>{{$v->trade_no}}</td>
				<td><span class="label label-default radius">{{$v->money}}</span></td>
				<td>{{$v->created_at}}</td>
				<td>{{$v->tips}}</td>
				<td class="td-status">{!! order_status($v->pay_type) !!}</td>
			</tr>
			@endforeach
		</tbody>
	</table>

{{ $budan->links() }}

</div>
@endsection