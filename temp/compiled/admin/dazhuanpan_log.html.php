<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>幸运大转盘</p>
    <ul class="subnav">
        <li><a class="btn3" href="index.php?module=dazhuanpan">大转盘设置</a></li>
        <li><a class="btn3" href="index.php?module=dazhuanpan&act=dazhuanpan_jiangpin">奖品列表</a></li>
        <li><a class="btn3" href="index.php?module=dazhuanpan&act=add">增加奖品</a></li>
        <li><span>中奖记录</span></li>
    </ul>
</div>

<div class="tdare">
    <table width="100%" cellspacing="0" class="dataTable">
        <?php if ($this->_var['shangjia_list']): ?>
        <tr class="tatr1">
            <td width="20" class="firstCell"><input id="checkall_1" type="checkbox" class="checkall"/></td>
             <td>会员帐号</td>
             <td>奖品名称</td>
            <td>抽奖时间</td>
            
            <td class="handler">操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['shangjia_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['val']):
?>
        <tr class="tatr2">
            <td width="20" class="firstCell">
            <input type="checkbox" class="checkitem" value="<?php echo $this->_var['val']['id']; ?>" />
            </td>
            <td><?php echo htmlspecialchars($this->_var['val']['user_name']); ?></td>
           
             <td><?php echo htmlspecialchars($this->_var['val']['title']); ?>
             <?php if ($this->_var['val']['is_fangfa'] == "0"): ?><font color="red">(未发放)</font><?php else: ?>（已发放）<?php endif; ?>       
             </td>
              <td><?php echo local_date("Y-m-d",$this->_var['val']['time']); ?></td>
            <td class="handler"> 
             <?php if ($this->_var['val']['is_fangfa'] == "0"): ?><a href="index.php?module=dazhuanpan&amp;act=fafang&amp;id=<?php echo $this->_var['val']['id']; ?>">设置为已发放</a><?php endif; ?>    
            <a href="javascript:if(confirm('您确定要删除它吗？'))window.location = 'index.php?module=dazhuanpan&amp;act=drop_log&amp;id=<?php echo $this->_var['val']['id']; ?>';">删除</a>  </td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="4">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <tfoot>
            <tr>
            <?php if ($this->_var['shangjia_list']): ?>
                <td width="20" class="firstCell"><label for="checkall1"><input id="checkall_2" type="checkbox" class="checkall"></label></td>
                <td colspan="3" id="batchAction">
                    <span class="all_checkbox"><label for="checkall_2">全选</label></span>&nbsp;&nbsp;
                    <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?module=dazhuanpan&act=drop_log" presubmit="confirm('您确定要删除它吗？');" />
                </td>
            <?php endif; ?>
            </tr>
        </tfoot>
        
       
            
                
               
           
        
    </table>
<?php if ($this->_var['page_info']['page_count'] > 1): ?>
<div class="page mtr10">
  <a class="stat"><?php echo sprintf('共 %s ', $this->_var['page_info']['item_count']); ?></a>
  <?php if ($this->_var['page_info']['prev_link']): ?>
  <a class="former" href="<?php echo $this->_var['page_info']['prev_link']; ?>"></a>
  <?php else: ?>
  <span class="formerNull"></span>
  <?php endif; ?>
  <?php if ($this->_var['page_info']['first_link']): ?>
 <a class="page_link" href="<?php echo $this->_var['page_info']['first_link']; ?>">1&nbsp;<?php echo $this->_var['page_info']['first_suspen']; ?></a>
 <?php endif; ?>
  <?php $_from = $this->_var['page_info']['page_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('page', 'link');if (count($_from)):
    foreach ($_from AS $this->_var['page'] => $this->_var['link']):
?>
  <?php if ($this->_var['page_info']['curr_page'] == $this->_var['page']): ?>
  <a class="page_hover" href="<?php echo $this->_var['link']; ?>"><?php echo $this->_var['page']; ?></a>
  <?php else: ?>
  <a class="page_link" href="<?php echo $this->_var['link']; ?>"><?php echo $this->_var['page']; ?></a>
  <?php endif; ?>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <?php if ($this->_var['page_info']['last_link']): ?>
  <a class="page_link" href="<?php echo $this->_var['page_info']['last_link']; ?>"><?php echo $this->_var['page_info']['last_suspen']; ?>&nbsp;<?php echo $this->_var['page_info']['page_count']; ?></a>
  <?php endif; ?>
  <a class="nonce"><?php echo $this->_var['page_info']['curr_page']; ?> / <?php echo $this->_var['page_info']['page_count']; ?></a>
  <?php if ($this->_var['page_info']['next_link']): ?>
  <a class="down" href="<?php echo $this->_var['page_info']['next_link']; ?>">下一页</a>
  <?php else: ?>
  <span class="downNull">下一页</span>
  <?php endif; ?>
</div>
<?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?>