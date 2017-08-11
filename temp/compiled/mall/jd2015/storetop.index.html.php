<?php echo $this->fetch('member.header.html'); ?>
<script type="text/javascript">
    $(function() {
        $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
        $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>
<style type="text/css">
    .table .line td{border:none;}
    .float_right {float: right;}
    .line{border-bottom:1px solid #E2E2E2}
</style>
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
        <?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class="public table">
                <div class="user_search">
                   
                </div>		

                <table>
                    <?php if ($this->_var['stores']): ?>
                    <tr class="line tr_bgcolor">
                        <th width="10%">卖家</th>
                        <th width="10%" align="center">销售量</th>
                        <th width="60%">销售额</th>
                        <th width="10%">余额</th>
                        
                    </tr>
                    <?php endif; ?>
                    <?php $_from = $this->_var['stores']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'epaylog');$this->_foreach['v'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['v']['total'] > 0):
    foreach ($_from AS $this->_var['epaylog']):
        $this->_foreach['v']['iteration']++;
?>
                    <?php if (($this->_foreach['v']['iteration'] == $this->_foreach['v']['total'])): ?><tr class="line_bold"><?php else: ?><tr class="line"><?php endif; ?>
                        <td align="center"><?php echo $this->_var['epaylog']['store_name']; ?></td>
                        <td align="center"><?php echo $this->_var['epaylog']['quantity']; ?></td>
                        <td align="center"><?php echo $this->_var['epaylog']['goods_amount']; ?></td>
                        <td align="center"><?php echo $this->_var['epaylog']['money']; ?></td>
                      
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="5" class="member_no_records padding6"><?php echo $this->_var['lang'][$_GET['act']]; ?>没有符合条件的记录</td>
                    </tr>
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <?php if ($this->_var['epaylog_list']): ?>
                    <tr class="sep-row">
                        <td colspan="7"></td>
                    </tr>
                    <tr class="operations">
                        <th colspan="7">
                            <p class="position2 clearfix">
                                <?php echo $this->fetch('member.page.bottom.html'); ?>
                            </p>
                        </th>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
            <div class="wrap_bottom"></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"></div>
<?php echo $this->fetch('footer.html'); ?>
