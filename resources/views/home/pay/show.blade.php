<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="refresh" content="10">    <!-- 10秒刷新一下 -->
    <title>微信支付</title>
    <script src="https://cdn.bootcss.com/jquery/1.7/jquery.min.js"></script>
    <style media="screen">
        body, html {margin: 0;padding: 0;min-width: 320px;max-width: 640px;font-size: 62.5%;font-family:}
        .header {background-color: #277ede;height: 4rem;line-height: 4rem;text-align: center;color: #fff;font-size: 1.6rem;font-weight: 800;}
        .text-1 {color: red;font-size: 1.6rem;padding: 1rem;font-weight: 600;}
        .img {padding: 1rem;}
        .img img {display: block; width: 100%;margin: 0 auto;}
    </style>
</head>
<body>
    <header class="header">请长按二维码（识别图中二维码）即可充值</header>
    <div class="text-1">1、注意：输入消费金额后，请点击下方<span style="color:#0000FF">【添加付款备注】</span>备注您的会员账号，否则无法到账！</div>
    <div class="img">
        <img src="{{$pic->picture}}" alt="no pic">
    </div>
    <div class="text-1">2、注意：输入消费金额后，请点击下方<span style="color:#0000FF">【添加付款备注】</span>备注您的会员账号，否则无法到账！</div>
    <div class="img">
        <img src="home/wechat/img/02.jpg" />
    </div>
    <div class="text-1">3、注意：在“添加付款备注”此处输入您的会员账号</div>
    <div class="img">
        <img src="home/wechat/img/03.jpg" />
    </div>
</body>
</html>
