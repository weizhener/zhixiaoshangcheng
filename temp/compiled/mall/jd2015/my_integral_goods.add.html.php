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

                                        <th class="width4">物品名: </th>

                                        <td><?php echo htmlspecialchars($this->_var['integral_goods']['goods_name']); ?></td>

                                    </tr>
									
                                    <tr>

                                        <th class="width4">物品价格: </th>

                                        <td><?php echo htmlspecialchars($this->_var['integral_goods']['goods_price']); ?></td>

                                    </tr>
									

                                    <input type="hidden" class="text1 width2" name="my_num" value="1">

                                    <tr>

                                        <th>收货姓名:</th>

                                        <td><input type="text" class="text width" name="my_name" value=""></td>

                                    </tr>

                                    <tr>

                                        <th>收货地址:</th>

                                        <td><input type="text" class="text width_normal" name="my_address" id="my_add" value=""></td>

                                    </tr>

                                    <tr>

                                        <th>联系电话:</th>

                                        <td>

                                            <input type="text" class="text width" name="my_mobile" id="my_tel" value="">

                                        </td>

                                    </tr>


                                    <tr>

                                        <th></th>

                                        <td><input type="submit" class="btn" value="确认兑换"></td>

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

