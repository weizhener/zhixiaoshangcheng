<?php

/**
 *
 * 快递跟踪
 *
 * @return  array
 */
class Kuaidi100Plugin extends BasePlugin
{
	var $_url 	 	= null;
	var $_url_spare = null;
    var $_config 	= array();
	var $_data   	= array();
    
    function __construct($data, $plugin_info)
    {
        $this->Kuaidi100Plugin($data, $plugin_info);
    }
    function Kuaidi100Plugin($data, $plugin_info)
    {
        $this->_config 		= $plugin_info;
		$this->_data   		= $data;
		$this->_url    		= 'http://api.kuaidi100.com/api?id='.$this->_config['AppKey']; // 此接口返回 json，xml格式，自由配置高
		$this->_url_spare   = 'http://www.kuaidi100.com/applyurl?key='.$this->_config['AppKey']; // 此接口返回固定格式的html，并带广告
		
        parent::__construct($data, $plugin_info);
    }
    function execute()
    {
		if (defined('IN_BACKEND') && IN_BACKEND === true){
            return; // 后台无需执行
        }
		
		$data = array();
		
		// 物流公司名称及运单号
		$data['express_num'] = $this->_data['nu'];
		$all_express_company = include_once(ROOT_PATH . '/data/express_company.inc.php');
		if(is_array($all_express_company))
		{
			foreach($all_express_company as $key=>$val){
				if($key==$this->_data['com']){
					$data['express_company'] = $val;
					break;
				}
			}
		}
		
		$url = $this->_url . '&com='.$this->_data['com'].'&nu='.$this->_data['nu'].'&order=asc';
		
		$get_content = ecm_fopen($url);
		$return = json_decode($get_content,true);
		
		/* status 查询的结果状态。0：运单暂无结果，1：查询成功，2：接口出现异常，408：验证码出错（仅适用于APICode url，可忽略) */  
		if($return['status'] == 0 || $return['status'] == 1)
		{
			$data = array_merge($data, $return);
		}
		else
		{
			/* 调用第二个接口，因为上面的接口不支持 EMS、顺丰和申通，返回的是一个url地址 */
			$url = $this->_url_spare . '&com='.$this->_data['com'].'&nu='.$this->_data['nu'];
			$get_content = ecm_fopen($url);
			$return = json_decode($get_content,true);
			if($return['status']==0 || $return['status']==1){
				$data['url'] = $get_content;
			}
			else
			{
				$data = array_merge($data, $return);
			}
		}

		return $data;
	}
}

?>