<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
        <?php echo $this->fetch('my_statistics.select.html'); ?>
        <?php echo $this->fetch('member.submenu.html'); ?>

        <style>
            table {BORDER-RIGHT: #cedced 1px solid;border-left: 1px solid #CEDCED;BORDER-TOP: #cedced 1px solid;MARGIN: 0.6em auto;WIDTH: 100%;BORDER-BOTTOM: #cedced 1px solid;BORDER-COLLAPSE: collapse;}
            TD {PADDING-RIGHT: 0.9em; PADDING-LEFT: 0.9em; PADDING-BOTTOM: 0.3em; BORDER-right: #cedced 1px solid; COLOR: #000; PADDING-TOP: 0.3em; BORDER-BOTTOM: #cedced 1px solid; TEXT-ALIGN: left}
            TH {PADDING-RIGHT: 10px; PADDING-LEFT: 10px; FONT-WEIGHT: normal; PADDING-BOTTOM: 0.3em; BORDER-right: #cedced 1px solid; COLOR: #5e759d; PADDING-TOP: 0.3em; BORDER-BOTTOM: #cedced 1px solid; text-align: left;height: 20px;}
            THEAD TH {FONT-WEIGHT: lighter; FONT-SIZE: 14px; BACKGROUND: #e9f1fa; COLOR: #638199; TEXT-ALIGN: left}
            .th1 {FONT-WEIGHT: bold; FONT-SIZE: 14px; COLOR: #333333; BORDER-BOTTOM: #cedced 2px solid; BACKGROUND-COLOR: #fff; TEXT-ALIGN: left}
            .odd TH {FONT-WEIGHT: bold; COLOR: #282828; text-align: left;}
            .odd .all_left {TEXT-ALIGN: left}
        </style>


        <div class="tabdiv1">
            <table width="770">
                <?php if ($this->_var['statistics_page_ranking']): ?>
                <thead>
                    <tr class="odd">
                        <th width="53%" class="all_left"><strong>页面URL</strong></th>
                        <th width="15%" class="all_left"><strong>访问次数(VV)</strong></th>
                        <th width="15%"><strong>独立访客(UV)</strong></th>
                        <th width="17%" class="all_left"><strong>独立IP</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $_from = $this->_var['statistics_page_ranking']['url']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'url');$this->_foreach['f_url'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f_url']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['url']):
        $this->_foreach['f_url']['iteration']++;
?>
                    <tr>
                        <td><a href="<?php echo $this->_var['key']; ?>" target="_blank" title="<?php echo $this->_var['key']; ?>"><?php echo sub_str($this->_var['key'],70); ?></a></td>
                        <td class="num1"><?php echo $this->_var['url']['vv']; ?></td>
                        <td><?php echo $this->_var['url']['uv']; ?></td>
                        <td><?php echo $this->_var['url']['ip']; ?></td>
                    </tr>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <tr>
                        <td>页面汇总</td>
                        <td class="num1"><?php echo $this->_var['statistics_page_ranking']['total']['vv']; ?></td>
                        <td><?php echo $this->_var['statistics_page_ranking']['total']['uv']; ?></td>
                        <td><?php echo $this->_var['statistics_page_ranking']['total']['ip']; ?></td>
                    </tr>
                </tbody>
                <?php else: ?>
                暫時沒有數據
                <?php endif; ?>
            </table>
        </div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>