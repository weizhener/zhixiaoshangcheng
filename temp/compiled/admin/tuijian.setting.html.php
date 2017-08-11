<?php echo $this->fetch('header.html'); ?>

<div id="rightTop">
    <p>推荐分成设置</p>
    <ul class="subnav">
        <!--
        <li><a class="btn1" href="index.php?app=setting&amp;act=base_setting">base_setting</a></li>
        -->
        <li><span>推荐设置</span></li>
    </ul>
</div>

<div class="info">
    <form method="post" enctype="multipart/form-data">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">设置提示</th>
                <td class="paddingT15">分成比例分为三级,分成的金额为总价的百分比,(建议默认设置1级为5%,2级为2%,3级为1%)<br/>注意：总和不能大于100</td>
            </tr>
            <tr>
                <th class="paddingT15">推荐成为店铺扣除佣金:</th>
                <td class="paddingT15">
                    <input type="radio" name="tuijian_seller_status" <?php if ($this->_var['setting']['tuijian_seller_status'] == 0): ?>checked<?php endif; ?> value="0" />
                           <label>否</label>
                    <input type="radio" name="tuijian_seller_status" <?php if ($this->_var['setting']['tuijian_seller_status'] == 1): ?>checked<?php endif; ?> value="1" />
                           <label>是</label>        
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    推荐成为店铺级别1:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="tuijian_seller_ratio1" type="text" name="tuijian_seller_ratio1" value="<?php echo $this->_var['setting']['tuijian_seller_ratio1']; ?>"/>
                    <label class="field_notice">%</label>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    推荐成为店铺级别2:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="tuijian_seller_ratio2" type="text" name="tuijian_seller_ratio2" value="<?php echo $this->_var['setting']['tuijian_seller_ratio2']; ?>"/>
                    <label class="field_notice">%</label>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    推荐成为店铺级别3:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="tuijian_seller_ratio3" type="text" name="tuijian_seller_ratio3" value="<?php echo $this->_var['setting']['tuijian_seller_ratio3']; ?>"/>
                    <label class="field_notice">%</label>
                </td>
            </tr>
            
            
            <tr>
                <th class="paddingT15">推荐成为用户扣除佣金:</th>
                <td class="paddingT15">
                    <input type="radio" name="tuijian_buyer_status" <?php if ($this->_var['setting']['tuijian_buyer_status'] == 0): ?>checked<?php endif; ?> value="0" />
                           <label>否</label>
                    <input type="radio" name="tuijian_buyer_status" <?php if ($this->_var['setting']['tuijian_buyer_status'] == 1): ?>checked<?php endif; ?> value="1" />
                           <label>是</label>        
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    推荐成为会员级别1:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="tuijian_buyer_ratio1" type="text" name="tuijian_buyer_ratio1" value="<?php echo $this->_var['setting']['tuijian_buyer_ratio1']; ?>"/>
                    <label class="field_notice">%</label>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    推荐成为会员级别2:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="tuijian_buyer_ratio2" type="text" name="tuijian_buyer_ratio2" value="<?php echo $this->_var['setting']['tuijian_buyer_ratio2']; ?>"/>
                    <label class="field_notice">%</label>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    推荐成为会员级别3:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="tuijian_buyer_ratio3" type="text" name="tuijian_buyer_ratio3" value="<?php echo $this->_var['setting']['tuijian_buyer_ratio3']; ?>"/>
                    <label class="field_notice">%</label>
                </td>
            </tr>
            
            <tr>
                <th></th>
                <td class="ptb20">
                    <input class="formbtn" type="submit" name="Submit" value="提交" />
                    <input class="formbtn" type="reset" name="Submit2" value="重置" />
                </td>
            </tr>
        </table>
    </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
