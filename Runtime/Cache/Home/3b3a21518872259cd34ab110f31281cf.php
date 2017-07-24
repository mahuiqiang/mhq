<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form method='post' action="http://shop2.com/pay/index.php">
	<input type='hidden' name='v_mid' value="<?php echo ($pay['v_mid']); ?>">                    
	<input type='hidden' name='v_oid' value="<?php echo ($pay['v_oid']); ?>">订单编号:<?php echo ($pay['v_oid']); ?>
	<input type='hidden' name='v_amount' value="<?php echo ($pay['v_amount']); ?>"><br>            		订单总金额:<?php echo ($pay['v_amount']); ?>
	<input type='hidden' name='v_moneytype' value="<?php echo ($pay['v_moneytype']); ?>">                
	<input type='hidden' name='v_url' value="<?php echo ($pay['v_url']); ?>">

	<input type='hidden' name='v_md5info' value="<?php echo ($pay['v_md5info']); ?>">
	<input type="submit" name="" value="付款">
	</form>                
</body>
</html>