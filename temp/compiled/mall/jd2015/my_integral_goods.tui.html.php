<?php echo $this->fetch('member.header.html'); ?>

<div class="content">

    <?php echo $this->fetch('member.menu.html'); ?>

    <div id="right">

        <?php echo $this->fetch('member.submenu.html'); ?>

        <div class="wrap">

            <div class="public">

                <form method="post" id="integral_goods_form">

                    <div class="information">

                        <div class="info individual">

                            <table>

                                <tbody>

                                    <tr>

                                        <th class="width4" style="width:100px;">退货产品: </th>

                                        <td><?php echo htmlspecialchars($this->_var['integral_goods_log']['goods_name']); ?></td>

                                    </tr>

                                    <tr>

                                        <th class="width4">退货金额: </th>

                                        <td><?php echo htmlspecialchars($this->_var['integral_goods_log']['money']); ?></td>

                                    </tr>
                                    <tr>

                                        <th>银行户名:</th>

                                        <td><input type="text" class="text width" name="truename" value=""></td>

                                    </tr>
									

                                    <tr>

                                        <th>开户银行:</th>

                                        <td><input type="text" class="text width_normal" name="bankname" value=""></td>

                                    </tr>

                                    <tr>

                                        <th>开户行名称:</th>

                                        <td>

                                            <input type="text" class="text width" name="bankadd" value="">

                                        </td>

                                    </tr>
									
                                    <tr>

                                        <th>银行卡号:</th>

                                        <td>

                                            <input type="text" class="text width" name="bankcard" value="">

                                        </td>

                                    </tr>


                                    <tr>

                                        <th></th>

                                        <td><input type="submit" class="btn" value="确认退货"></td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </form>

            </div>

            <div class="wrap_bottom"></div>

        </div>

        <div class="clear"></div>

    </div>

    <div class="clear"></div>

</div>

<?php echo $this->fetch('footer.html'); ?>

