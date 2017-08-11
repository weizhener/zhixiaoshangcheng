<div class="message">
    <?php if ($this->_var['evaluation_data']): ?>
    <script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'search_goods.js'; ?>" charset="utf-8"></script>
    <script>
        $(function() {
            $("input[name='evalscore']").bind("click", function() {
                replaceParam('evalscore', this.value, 'show_comment');
            });
            $("input[name='havecomment']").bind("click", function() {
                if (this.checked == true) {
                    replaceParam('havecomment', this.value, 'show_comment');
                } else {
                    dropParam('havecomment');
                }
            });
        });
    </script>
    <div class="nc-g-r" id="show_comment">
        <p>宝贝与描述相符<em><?php echo $this->_var['evaluation_data']['evaluation_desc']; ?></em>分</p>
        <dl class="ncs-rate-column">
            <dt><em style="left:<?php echo $this->_var['evaluation_data']['percent']; ?>%;"><?php echo $this->_var['evaluation_data']['evaluation_desc']; ?></em></dt>
            <dd>非常不满</dd>
            <dd>不满意</dd>
            <dd>一般</dd>
            <dd>满意</dd>
            <dd>非常满意</dd>
        </dl>
        <a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>" target="_blank">店铺评价</a>
    </div>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="nc-comment" id="t">
        <thead class="type">
            <tr>
                <th colspan="2"><div>
            <input name="evalscore" type="radio" value="0" <?php if ($_GET['evalscore'] == '0' || ! $_GET['evalscore']): ?>checked=""<?php endif; ?>>
                   <label for="allRate">全部评价</label>
            <input name="evalscore" type="radio" value="3" <?php if ($_GET['evalscore'] == '3'): ?>checked=""<?php endif; ?>>
                   <label for="goodRate">好评</label> <span style="color:#999;padding-left:2px">(<?php echo $this->_var['comments_count']['good']; ?>)</span>
            <input name="evalscore" type="radio" value="2" <?php if ($_GET['evalscore'] == '2'): ?>checked=""<?php endif; ?>>
                   <label for="mediumRate">中评</label> <span style="color:#999;padding-left:2px">(<?php echo $this->_var['comments_count']['middle']; ?>)</span>
            <input name="evalscore" type="radio" value="1" <?php if ($_GET['evalscore'] == '1'): ?>checked=""<?php endif; ?>>
                   <label for="worstRate">差评</label> <span style="color:#999;padding-left:2px">(<?php echo $this->_var['comments_count']['bad']; ?>)</span>
        </div></th>
        <td><div>
                <input name="havecomment" type="checkbox" value="1" <?php if ($_GET['havecomment'] == '1'): ?>checked<?php endif; ?>>
                       显示有内容的评价</div>
        </td>
        </tr>
        </thead>
    </table>
    <?php endif; ?>
    <?php $_from = $this->_var['goods_comments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'comment');if (count($_from)):
    foreach ($_from AS $this->_var['comment']):
?>
    <dl class="<?php echo $this->cycle(array('values'=>'message_text,message_text bg1')); ?>">
        <dt>
        <span class="light"><?php if ($this->_var['comment']['anonymous']): ?>***<?php else: ?><?php echo htmlspecialchars($this->_var['comment']['buyer_name']); ?><?php endif; ?><img src="<?php echo $this->_var['comment']['buyer_credit_image']; ?>" title="<?php echo $this->_var['comment']['buyer_credit_value']; ?>" /> (<?php echo local_date("Y-m-d H:i:s",$this->_var['comment']['evaluation_time']); ?>)</span>
        </dt>
        <dd><?php echo nl2br(htmlspecialchars($this->_var['comment']['comment'])); ?></dd>
        <div class="beat">
            评价:
            <?php if ($this->_var['comment']['evaluation'] > 0): ?><img src="<?php echo $this->res_base . "/" . 'images/bit.gif'; ?>" /><?php endif; ?>
            <?php if ($this->_var['comment']['evaluation'] > 1): ?><img src="<?php echo $this->res_base . "/" . 'images/bit.gif'; ?>" /><?php endif; ?>
            <?php if ($this->_var['comment']['evaluation'] > 2): ?><img src="<?php echo $this->res_base . "/" . 'images/bit.gif'; ?>" /><?php endif; ?>
            <?php if ($this->_var['comment']['evaluation'] < 3): ?><img src="<?php echo $this->res_base . "/" . 'images/bit2.gif'; ?>" /><?php endif; ?>
            <?php if ($this->_var['comment']['evaluation'] < 2): ?><img src="<?php echo $this->res_base . "/" . 'images/bit2.gif'; ?>" /><?php endif; ?>
            <?php if ($this->_var['comment']['evaluation'] < 1): ?><img src="<?php echo $this->res_base . "/" . 'images/bit2.gif'; ?>" /><?php endif; ?>
        </div>
    </dl>
    <?php endforeach; else: ?>
    <dl class="message_text">
        <dt><span class="light">没有符合条件的记录</span></dt>
    </dl>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>


