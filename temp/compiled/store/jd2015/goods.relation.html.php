<script>
    $(function() {
        $("input:checkbox[name='goods_mix_id']").change(function() {
            var goods_mix_ids = get_goods_mix_id();
            var url = SITE_URL + '/index.php?app=cart&act=max_goods_cart';
            $.getJSON(url, {'goods_mix_ids': goods_mix_ids}, function(data) {
                if (data.done) {
                    $("#max_goods_total_price").html(data.retval.total_price);
                    $("#max_goods_total_count").html(data.retval.total_count);
                }
                else {
                    alert(data.msg);
                }
            });
        });
        $("ul[ectype='ul_stab'] li").click(function() {
            var stab_id = this.id;
        $(".stab li").each(function() {
            $(this).removeClass("scurr");
        });
        $(this).addClass("scurr");
            if (stab_id == 0) {
                $(".suits li").show();
            } else {
                $(".suits li").each(function() {
                    if(this.id=='mix_item_'+stab_id){
                        $(this).show();
                    }else{
                        $(this).hide();
                    }
                });
            }

        });
    });

    function add_goods_mix()
    {
        var store_id = <?php echo $this->_var['goods']['store_id']; ?>;
        var url = SITE_URL + '/index.php?app=cart&act=max_goods_add';
        var goods_mix_ids = get_goods_mix_id();
        $.getJSON(url, {'goods_mix_ids': goods_mix_ids}, function(data) {
            if (data.done) {
                location.assign(SITE_URL + '/index.php?app=order&goods=cart&store_id=' + store_id);
            }
            else {
                alert(data.msg);
            }
        });
    }

    /**
     * 获取点击事件
     */
    function get_goods_mix_id()
    {
        var goods_mix_ids = "";
        $("input:checkbox[name='goods_mix_id']:checked'").each(function(i) {
            if (0 == i) {
                goods_mix_ids = $(this).val();
            } else {
                goods_mix_ids += ("," + $(this).val());
            }
        });
        return goods_mix_ids;
    }
</script>

<?php if ($this->_var['mix_list']): ?>
<div class="goods_relation clearfix w">
    <div class="mt clearfix">
        <ul class="tab">
            <li class="curr" ><a href="javascript:void(0)">推荐搭配</a></li>
            <!--
            <li><a href="javascript:void(0)">推荐配件</a></li>
            -->
        </ul>
    </div>
    <div class="mc clearfix">
        <div class="fitting-content">
            <ul class="stab"  ectype="ul_stab">
                <li id="0" class="scurr">全部推荐</li>
                <?php $_from = $this->_var['mix_cates']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'mix_cate');$this->_foreach['fe_mix_cate'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_mix_cate']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['mix_cate']):
        $this->_foreach['fe_mix_cate']['iteration']++;
?>
                <li id="<?php echo $this->_var['key']; ?>"><?php echo $this->_var['mix_cate']; ?></li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
            <div class="stabcon clearfix">
                <div class="master">
                    <s></s>
                    <div class="p-img">
                        <a href="javascript:void(0)" target="_blank">
                            <img width="100" height="100" src="<?php echo $this->_var['goods']['default_image']; ?>">
                        </a>
                    </div>
                    <div class="p-name">
                        <a href="javascript:void(0)" target="_blank"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></a>
                    </div>
                    <div class="p-price hide"><input type="checkbox"  name="goods_mix_id" value="<?php echo $this->_var['goods']['default_spec']; ?>" checked="checked"></div>
                </div>
                <div class="suits">
                    <ul>
                        <?php $_from = $this->_var['mix_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'mix_item');$this->_foreach['fe_mix_item'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_mix_item']['total'] > 0):
    foreach ($_from AS $this->_var['mix_item']):
        $this->_foreach['fe_mix_item']['iteration']++;
?>
                        <li id="mix_item_<?php echo $this->_var['mix_item']['cate_id']; ?>">
                        <s></s>
                        <div class="p-img">
                            <a href="<?php echo url('app=goods&id=' . $this->_var['mix_item']['goods_id']. ''); ?>" target="_blank">
                                <img width="100" height="100" src="<?php echo $this->_var['mix_item']['default_image']; ?>">
                            </a>
                        </div>
                        <div class="p-name">
                            <a href="<?php echo url('app=goods&id=' . $this->_var['mix_item']['goods_id']. ''); ?>" target="_blank" ><?php echo htmlspecialchars($this->_var['mix_item']['goods_name']); ?></a>
                        </div>                            
                        <div class="choose">
                            <input type="checkbox" name="goods_mix_id" value="<?php echo $this->_var['mix_item']['default_spec']; ?>" >
                            <label class="p-price"><strong ><?php echo price_format($this->_var['mix_item']['price']); ?></strong></label>
                        </div>
                        </li>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </div>
            </div>

            <div class="infos">
                <s></s>
                <div class="more-fitting-link">
                    <a href="" target="_blank">进入其他商品</a>
                    <span>&gt;<b></b></span>
                </div>
                <div class="p-name">已选择<span id="max_goods_total_count">0</span>个</div>
                <div class="p-price">搭&nbsp;配&nbsp;价：<strong id="max_goods_total_price"><?php echo price_format($this->_var['goods']['price']); ?></strong></div>
                <div class="btns"><a class="btn-buy" href="javascript:add_goods_mix()">立即购买</a></div>
            </div>
        </div>
        <div>

        </div>
    </div>
</div>
<?php endif; ?>

