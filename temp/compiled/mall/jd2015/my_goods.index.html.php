<?php echo $this->fetch('member.header.html'); ?>

<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'timepicker.js'; ?>" charset="utf-8"></script>

<script type="text/javascript">

    $(function () {

        var t = new EditableTable($('#my_goods'));

        $('#truncate').click(function () {

            var goods_ids = '<?php echo $this->_var['goods_ids']; ?>';

            if (goods_ids && confirm('<?php echo sprintf('确定要删除检索到的%s条结果吗？删除商品后不可恢复！', $this->_var['page_info']['item_count']); ?>')) {

                $('#truncate_form').append('<input type="hidden" name="act" value="truncate" />');

                $('#truncate_form').append('<input type="hidden" name="goods_ids" value="' + goods_ids + '" />');

                $('#truncate_form').submit();

                return false;

            }

        });

    });

function add_datapacket(goods_id)

{

	<?php if (! $this->_var['visitor']['user_id']): ?>

	alert('请登录');

	<?php else: ?>

    var url = SITE_URL + '/index.php?app=my_datapacket&act=add';

    $.getJSON(url, {'goods_id':goods_id}, function(data){

        //alert(data.msg);

		if(confirm("已经添加至数据包，是否进入查看？")){

    		document.location = SITE_URL + '/index.php?app=my_datapacket';

   		}



    });

	<?php endif; ?>

}

</script>

<style>

    .member_no_records {border-top: 0px !important;}

    .table .ware_text {width: 155px;}

</style>

