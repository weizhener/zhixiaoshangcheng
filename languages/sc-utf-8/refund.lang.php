<?php

return array(
    'buyer' => '买家',
    'seller' => '卖家',
    'admin' => '平台客服',
    'not_allow_refund' => '您不是该订单的买家，或者您已经添加过退款申请，不能申请退款！',
    'refund_add' => '添加退款申请',
    'refund_edit' => '修改退款申请',
    'refund_view' => '查看退款详情',        'navication_refuse' => '激活买家账户订单,拒绝退款申请',
    'refund_refuse' => '拒绝退款申请',
    'price_error' => '请输入数字(例:0.02)',
    'refund_fee_ge0' => '退款金额不能为空且必须大于0',
    'refund_shipping_fee_ge0' => '退运费金额不能小于0',
    'refund_fee_gt_total_fee' => '退款金额不能大于商品总额',
    'select_refund_reason' => '请选择退款原因',
    'refund_fee_error' => '退款金额不能小于0或者大于商品总额',
    'refund_shipping_fee_error' => '退运费金额不能大于该商品分摊的运费金额',
    'select_refund_shipped' => '请选择收货情况',
    'shipped_0' => '未收到货，需要退款',
    'shipped_1' => '已收到货，不退货只退款',
    'shipped_2' => '已收到货，需退货退款',
    'add_ok' => '添加成功',
    'submit_ok' => '提交成功',
    'edit_ok' => '编辑成功',
    'no_such_refund' => '退款信息不存在',
    'refund_not_allow_edit' => '对不起，该退款可能已经关闭，或者您没有编辑的权限！',
    'apply_refund_content_change' => '买家申请了退款，退款金额为：%s元，退运费金额：%s元，收货情况为：%s，退款原因为：%s，退款说明为：%s',
    'refund_content_change' => '买家修改了退款申请，退款金额修改为：%s元，退运费金额：%s元，收货情况修改为：%s，退款原因修改为：%s，退款说明修改为：%s',
    'refuse_content_change' => '卖家拒绝了退款申请，拒绝理由为：%s',
    'cancel_content_change' => '取消退款，退款编号为：%s',
    'refund_not_exist' => '退款信息不存在',
    'cancel_not_allow' => '对不起，该退款可能已经关闭，或者您没有取消退款的权限！',
    'cancel_ok' => '取消成功，退款关闭',
    'refuse_not_allow' => '对不起，您没操作该退款的权限！',
    'ask_customer_not_allow' => '对不起，您没操作该退款的权限！',
    'ask_customer_content_change' => '%s要求客服介入处理',
    'ask_customer_ok' => '该退款已要求客服介入处理',
    'add_refund_message_not_allow' => '已经退款成功，或者退款已经关闭的退款，不能再添加留言！',
    'refund_message_image_upload_error' => '退款凭证上传失败，请重新上传',
    'submit' => '提交',
    'agree_no_allow' => '对不起，您没操作该退款的权限！',
    'seller_agree_refund_ok' => '您已经同意了买家的退款申请，退款成功！。',
    'seller_agree_refund_error' => '执行过程中出现错误！',
    'payment_not_support_refund' => '该支付方式非虚拟货币支付，不支持退款',
    'seller_agree_refund_money'=>'您的可用资金不足:%s,不能同意退款,需联系买家确认收货，或充值金额才可以进行操作',
);
?>