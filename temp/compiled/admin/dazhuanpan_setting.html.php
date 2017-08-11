<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>幸运大转盘</p>
    <ul class="subnav">
        <li><span>大转盘设置</span></li>
        <li><a class="btn3" href="index.php?module=dazhuanpan&act=dazhuanpan_jiangpin">奖品列表</a></li>
        <li><a class="btn3" href="index.php?module=dazhuanpan&act=add">增加奖品</a></li>
         <li><a class="btn3" href="index.php?module=dazhuanpan&act=dazhuanpan_log">中奖记录</a></li>
    </ul>
</div>

<div class="info">
    <form method="post">
        <table class="infoTable">
             
          <!--  <tr>
                <th class="paddingT15">
                    大转盘开关:</th>
                <td class="paddingT15 wordSpacing5">
                    <input  id="dazhuanpan_power" type="radio" name="dazhuanpan_power" 
                    value="TRUE"/>
                    开启
                    <input id="dazhuanpan_power" type="radio" name="dazhuanpan_power"  value="FALSE"/>
                    关闭
                <span class="grey">选择打开才可以进行抽奖</span>
                </td>
            </tr>-->
            <tr>
                <th class="paddingT15">
                    大转盘积分:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="dazhuanpan_jifen" type="text" name="dazhuanpan_jifen" value="<?php echo $this->_var['setting']['dazhuanpan_jifen']; ?>"/>
                <span class="grey">大转盘每次抽奖需要的积分数量</span>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    最大概率:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="dazhuanpan_gailv" type="text" name="dazhuanpan_gailv" value="<?php echo $this->_var['setting']['dazhuanpan_gailv']; ?>"/>
                    <span class="grey">比如设置100000 每个奖品的概率的基数就是100000</span>
                </td>
            </tr>
            
            <tr>
                <th class="paddingT15">
                    大转盘空指针角度:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="kongzhizhen" type="text" name="kongzhizhen" value="<?php echo $this->_var['setting']['kongzhizhen']; ?>"/>
                    <span class="grey">未登陆或者没中奖的角度</span>
                </td>
            </tr>
            
            <tr>
                <th class="paddingT15">
                    没中奖提示:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="meizhongtishi" type="text" name="meizhongtishi" value="<?php echo $this->_var['setting']['meizhongtishi']; ?>"/>
                    <span class="grey">没中奖提示语</span>
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