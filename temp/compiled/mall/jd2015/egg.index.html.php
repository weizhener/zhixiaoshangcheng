<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title>疯狂砸蛋！</title>

        <link href="<?php echo $this->res_base . "/" . 'css/egg.css'; ?>" rel="stylesheet" type="text/css" />

    </head>

    <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/jquery-1.4.2.min.js'; ?>"></script>

    <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/egg.js'; ?>"></script>

    <script type="text/javascript">

        $(document).ready(function () {

            //幻灯（奖品展示）

            $('#example2').bxCarousel({

                display_num: 1, //显示的内容数量

                move: 1, //一次移动几个内容

                auto: true, //加载页面后是否自动滚动

                controls: false, //是否添加控制元件

                margin: 10,

                auto_hover: true //鼠标放上时是否暂停

            });



            //change_egg

            $('#egg_type').change(function () {

                var egg_t = $(this).children('option:selected').val();   //弹出select的值

                if (egg_t != "0") {

                    $('img[name="egg"]').each(function () {

                        this.src = "<?php echo $this->res_base . "/" . ''; ?>images/egg/lock_" + egg_t + ".gif";

                    });

                }

            });



        });

    </script>

    <body id='cc'>



        <div class="wrapper">

            <div id="top">

            </div>

            <div id="content">

                <div class="main">

                    <div class="login">

                        <div class="side" style="float:left">

                            <div class="dl">

                                <?php if ($this->_var['visitor']['user_id']): ?>

                                <div id="logined" style="display:block;"><a href="index.php?app=member&act=logout" style="cursor:hand;" class="logout">用户注销</a></div>

                                <?php else: ?>

                                <div id="unlogin" style="display:block" ><a href="index.php?app=member&act=login" class="login">用户登录</a></div>

                                <?php endif; ?><a href="<?php echo $this->_var['site_url']; ?>/" style="color:#000">返回首页</a>

                                <input id="user_id" type="hidden" value="<?php echo $this->_var['visitor']['user_id']; ?>"/>

                            </div>



                            <div class="cl">

                                <form name=form1 action="" method=post marginWidth=0 marginHeight=0 frameBorder=0> 

                                    <table width="278" border="0" cellspacing="0" cellpadding="0">

                                        <tr>

                                            <td width="105" height="30"><font color="#000000" style="font-size:13px;"><b>请选择要砸的蛋:</b></font></td>

                                            <td>

                                                <select name="areaid" id="egg_type">

                                                    <option value="0">=请选择=</option>

                                                    <option value="1">=金蛋=</option>

                                                    <option value="2">=银蛋=</option>

                                                    <option value="3">=铜蛋=</option>

                                                </select>

                                            </td>

                                            <td width="58"></td>

                                        </tr>

                                    </table>

                                </form>

                            </div>

                        </div>

                        <div class="side_right">

                            <!--<b>1、这里是活动介绍这里是活动介绍这里是活动介绍</b><br />

                            <b>2、这里是活动介绍这里是活动介绍这里是活动介绍</b><br />

                            <b>3、这里是活动介绍这里是活动介绍这里是活动介绍</b><br />

                            <b class="timedes" >活动时间: 2012-05-01 至 2012-05-02</b>-->

                        </div>

                    </div>

                    <div class="integral">

                        <div class="zd">

                            <div class="m">

                                <script>

                                    function ex(t)

                                    {

                                        if ($('#user_id').val() == "0") {

                                            alert("请先登录");

                                            return;

                                        } else if ($('#egg_type').val() == "0") {

                                            alert("请先选择要砸的蛋");

                                            return;

                                        } else if ($('#isex').val() == "0") {

                                            alert("请点下方的 继续砸蛋 ");

                                            return;

                                        } else {

                                        }

                                        var eggid = $('#egg_type').val();

                                        //alert(""+eggid);

                                        $.get('index.php?app=egg&act=eggact_ajax&ajax=1',

                                                {

                                                    egg_type: function () {

                                                        return $('#egg_type').val();

                                                    }

                                                },

                                        function (data) //回传函数  

                                        {

                                            $("#e" + t).children('img').attr("src", "<?php echo $this->res_base . "/" . ''; ?>images/egg/ege_0" + eggid + ".gif");

                                            $("#isex").val("0");

                                            $("#goon").show();

                                            alert(data);

                                        }

                                        );

                                    }

                                    function goonegg()

                                    {

                                        $("#isex").val("1");

                                        $("#goon").hide();

                                        var egg_t = $("#egg_type").children('option:selected').val();

                                        $('img[name="egg"]').each(function () {

                                            this.src = "<?php echo $this->res_base . "/" . ''; ?>images/egg/lock_" + egg_t + ".gif";

                                        });

                                    }

                                </script>

                                <input id="isex" type="hidden" value="1"/>

                                <div class="d"><a class="da" id="e1" href="javascript:ex(1);"><img name="egg" src="<?php echo $this->res_base . "/" . 'images/egg/lock_1.gif'; ?>"/></a></div>

                                <div class="d"><a class="da" id="e2" href="javascript:ex(2);"><img name="egg" src="<?php echo $this->res_base . "/" . 'images/egg/lock_2.gif'; ?>"/></a></div>

                                <div class="d"><a class="da" id="e3" href="javascript:ex(3);"><img name="egg" src="<?php echo $this->res_base . "/" . 'images/egg/lock_3.gif'; ?>"/></a></div>

                            </div>

                            <div class="b b1" id="goon"><a href="javascript:goonegg()">继续砸蛋！</a></div>

                            <div class="b b2">很遗憾！什么也没有砸中，再接再厉吧！</div>

                            <div class="b b3">太棒了！你砸中了<a> xjj </a>！</div>

                        </div>

                    </div> 

                    <div class="clock">

                        <div class="dk" style="position:relative">

                            <div class="m1"><b>中奖纪录 & 奖品</b></div>

                            <div class="m2">

                                <table>

                                    <?php $_from = $this->_var['eggpresentrec_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'eggpresentrec');if (count($_from)):
    foreach ($_from AS $this->_var['eggpresentrec']):
?>

                                    <tr>

                                        <td align="left" width="80%">恭喜用户 <a><?php echo sub_str($this->_var['eggpresentrec']['username'],9); ?></a> 砸中 <a><?php echo htmlspecialchars($this->_var['eggpresentrec']['presentname']); ?></a></td>

                                        <td align="right" width="20%"><?php echo local_date("m月d日",$this->_var['eggpresentrec']['add_time']); ?></td>

                                    </tr>

                                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

                                </table>

                            </div>

                            <div class="m3" style="position:relative;">

                                <b style="position:absolute;top:35%;left:35%">LOADING...</b>

                                <div class="examples_body">

                                    <div class="bx_wrap">

                                        <div class="bx_container">

                                            <ul id="example2" style="position:relative">

                                                <?php $_from = $this->_var['eggpresent_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'eggpresent');if (count($_from)):
    foreach ($_from AS $this->_var['eggpresent']):
?>

                                                <li><img height="160" width="240" src="<?php echo $this->_var['eggpresent']['eggpresent_logo']; ?>"></li>

                                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

                                            </ul>

                                        </div>

                                    </div>

                                </div>



                            </div>

                        </div>

                    </div>  

                </div>		   

            </div>

            <!--<div id="footer">

                <div class="notes">

                    <b>注意事项：</b><br/>

　　1、这里是注意事项这里是注意事项这里是注意事项这里是注意事项。<br/>

　　2、这里是注意事项这里是注意事项这里是注意事项这里是注意事项。<br/>

　　3、这里是注意事项这里是注意事项这里是注意事项这里是注意事项。<br/> 

　　4、这里是注意事项这里是注意事项这里是注意事项这里是注意事项。<br/>

                </div>

            </div>-->

        </div><style>#example2 li{display:none}</style>

    </body>

</html>

