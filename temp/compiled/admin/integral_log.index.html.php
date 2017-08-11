<?php echo $this->fetch('header.html'); ?>

<script type="text/javascript">

$(function(){

    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});

    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});

});

</script>



<div id="rightTop">

    <p>积分记录</p>

    <!--<ul class="subnav">

        <li><span>管理</span></li>

        <li><a class="btn1" href="index.php?app=integral_log&amp;act=set">积分设置</a></li>

    </ul>-->

</div>

<div class="mrightTop">

    <div class="fontl">

        <form method="get">

            <div class="left">

                <input type="hidden" name="app" value="integral_log" />

                <input type="hidden" name="act" value="index" />

                用户名:

                <input class="queryInput" type="text" name="user_name" value="<?php echo htmlspecialchars($_GET['user_name']); ?>" />

                <select class="querySelect" name="integral_type">

                    <option value="">积分类型</option>

                    <?php echo $this->html_options(array('options'=>$this->_var['integral_type_list'],'selected'=>$this->_var['query']['integral_type'])); ?>

                </select>

                时间从:<input class="queryInput2" type="text" value="<?php echo $this->_var['query']['add_time_from']; ?>" id="add_time_from" name="add_time_from" class="pick_date" />

                至:<input class="queryInput2" type="text" value="<?php echo $this->_var['query']['add_time_to']; ?>" id="add_time_to" name="add_time_to" class="pick_date" />

                <input type="submit" class="formbtn" value="查询" />

            </div>

            <?php if ($this->_var['filtered']): ?>

            <a class="left formbtn1" href="index.php?app=integral_log">撤销检索</a>

            <?php endif; ?>

        </form>

    </div>

    <div class="fontr"><?php echo $this->fetch('page.top.html'); ?></div>

</div>

<div class="tdare">

    <table width="100%" cellspacing="0" class="dataTable">

        <?php if ($this->_var['integral_logs']): ?>

        <tr class="tatr1">

            <td>用户名</td>

            <td>积分</td>

            <td>积分类型</td>

            <td>备注</td>

            <td>添加时间</td>

        </tr>

        <?php endif; ?>

        <?php $_from = $this->_var['integral_logs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'integral_log');if (count($_from)):
    foreach ($_from AS $this->_var['integral_log']):
?>

        <tr class="tatr2">

            <td><?php echo htmlspecialchars($this->_var['integral_log']['user_name']); ?></td>

            <td><?php echo htmlspecialchars($this->_var['integral_log']['point']); ?></td>

            <td><?php $_from = $this->_var['integral_type_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'integral_type');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['integral_type']):
?><?php if ($this->_var['key'] == $this->_var['integral_log']['integral_type']): ?><?php echo $this->_var['integral_type']; ?><?php endif; ?><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></td>

            <td><?php echo htmlspecialchars($this->_var['integral_log']['remark']); ?></td>

            <td><?php echo local_date("Y-m-d",$this->_var['integral_log']['add_time']); ?></td>



        </tr>

        <?php endforeach; else: ?>

        <tr class="no_data">

            <td colspan="10">没有符合条件的记录</td>

        </tr>

        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>

    </table>

    <?php if ($this->_var['integral_logs']): ?>

    <div id="dataFuncs">

        <div class="pageLinks"><?php echo $this->fetch('page.bottom.html'); ?></div>

        <div class="clear"></div>

    </div>

    <?php endif; ?>

</div>

<?php echo $this->fetch('footer.html'); ?>