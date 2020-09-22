@extends('admin/common/common')
@section('title','USDT充值')
@section('content')
<div class="container" id="container"></div>
@endsection
@section('my-js')
<script type="text/html" id="tpl_home">
    <div class="page js_show">
        <div class="page__hd">
            <div class="weui-cells">
                <div class="weui-cell">
                    <div class="weui-cell__bd">USDT充值</div>
                </div>
            </div>
        </div>
        <div class="page__bd">
            <div class="weui-cells weui-cells_form">
            	<input type="hidden" name="pf_name" value="laohuihuang">
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <label class="weui-label">会员账户</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="text" autocomplete="off" placeholder="请输入会员账户" name="username" value="">
                    </div>
                </div>
            </div>

            <div class="weui-btn-area">
                <a class="weui-btn weui-btn_primary" href="javascript:;" id="nextStep">下一步</a>
            </div>
           
        </div>
    </div>
    <style>
        /*登录*/
        .weui-cells__tips {
            margin-top: 15px;
        }
        .weui-cells__tips .register{
            color: #19ACF7;
        }
        .weui-cells__tips .kefu{
            float: right;
            color: #999;
        }
        /*弹窗*/
        .checkuser .weui-toast__content{
            font-size: 13px;
            margin: 10px 0 10px;
        }
    </style>
    <script type="text/javascript">
        $(function(){
            // Info
            let info = '';
            if (info) {
                weui.topTips(info);
            }
            
            // 核对账号
            var check,loading,check_num = 0,sub_check = false;
            $('#nextStep').on('click', function(){
                // 防止重复提交
                if (sub_check) return;
                loading = weui.loading('正在核对您的帐号', {
                   className: 'checkuser'
                });
                let username = $('input[name="username"]').val();
                
                if (!trim(username)){
                    weui.topTips('请输入会员账号！');
                    return false;
                }
                sub_check = true;
                $.post("/getUsdtKey", { 'username' : trim(username), '_token' : '{{csrf_token()}}'}, function (res) {
                    sub_check = false;
                    if (res.code === 1){

                        window.location.href = '/showQr/'+res.data;		// 显示二维码
                    }else if(res.code == 2){		
                        loading.hide();
                        weui.topTips('账户不存在');			// 账号不存在
                        return;
                    }else if (res.code === -1){				// 其他错误信息
                        loading.hide();
                        weui.topTips(res.msg);
                        return;
                    }
                });
            });
            // 删除左右两端空格
            function trim(str){
                return str.replace(/(^\s*)|(\s*$)/g, "");
            }
           
        });
    </script>
</script>
@endsection