<div class="content">

    <div class="totline"></div>

    <div class="botline"></div>

    <?php echo $this->fetch('member.menu.html'); ?>

    <div id="right">

        <?php echo $this->fetch('member.curlocal.html'); ?>

        <?php echo $this->fetch('member.submenu.html'); ?>

        <div class="wrap">

            <div class="public_select table">

                <table id="my_goods" server="<?php echo $this->_var['site_url']; ?>/index.php?app=my_goods&amp;act=ajax_col" >

                    <tr class="line_bold">

                        <th colspan="12">

                    <div class="select_div clearfix">

                        <form id="truncate_form" method="post">

                        </form>



                        <form id="my_goods_form" method="get" class="fleft">

                            <input type="hidden" name="app" value="my_goods">

                            <select class="select1" name='sgcate_id'>

                                <option value="0">本店分类</option>

                                <?php echo $this->html_options(array('options'=>$this->_var['sgcategories'],'selected'=>$_GET['sgcate_id'])); ?>

                            </select>

                            <select class="select2" name="character">

                                <option value="0">状态</option>

                                <?php echo $this->html_options(array('options'=>$this->_var['lang']['character_array'],'selected'=>$_GET['character'])); ?>

                            </select>

                            <input type="text" class="text_normal" name="keyword" value="<?php echo htmlspecialchars($_GET['keyword']); ?>"/>

                            <input type="submit" class="btn" value="搜索" />

                        </form>

                        <a id="truncate" class="detlink" href="javascript:;">清空结果</a>

                        <?php if ($this->_var['filtered']): ?>

                        <a class="detlink" href="<?php echo url('app=my_goods'); ?>">取消检索</a>

                        <?php endif; ?>

                    </div>

                    </th>

                    </tr>

                    <tr class="sep-row" height="20"><td colspan="8"></td></tr>

                    <?php if ($this->_var['goods_list']): ?>

                    <tr class="gray"  ectype="table_header">

                        <th width="60"></th>

                        <?php if ($this->_var['store']['enable_radar']): ?>

                        <th width="50">商品雷达</th>

                        <?php endif; ?>

                        <th width="110" coltype="editable" column="goods_name" checker="check_required" inputwidth="90%" title="排序"  class="cursor_pointer"><span ectype="order_by">商品名称</span></th>

                        <th width="90" column="cate_id" title="排序"  class="cursor_pointer"><span ectype="order_by">商品分类</span></th>

                        <th width="50" coltype="editable" column="brand" checker="check_required" inputwidth="55px" title="排序"  class="cursor_pointer"><span ectype="order_by">品牌</span></th>

                        <th width="50" class="cursor_pointer" coltype="editable" column="gh_price" checker="check_number" inputwidth="50px" title="排序"><span ectype="order_by">供货价</span></th>
 
                        <th width="50" class="cursor_pointer" coltype="editable" column="price" checker="check_number" inputwidth="50px" title="排序"><span ectype="order_by">价格</span></th>

                        <th width="50" class="cursor_pointer" coltype="editable" column="stock" checker="check_pint" inputwidth="50px" title="排序"><span ectype="order_by">库存</span></th>

                        <th width="40" coltype="switchable" column="if_show" onclass="right_ico" offclass="wrong_ico" title="排序"  class="cursor_pointer"><span ectype="order_by">上架</span></th>

                        <th width="40" coltype="switchable" column="recommended" onclass="right_ico" offclass="wrong_ico" title="排序"  class="cursor_pointer"><span ectype="order_by">推荐</span></th>

                        <th width="40" column="closed" title="排序" class="cursor_pointer"><span ectype="order_by">禁售</span></th>

                        <th width="218">操作</th>

                    </tr>

                    <tr class="sep-row"><td colspan="12"></td></tr>

                    <tr class="operations">

                        <th colspan="12">

                    <p class="position1 clearfix">

                        <input type="checkbox" id="all" class="checkall"/>

                        <label for="all">全选</label>

                        <a href="javascript:void(0);" class="edit" ectype="batchbutton" uri="index.php?app=my_goods&act=batch_edit" name="id">编辑</a>

                        <a href="javascript:void(0);" class="edit" ectype="batchbutton" uri="index.php?app=my_goods&amp;act=recommend&ret_page=<?php echo $this->_var['page_info']['curr_page']; ?>" name="id">推荐</a>

                        <a href="javascript:void(0);" class="delete" ectype="batchbutton" uri="index.php?app=my_goods&act=drop" name="id" presubmit="confirm('您确定要删除它吗？')">删除</a>

                    </p>

                    <p class="position2 clearfix">

                        <?php echo $this->fetch('member.page.top.html'); ?>

                    </p>

                    </th>

                    </tr>

                    <?php endif; ?>

                    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['_goods_f'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['_goods_f']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['_goods_f']['iteration']++;
?>

                    <tr class="sep-row"><td colspan="12"></td></tr>

                    <tr class="line-hd">

                    	<th colspan="12">

                        	<p><input type="checkbox" class="checkitem" value="<?php echo $this->_var['goods']['goods_id']; ?>"/><label>商家编码</label><?php echo $this->_var['goods']['specs']['0']['sku']; ?></p>

                        </th>

                    </tr>

                    <tr class="line line-blue<?php if (($this->_foreach['_goods_f']['iteration'] == $this->_foreach['_goods_f']['total'])): ?> last_line<?php endif; ?>" ectype="table_item" idvalue="<?php echo $this->_var['goods']['goods_id']; ?>">

                        <td width="60" class="align2 first"><a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>" target="_blank"><img src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['goods']['default_image']; ?>" width="50" height="50" /></a>

                        </td>

                        <?php if ($this->_var['store']['enable_radar']): ?>

                        <td width="50"  align="center"><span id="r<?php echo $this->_var['goods']['goods_id']; ?>" class="radar_product_point" radar_price="<?php echo $this->_var['goods']['price']; ?>" radar_product_id='<?php echo $this->_var['goods']['goods_id']; ?>' radar_brand="<?php echo $this->_var['goods']['brand']; ?>"  radar_catname="<?php echo $this->_var['goods']['cat_name']; ?>" radar_sn="<?php echo $this->_var['goods']['goods_sn']; ?>" radar_keyword="" radar_name="<?php echo $this->_var['goods']['goods_name']; ?>"></span></td>

                        <?php endif; ?>

                        <td width="110" class="align1">

                            <p class="ware_text"><span class="color2" ectype="editobj"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></span></p>

                        </td>

                        <td width="90" class="align2"><span class="color2"><?php echo nl2br($this->_var['goods']['cate_name']); ?></span></td>

                        <td width="60" class="align2"><span class="color2" ectype="editobj"><?php echo htmlspecialchars($this->_var['goods']['brand']); ?></span></td>

                        <td width="60" class="align2"><?php if ($this->_var['goods']['spec_qty']): ?><span ectype="dialog" dialog_width="430" uri="index.php?app=my_goods&amp;act=spec_edit&amp;id=<?php echo $this->_var['goods']['goods_id']; ?>" dialog_title="编辑价格和库存" dialog_id="my_goods_spec_edit" class="cursor_pointer"><?php else: ?><span class="color2" ectype="editobj"><?php endif; ?><?php echo $this->_var['goods']['gh_price']; ?></span></td>

                        <td width="60" class="align2"><?php if ($this->_var['goods']['spec_qty']): ?><span ectype="dialog" dialog_width="430" uri="index.php?app=my_goods&amp;act=spec_edit&amp;id=<?php echo $this->_var['goods']['goods_id']; ?>" dialog_title="编辑价格和库存" dialog_id="my_goods_spec_edit" class="cursor_pointer"><?php else: ?><span class="color2" ectype="editobj"><?php endif; ?><?php echo $this->_var['goods']['price']; ?></span></td>

                        <td width="60" class="align2"><?php if ($this->_var['goods']['spec_qty']): ?><span ectype="dialog" dialog_width="430" uri="index.php?app=my_goods&amp;act=spec_edit&amp;id=<?php echo $this->_var['goods']['goods_id']; ?>" dialog_title="编辑价格和库存" dialog_id="my_goods_spec_edit" class="cursor_pointer"><?php else: ?><span class="color2" ectype="editobj"><?php endif; ?><?php echo $this->_var['goods']['stock']; ?></span></td>

                        <td width="40" class="align2">

                       

                       <?php if ($this->_var['goods']['is_pass'] == 1): ?> 

                        <span style="margin-left:15px;" ectype="editobj" <?php if ($this->_var['goods']['if_show']): ?>class="right_ico" status="on"<?php else: ?>class="wrong_ico" stauts="off"<?php endif; ?>></span>  

                      

                      

                        <?php endif; ?>

                        

                        

                             <?php if ($this->_var['goods']['is_pass'] == 2): ?>

                            <a href="index.php?app=my_goods&act=out&goods_id=<?php echo $this->_var['goods']['goods_id']; ?>">拒绝</a> 

                             

                             <?php endif; ?> 

                        

                          </td>

                        <td width="40" class="align2"><span style="margin-left:15px;" ectype="editobj" <?php if ($this->_var['goods']['recommended']): ?>class="right_ico" status="on"<?php else: ?>class="wrong_ico" stauts="off"<?php endif; ?>></span></td>

                        <td width="40" class="align2"><span style="margin-left:15px;" <?php if ($this->_var['goods']['closed']): ?>class="no_ico"<?php else: ?>class="no_ico_disable"<?php endif; ?>></span></td>

                        <td width="218" class="last">

                        	<!--<a href="javascirpt:;" ectype="dialog" dialog_id="export_ubbcode" dialog_title="导出UBB" dialog_width="380" uri="<?php echo url('app=my_goods&act=export_ubbcode&id=' . $this->_var['goods']['goods_id']. ''); ?>" class="export">导出UBB</a>-->

                        	<a href="<?php echo url('app=my_goods&act=edit&id=' . $this->_var['goods']['goods_id']. ''); ?>" class="edit">编辑</a>

							<a href="javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=my_goods&amp;act=drop&id=<?php echo $this->_var['goods']['goods_id']; ?>');" class="delete">删除</a>

							<!--<a  href="javascript:add_datapacket(<?php echo $this->_var['goods']['goods_id']; ?>);"    class="set_up">加入数据包</a>	-->						

							<?php if ($this->_var['store_info']['is_open_shua']): ?>	

							<a href="javascirpt:;" ectype="dialog" dialog_id="add_virtual_sell" dialog_width="500" uri="<?php echo url('app=goods_virtual_sell&goods_id=' . $this->_var['goods']['goods_id']. ''); ?>" class="set_up">添加销售记录</a>

                            <?php endif; ?>

                        </td>

                    </tr>

                    <?php endforeach; else: ?>

                    <tr>

                        <td class="align2 member_no_records padding6" colspan="12"><?php echo $this->_var['lang'][$_GET['act']]; ?>没有符合条件的商品</td>

                    </tr>

                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>

                    <?php if ($this->_var['goods_list']): ?>

                    <tr class="sep-row">

                        <td colspan="12"></td>

                    </tr>

                    <tr class="operations">

                        <th colspan="12">

                    <p class="position1 clearfix">

                        <input type="checkbox" id="all" class="checkall"/>

                        <label for="all">全选</label>

                        <a href="javascript:void(0);" class="edit" ectype="batchbutton" uri="index.php?app=my_goods&act=batch_edit" name="id">编辑</a>

                        <a href="javascript:void(0);" class="edit" ectype="batchbutton" uri="index.php?app=my_goods&amp;act=recommend&ret_page=<?php echo $this->_var['page_info']['curr_page']; ?>" name="id">推荐</a>

                        <a href="javascript:void(0);" class="delete" ectype="batchbutton" uri="index.php?app=my_goods&act=drop" name="id" presubmit="confirm('您确定要删除它吗？')">删除</a>

                    </p>

                    <p class="position2 clearfix">

                        <?php echo $this->fetch('member.page.bottom.html'); ?>

                    </p>

                    </th>

                    </tr>

                    <?php endif; ?>

                </table>

            </div>

        </div>

        <div class="clear"></div>

    </div>

    <div class="clear"></div>

</div>





<iframe name="iframe_post" id="iframe_post" width="0" height="0"></iframe>

<?php echo $this->fetch('footer.html'); ?>

<?php if ($this->_var['store']['enable_radar']): ?>

<input type="hidden" id="radar_lincense_id" value="" />

<input type="hidden" id="radar_product_key" value="ecmall" />

<input type="hidden" id="radar_sign_key" value="" />

<script type="text/javascript" src="http://js.sradar.cn/radarForGoodsList.js"></script>

<script>

    radar_point_extract();

</script>

<?php endif; ?>