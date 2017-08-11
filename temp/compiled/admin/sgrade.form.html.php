<?php echo $this->fetch('header.html'); ?>

<script type="text/javascript">

$(function(){

    $('#grade_form').validate({

        errorPlacement: function(error, element){

            $(element).next('.field_notice').hide();

            $(element).after(error);

        },

        success       : function(label){

            label.addClass('right').text('OK!');

        },

        onkeyup    : false,

        rules : {

            grade_name : {

                required : true,

                remote   : {

                url :'index.php?app=sgrade&act=check_grade',

                type:'get',

                data:{

                        grade_name : function(){

                        return $('#grade_name').val();

                        },

                        id  : '<?php echo $this->_var['sgrade']['grade_id']; ?>'

                    }

                }

            },

            goods_limit : {

                digits  : true

            },

            space_limit : {

                digits : true

            },

            sort_order : {

                number  : true

            }

        },

        messages : {

            grade_name : {

                required : '等级名称不能为空',

                remote   : '该等级名称已经存在，请您换一个'

            },

            goods_limit : {

                digits : '仅能为整数'

            },

            space_limit : {

                digits  : '仅能为整数'

            },

            sort_order  : {

                number   : '仅能为数字'

            }

        }

    });

});

</script>

<div id="rightTop">

  <p>店铺等级</p>

  <ul class="subnav">

    <li><a class="btn1" href="index.php?app=sgrade">管理</a></li>

    <li>

      <?php if ($this->_var['sgrade']['grade_id']): ?>

      <a class="btn1" href="index.php?app=sgrade&amp;act=add">新增</a>

      <?php else: ?>

      <span>新增</span>

      <?php endif; ?>

    </li>

  </ul>

</div>

<div class="info">

  <form method="post" enctype="multipart/form-data" id="grade_form">

    <table class="infoTable">

      <tr>

        <th class="paddingT15"> 等级名称:</th>

        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" name="grade_name" type="text" id="grade_name" value="<?php echo $this->_var['sgrade']['grade_name']; ?>" />   <label class="field_notice">等级名称</label>     </td>

      </tr>

      <tr>

        <th class="paddingT15"> 允许发布商品数:</th>

        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" name="goods_limit" type="text" id="goods_limit" value="<?php echo $this->_var['sgrade']['goods_limit']; ?>" />

          <!--<span class="grey">0表示没有限制</span>--> <label class="field_notice">0表示没有限制</label>       </td>

      </tr>

      <tr>

        <th class="paddingT15"> 上传空间大小(MB):</th>

        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" name="space_limit" type="text" id="space_limit" value="<?php echo $this->_var['sgrade']['space_limit']; ?>" />

          <!--<span class="grey">0表示没有限制</span>-->  <label class="field_notice">0表示没有限制</label>      </td>

      </tr>

      <tr>

        <th class="paddingT15"> <label for="skin_limit">可选模板套数:</label></th>

        <td class="paddingT15 wordSpacing5"><?php echo $this->_var['sgrade']['skin_limit']; ?>

          <span class="grey">（在店铺等级列表设置）</span>        </td>

      </tr>

      <?php if ($this->_var['functions']): ?>

      <tr>

        <th class="paddingT15"> <label for="skin_limit">可用附加功能:</label></th>

        <td class="paddingT15 wordSpacing5">

            <?php $_from = $this->_var['functions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'func');if (count($_from)):
    foreach ($_from AS $this->_var['func']):
?>

                <input type="checkbox" name="functions[]"<?php if ($this->_var['checked_functions'][$this->_var['func']]): ?> checked<?php endif; ?> value="<?php echo $this->_var['func']; ?>" id="function_<?php echo $this->_var['func']; ?>" /><label for="function_<?php echo $this->_var['func']; ?>">&nbsp;<?php echo $this->_var['lang'][$this->_var['func']]; ?></label>&nbsp;&nbsp;

            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

        </td>

      </tr>

      <?php endif; ?>

      <tr>

        <th class="paddingT15"> 收费标准:</th>

        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" name="charge" type="text" id="charge" value="<?php echo $this->_var['sgrade']['charge']; ?>" />

          <label class="field_notice">收费标准</label>        </td>

      </tr>
      
      
      <tr>

        <th class="paddingT15"> 每日返利:</th>

        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" name="money" type="text" id="money" value="<?php echo $this->_var['sgrade']['money']; ?>" />

          <label class="field_notice">每日返利</label>        </td>

      </tr>

      <tr>

        <th class="paddingT15">需要审核:</th>

        <td class="paddingT15 wordSpacing5"><p>

            <label>

            <input type="radio" name="need_confirm" value="1"<?php if ($this->_var['sgrade']['need_confirm'] == "1"): ?> checked="checked"<?php endif; ?> />

            是</label>

            <label>

            <input type="radio" name="need_confirm" value="0"<?php if ($this->_var['sgrade']['need_confirm'] == "0"): ?> checked="checked"<?php endif; ?> />

            否</label>

          </p></td>

      </tr>

      <tr>

        <th class="paddingT15" valign="top">申请说明:</th>

        <td class="paddingT15 wordSpacing5">

        <textarea name="description" id="description"><?php echo $this->_var['sgrade']['description']; ?></textarea></td>

      </tr>

      <tr>

        <th class="paddingT15">排序:</th>

        <td class="paddingT15 wordSpacing5"><input class="sort_order" name="sort_order" type="text" id="sort_order" value="<?php echo $this->_var['sgrade']['sort_order']; ?>" /></td>

      </tr>

      <tr>

        <th></th>

        <td class="ptb20"><input class="formbtn" type="submit" name="Submit" value="提交" />

          <input class="formbtn" type="reset" name="Reset" value="重置" />        </td>

      </tr>

    </table>

  </form>

</div>

<?php echo $this->fetch('footer.html'); ?>