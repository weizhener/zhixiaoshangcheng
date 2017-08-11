<?php echo $this->fetch('header.html'); ?>

<script type="text/javascript">

$(function(){

    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});

    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});

});

</script>



<div id="rightTop">

    <p>积分产品兑换</p>

    <ul class="subnav">

        <li><span>管理</span></li>

    </ul>

</div>

<div class="mrightTop">

    <div class="fontl">

        <form method="get">

            <div class="left">

                <input type="hidden" name="app" value="integral_goods_log" />

                <input type="hidden" name="act" value="index" />

                用户名:

                <input class="queryInput" type="text" name="user_name" value="<?php echo htmlspecialchars($_GET['user_name']); ?>" />

                积分产品名称:

                <input class="queryInput" type="text" name="goods_name" value="<?php echo htmlspecialchars($_GET['goods_name']); ?>" />

                

                <select class="querySelect" name="state">

                    <option value="">状态</option>

                    <?php echo $this->html_options(array('options'=>$this->_var['states'],'selected'=>$this->_var['query']['state'])); ?>

                </select>

                时间由:<input class="queryInput2" type="text" value="<?php echo $this->_var['query']['add_time_from']; ?>" id="add_time_from" name="add_time_from" class="pick_date" />

                至:<input class="queryInput2" type="text" value="<?php echo $this->_var['query']['add_time_to']; ?>" id="add_time_to" name="add_time_to" class="pick_date" />

                <input type="submit" class="formbtn" value="查询" />

            </div>

            <?php if ($this->_var['filtered']): ?>

            <a class="left formbtn1" href="index.php?app=integral_goods_log">撤销检索</a>

            <?php endif; ?>

        </form>

    </div>

    <div class="fontr"><?php echo $this->fetch('page.top.html'); ?></div>

</div>

<div class="tdare">

    <table width="100%" cellspacing="0" class="dataTable">

        <?php if ($this->_var['integral_goods_log_list']): ?>

        <tr class="tatr1">

            <td>积分产品名称</td>

            <td>用户名</td>

            <td>回购金额</td>


            <td>操作时间</td>

            <td>当前状态</td>

            <td>操作</td>

        </tr>

        <?php endif; ?>

        <?php $_from = $this->_var['integral_goods_log_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'integral_goods_log');if (count($_from)):
    foreach ($_from AS $this->_var['integral_goods_log']):
?>

        <tr class="tatr2">

            <td><?php echo htmlspecialchars($this->_var['integral_goods_log']['goods_name']); ?></td>

            <td><?php echo htmlspecialchars($this->_var['integral_goods_log']['user_name']); ?></td>

            <td><?php echo htmlspecialchars($this->_var['integral_goods_log']['money']); ?></td>




            <td><?php echo local_date("Y-m-d H:i:s",$this->_var['integral_goods_log']['add_time']); ?></td>
			
            <td><?php echo htmlspecialchars($this->_var['integral_goods_log']['state']); ?></td>
			

            <td class="handler">

                <a href="index.php?app=integral_goods_log&amp;act=edit&amp;id=<?php echo $this->_var['integral_goods_log']['id']; ?>">编辑</a>

            </td>

        </tr>

        <?php endforeach; else: ?>

        <tr class="no_data">

            <td colspan="10">没有符合条件的记录</td>

        </tr>

        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>

    </table>

    <?php if ($this->_var['integral_goods_log_list']): ?>

    <div id="dataFuncs">

        <div class="pageLinks"><?php echo $this->fetch('page.bottom.html'); ?></div>

        <div class="clear"></div>

    </div>

    <?php endif; ?>

</div>

<?php echo $this->fetch('footer.html'); ?>