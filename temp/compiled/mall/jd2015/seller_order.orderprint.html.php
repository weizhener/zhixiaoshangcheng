<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>
            订单打印
        </title>
        <style type="text/css">
            * {margin:0;padding:0}
            body {font:12px/1.5  "宋体";color:#333}
            .w{width:100%}
            .m1 td{height:0.6cm;line-height:0.6cm;}
            .t3,.t7,.t6{width:1.6cm}
            .t1{width:6.8cm}
            .t5{width:1.1cm}
            .tb4{border-collapse:collapse;border:1px solid #000}
            .tb4 th, .tb4 td,.d1{border:1px solid #000}
            .tb4 td {padding:1px}
            .tb4 th {height:0.6cm;font-weight:normal}
            .m1,.m2,.m3{padding-top:10px}
            .d1{padding:10px}
            .d2{text-align:right;padding:10px 0;font-size:14px}
            .logo{border-bottom:1px solid #ccc;padding:10px;text-align: center;}
            .v-h{text-align:center}
            .m2{padding-left:1px}
            .print{color: #fff;background-color: #ff8a00;border-color: #ea7f00;height: 28px;width: 200px;line-height: 28px;border: 0px;margin-top:10px;}
        </style>
        <style type="text/css" media="print">
            .v-h {display:none;}
        </style>

    </head>
    <body>
        <form name="form1">
            <div class="v-h"><input class="print" name="" type="button" value="打印" onclick="javascript:window.print();" /></div>
            <div class="w">
                <div class="logo"><img  height="60" src="<?php echo $this->_var['site_logo']; ?>" /></div>
                <div class="m1">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="t1"><strong>订单编号：</strong><?php echo $this->_var['order']['order_sn']; ?></td>
                            <td class="t2"><strong>订购时间：</strong><?php echo local_date("Y-m-d H:i:s",$this->_var['order']['order_add_time']); ?></td>
                        </tr>
                        <tr>
                            <td class="t1"><strong>客户姓名：</strong><?php echo htmlspecialchars($this->_var['order_extm']['consignee']); ?></td>
                            <td class="t2"><strong>联系方式：</strong><?php if ($this->_var['order_extm']['phone_mob']): ?>, &nbsp;<?php echo $this->_var['order_extm']['phone_mob']; ?><?php endif; ?><?php if ($this->_var['order_extm']['phone_tel']): ?>,&nbsp;<?php echo $this->_var['order_extm']['phone_tel']; ?><?php endif; ?></td>
                        </tr>
                        <tr>
                            <td class="t1"><strong>物流名称：</strong><?php echo htmlspecialchars($this->_var['order_extm']['shipping_name']); ?></td>
                            <td class="t2"><strong>物流单号：</strong><?php echo htmlspecialchars($this->_var['order']['invoice_no']); ?></td>

                        </tr>
                        <tr>
                            <td class="t1"><strong>买家附言：</strong><?php echo htmlspecialchars($this->_var['order']['postscript']); ?></td>
                            <td class="t2"><strong>备注：</strong><?php echo htmlspecialchars($this->_var['order_extm']['remarks']); ?></td>
                        </tr>
                    </table>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="t8"><strong>客户地址：</strong><?php echo htmlspecialchars($this->_var['order_extm']['region_name']); ?>&nbsp;<?php echo htmlspecialchars($this->_var['order_extm']['address']); ?></td>
                        </tr>
                    </table>
                    <br/>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="t1"><strong>店铺名称：</strong><?php echo htmlspecialchars($this->_var['order']['store_name']); ?></td>
                            <td class="t2"><strong>电话号码：</strong><?php echo (htmlspecialchars($this->_var['order']['tel']) == '') ? '-' : htmlspecialchars($this->_var['order']['tel']); ?></td>
                        </tr>
                        <tr>
                            <td class="t1"><strong>所在地区：</strong><?php echo (htmlspecialchars($this->_var['order']['region_name']) == '') ? '-' : htmlspecialchars($this->_var['order']['region_name']); ?></td>
                            <td class="t2"><strong>手机号码：</strong><?php echo (htmlspecialchars($this->_var['order']['phone_mob']) == '') ? '-' : htmlspecialchars($this->_var['order']['phone_mob']); ?></td>
                        </tr>
                        <tr>
                            <td class="t1"><strong>msn：</strong><?php echo (htmlspecialchars($this->_var['order']['im_msn']) == '') ? '-' : htmlspecialchars($this->_var['order']['im_msn']); ?></td>
                            <td class="t2"><strong>详细地址：</strong><?php echo (htmlspecialchars($this->_var['order']['address']) == '') ? '-' : htmlspecialchars($this->_var['order']['address']); ?></td>
                        </tr>
                    </table>
                </div>
                <div class="m2">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tb4">
                        <tr>
                            <th class="t3">商品编号</th>
                            <th class="t4">商品名称</th>
                            <th class="t5">数量</th>
                            <th class="t7">商品金额</th>
                        </tr>
                        <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
                        <tr>
                            <td><?php echo $this->_var['goods']['goods_id']; ?></td>
                            <td><div class="p-name"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></div></td>
                            <td><?php echo $this->_var['goods']['quantity']; ?></td>
                            <td><?php echo price_format($this->_var['goods']['price']); ?></td>
                        </tr>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </table>
                </div>
                <div class="m3">
                    <div class="d1">
                        商品总金额：<?php echo price_format($this->_var['order']['goods_amount']); ?>元 + 运费：<?php echo price_format($this->_var['order_extm']['shipping_fee']); ?>元 - 优惠：<?php echo price_format($this->_var['order']['discount']); ?>元 
                    </div>
                    <div class="d2"><strong>邀请支付金额：<?php echo price_format($this->_var['order']['order_amount']); ?></strong></div>
                </div>
            </div>
        </form>

    </body>
</html>
