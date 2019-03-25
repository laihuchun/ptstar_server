<?php
ini_set('date.timezone','Asia/Shanghai');  
/**
 * JS_API支付demo
 * ====================================================
 * 在微信浏览器里面打开H5网页中执行JS调起支付。接口输入输出数据格式为JSON。
 * 成功调起支付需要三个步骤：
 * 步骤1：网页授权获取用户openid
 * 步骤2：使用统一支付接口，获取prepay_id
 * 步骤3：使用jsapi调起支付
*/
	include_once("lib/jsapipay_base.php");
	include "lib/unifiedOrder_base.php";
	include "lib/db_base.php";
	//使用jsapi接口
	$jsApi = new JsApiPay();

	//=========步骤1：网页授权获取用户openid============
	//通过code获得openid
	$openid = $jsApi->GetOpenid();
	//=========步骤2：使用统一支付接口，获取prepay_id============
	//使用统一支付接口
	//$unifiedOrder = new UnifiedOrder_pub();
	$appid = 'wx67c8081d6cc7eb32';
    	$mch_id = '1367406702';
    	$key = 'FB4EB881C5314C5288FBD8AC05174A02';
   	$appsecret = '79ed3dfdb2f01180f1a4f94f1dfbca9a';
   	$notify_url = 'https://www.sdkjsc.com/ptstar/wxpay/notify.php';
	$wechatsjapiPay = new wechatAppPay($appid, $mch_id, $notify_url, $key);
	$params['body'] = 'test';                       //商品描述
    	$pt_order_no = $wechatsjapiPay->build_order_no();
   	$params['out_trade_no'] = $pt_order_no;    //自定义的订单号
    	$params['total_fee'] = '1';                       //订单金额 只能为整数 单位为分
    	$params['trade_type'] = 'JSAPI';                      //交易类型 JSAPI | NATIVE | APP | WAP 
    	$params['openid'] = $openid;                      //openid
    	$result = $wechatsjapiPay->unifiedOrder( $params );
    	$sql = "insert into order_pt(order_no,prepay_id,openid,amount,status) ";
    	$sql .= "values('$pt_order_no','{$result['prepay_id']}','$openid','{$params['total_fee']}',0);";
    	insert_into($sql);
	$unifiedOrder = $result['prepay_id'];
	$jsApi->setPrepayId($prepay_id);
	$jsApiParameters = $jsApi->GetJsApiParameters($result);
	//echo $jsApiParameters;
?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <title>微信安全支付</title>

	<script type="text/javascript">

		//调用微信JS api 支付
		function jsApiCall()
		{
			WeixinJSBridge.invoke(
				'getBrandWCPayRequest',
				<?php echo $jsApiParameters; ?>,
				function(res){
					WeixinJSBridge.log(res.err_msg);
					alert(res.err_code+res.err_desc+res.err_msg);
				}
			);
		}

		function callpay()
		{
			if (typeof WeixinJSBridge == "undefined"){
			    if( document.addEventListener ){
			        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
			    }else if (document.attachEvent){
			        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
			        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
			    }
			}else{
			    jsApiCall();
			}
		}
	</script>
</head>
<body>
	</br></br></br></br>
	<div align="center">
		<button style="width:210px; height:30px; background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >贡献一下</button>
	</div>
</body>
</html>

