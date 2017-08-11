
<style>
.page-nav-tab-wrap {position: relative;margin-bottom: 10px;z-index: 2;}
.page-nav-tab {height: 27px;}
.page-nav-tab li {float: left;width: 70px;height: 27px;line-height: 27px;margin-right: 3px;}
.page-nav-tab li .tab-item {display: block;color: #414141;height: 23px;line-height: 23px;margin-top: 2px;padding: 0 10px;border: 1px solid #AED2FF;background: #E8F2FF;border-radius: 3px 3px 0 0;}
.page-nav-tab li.selected .tab-item {position: relative;z-index: 1;height: 25px;line-height: 25px;margin-top: 0;background: white;color: black;font-weight: 700;padding: 0 8px;border-bottom: 1px solid white;}
.page-nav-tab-wrap .page-nav-line {position: relative;display: block;width: 100%;border-bottom: 1px solid #AED2FF;bottom: 1px;height: 0;line-height: 0;}
</style>
<div class="page-nav-tab-wrap">
    <ul class="page-nav-tab J_PageNav">
        <li <?php if ($_GET['act'] == 'index' || ! $_GET['act']): ?>class="selected"<?php endif; ?>><a href="<?php echo url('app=my_statistics'); ?>" class="tab-item">实时数据</a></li>
        <li <?php if ($_GET['act'] == 'page_ranking'): ?>class="selected"<?php endif; ?>><a href="<?php echo url('app=my_statistics&act=page_ranking'); ?>" class="tab-item" >页面排行</a></li>
    </ul>
    <b class="page-nav-line"></b>
</div>
<script>
    function my_statistics_select(obj)
    {
        if(obj.value=="index")
        {
            window.location.href="index.php?app=my_statistics"; 
        }
        else if(obj.value=="page_ranking"){
            window.location.href="index.php?app=my_statistics&act=page_ranking"; 
        }
    }
</script>
<div style="float:right;">
    <select name="select" onchange="my_statistics_select(this)">
        <option value="index" <?php if ($_GET['act'] == 'page_ranking' || ! $_GET['act']): ?>selected<?php endif; ?>>实时数据</option>
        <option value="page_ranking" <?php if ($_GET['act'] == 'page_ranking'): ?>selected<?php endif; ?>>页面排行</option>
    </select>
</div>

