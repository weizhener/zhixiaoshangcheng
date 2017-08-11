<?php echo $this->fetch('header.html'); ?>
 
<div id="rightTop">
    <p>幸运大转盘</p>
    <ul class="subnav">
        <li><a class="btn3" href="index.php?module=dazhuanpan">大转盘设置</a></li>
        <li><a class="btn3" href="index.php?module=dazhuanpan&act=dazhuanpan_jiangpin">奖品列表</a></li>
        <li><span>增加奖品</span></li>
         <li><a class="btn3" href="index.php?module=dazhuanpan&act=dazhuanpan_log">中奖记录</a></li>
    </ul>
</div>
<div class="info">
 
     <form method="post">
     <input type="hidden" id="id" name="id" value="<?php echo $this->_var['jiangpin']['id']; ?>"/>
        <table class="infoTable">
             
            <tr>
                <th class="paddingT15">
                    奖品名称:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="title" type="text" name="title" value="<?php echo $this->_var['jiangpin']['title']; ?>"/>
                <span class="grey">填写的奖品名称被抽到会在大转盘上显示</span>
                </td>
            </tr>
            
            <tr>
                <th class="paddingT15">
                    积分金额:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="money" type="text" name="money" value="<?php echo $this->_var['jiangpin']['money']; ?>"/>
                <span class="grey">中奖后直接赠送的积分</span>
                </td>
            </tr>
            
            <tr>
                <th class="paddingT15">
                    中奖概率:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="gailv" type="text" name="gailv" value="<?php echo $this->_var['jiangpin']['gailv']; ?>"/>
                <span class="grey">数字越大概率越大</span>
                </td>
            </tr>
             <tr>
                <th class="paddingT15">
                    奖品数量:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="num" type="text" name="num" value="<?php echo $this->_var['jiangpin']['num']; ?>"/>
                <span class="grey">填写准确的奖品数量，奖品抽完后不会再被抽中</span>
                </td>
            </tr>
           <tr>
                <th class="paddingT15">
                    指针角度:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="zhizhen" type="text" name="zhizhen" value="<?php echo $this->_var['jiangpin']['zhizhen']; ?>"/>
                <span class="grey">填写准确指针角度</span>
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
