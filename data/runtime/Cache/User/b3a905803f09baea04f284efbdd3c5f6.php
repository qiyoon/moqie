<?php if (!defined('THINK_PATH')) exit();?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml">
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta name="viewport" content="width=device-width,initial-scale=1.0;maximum-scale=1.0,user-scalable=0" />
 <title>跳转提示</title>
 <style type="text/css">
 html{font-size:125%;}
 *{ padding: 0; margin: 0; }
body{ background: #fff; font-family: '微软雅黑'; color: #CCC; font-size: 16px; }
 .system-message{ padding: 1.3rem 2rem; margin:auto;width: 90% ;border: #CCC 3px solid; top:50%;  border-radius:10px;
    -moz-border-radius:10px; /* Old Firefox */}
 .system-message h1{ font-size: 100px; font-weight: normal; line-height: 120px; margin-bottom: 5px; }
 .system-message .jump{ padding-top: 10px; color: #999;}
 .system-message .success,.system-message .error{ line-height: 1.8em;  color: #999; font-size: 3rem; font-family: '黑体'; }
 .system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display:none}
 </style>
<script type='text/javascript' src='http://ajax.useso.com/ajax/libs/jquery/1.7.2/jquery.min.js?ver=3.4.2'></script>
 <script type="text/javascript">
$(function(){
    var height2=$('.system-message').height();
    var height1=$(window).height();
    $('.system-message').css('margin-top',((height1-height2)/2)-30);
 });
 </script>
<!-- Bootstrap core CSS -->
<link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="system-message">
<?php if(isset($message)): ?><h1 class="glyphicon glyphicon-ok-circle" style="color:#09F"></h1>
 <p class="success"><?php echo($message); ?></p>
 <?php else: ?>
<h1 class="glyphicon glyphicon-exclamation-sign" style="color:#F33"></h1>
 <p class="error"><?php echo($error); ?></p><?php endif; ?>
<p class="detail"></p>
 <p class="jump">
 页面自动 <a id="href" class="text-primary" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo($waitSecond); ?></b>
 </p>
</div>
 <script type="text/javascript">
 (function(){
 var wait = document.getElementById('wait'),href = document.getElementById('href').href;
 var interval = setInterval(function(){
    var time = --wait.innerHTML;
    if(time <= 0) {
        location.href = href;
        clearInterval(interval);
    };
 }, 1000);
 })();
 </script>
</body>
 </html>