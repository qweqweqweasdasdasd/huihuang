@extends('admin/common/common')
@section('title','USDT充值')
@section('extend')
<link rel="stylesheet" href="/home/css/small_logo_sprite.css">
<script src="/home/js/index.js"></script>
<script src="/home/js/clipboard.min.js"></script>
<script src="/home/js/vue.min.js"></script>
@endsection
@section('content')
<div class="container" id="container" 
></div>
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
            <div class="weui-cells">
                <div class="weui-cell js_item">
                    <div class="weui-cell__bd">尊敬的用户: {!! returnStr($usdt['outCustomerId']) !!}</div>
                </div>
            </div>
            <div class="weui-cells">
                <div class="weui-cell">
                    <div class="weui-cell__bd bank_tips tips1">提示，存款前请先注册火币账号，然后购买一定量的usdt虚拟币(最低是10币哦)</div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__bd bank_tips tips1">我平台通过爆热usdt虚拟币金额转账</div>
                </div>
                                <div class="weui-cell">
                    <div class="weui-cell__bd bank_tips tips1">请跟进下面显示的以太坊地址金额转账，务必复制正确的地址。</div>
                </div>
                                <div class="weui-cell">
                    <div class="weui-cell__bd bank_tips tips1">转账之前请务必确认以太坊地址是否正确</div>
                </div>
                                <div class="weui-cell">
                    <div class="weui-cell__bd bank_tips">本地址只保存10分钟，10分之后请刷新重新获取</div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__bd bank_tips tips2">务必再三确认以太坊地址</div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__bd bank_tips tips1">其他通知： 转账额度大于10个币 ! 账户在下方</div>
                </div>
                
                <div class="weui-cell">
                    <div class="weui-cell__bd bank_title">USDT充值专用账户</div>
                </div>
                <div class="weui-cell info">
                    <div class="weui-cell__hd">Usdt地址</div>
                    <div class="weui-cell__bd">{{$usdt['accountAddress']}}</div>
                    <div class="weui-cell__ft copy" data-clipboard-text="{{$usdt['accountAddress']}}" onclick="">复制</div>
                </div>
                </div>
                
            </div>
           
            <!-- 判断用户是否有绑定了银行卡 -->
        <div class="page__ft">
            <a href="http://505660.com" >USDT充值到账流程</a>
        </div>

        
        <div class="Process" style="display: none">
            <div class="weui-mask weui-animate-fade-in"></div>
            <div class="weui-dialog weui-animate-fade-in">
                <div class="weui-dialog__hd">
                    <strong class="weui-dialog__title">USDT充值到账流程</strong>
                </div>

                <div class="weui-cells">
                    <div class="weui-cell">
                        <div class="weui-cell__hd"><img src="/home/img/cny.png" alt=""></div>
                        <div class="weui-cell__bd">第一步</div>
                    </div>
                </div>
                <div class="weui-cells">
                    <div class="weui-cell">
                        <div class="weui-cell__bd">通过银行APP或网银转账至USDT充值专用账户</div>
                    </div>
                </div>
                <div class="weui-cells">
                    <div class="weui-cell">
                        <div class="weui-cell__hd"><img src="/home/img/bank.png" alt=""></div>
                        <div class="weui-cell__bd">第二步</div>
                    </div>
                </div>
                <div class="weui-cells">
                    <div class="weui-cell">
                        <div class="weui-cell__bd">核实转账，等待银行处理</div>
                    </div>
                </div>
                <div class="weui-cells">
                    <div class="weui-cell">
                        <div class="weui-cell__hd"><img src="/home/img/success.png" alt=""></div>
                        <div class="weui-cell__bd">第三步</div>
                    </div>
                </div>
                <div class="weui-cells">
                    <div class="weui-cell">
                        <div class="weui-cell__bd">
                            充值成功
                            <span>完成银行转账后，一般 3 分钟内充值到账，具体以银行收到款项时间为准</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function(){
            $('.js_item').on('click', function(){
                let id = $(this).data('id');
                window.pageManager.go(id);
            });
            // Info
            let info = '';
            if (info) {
                weui.topTips(info);
            }
            // USDT充值到账流程
            $('#Process,.Process').on('click', function(){
                $('.Process').toggle();
            });
            let clp = new ClipboardJS('.copy');
            clp.on('success', function(e) {
                weui.toast('复制成功', 1000);
            });
            clp.on('error', function(e) {
                console.log(e);
            });
       

            /*setInterval(function(){
                var currenttoken = document.cookie.split(';')[0];
                $.ajax({
                    url:'/bank/bank_check',
                    data:'',
                    dataType:'json',
                    type:'post',
                    headers:{
                        'X-CSRF-TOKEN':"{{csrf_token()}}",
                    },
                    success:function(r){
                        if(r.data != bank_code){
                            window.location.reload();
                        }
                        if(r.code == 0){
                            window.location.reload();
                        }
                    }
                })
            }, 2000);*/

        });
    </script>
</script>

@endsection