<?php  
class ControllerCommonHome extends Controller {
	private $error = array(); 
  	public function index() { 
                $this->language->load('common/home'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('common/common'); 
		$this->load->model('tool/image');
		$this->data['clogged'] = $this->siteusers->isLogged();
		$this->data['currency'] = $this->config->get('config_currency'); 
		
                $this->data['text_wedo'] = $this->language->get('text_wedo'); 
                $this->data['text_wedo_describe'] = $this->language->get('text_wedo_describe'); 
                $this->data['text_readmore'] = $this->language->get('text_readmore');  
		$usertype= $this->siteusers->getUserType(); 
		$this->data['user_type'] = $usertype;
		$categorygotourl=HTTP_SERVER . "index.php?route=service/services/jobs";
		if($usertype==1){ 
			$this->data['industry_url'] = $this->seourls->rewrite(HTTP_SERVER . 'index.php?route=service/services/providers');
			$categorygotourl=HTTP_SERVER . "index.php?route=service/services/searchProviders"; 
		} else {
			$this->data['industry_url'] = $this->seourls->rewrite(HTTP_SERVER . 'index.php?route=service/services/jobs');
			$categorygotourl=HTTP_SERVER . "index.php?route=service/services/searchProjects"; 
		} 
		$this->data['popindustries'] =array();
		$querypop=$this->model_common_common->getHomeIndustries();  
                foreach ($querypop as $result) {
			$this->data['popindustries'][] = array(
				"category_id" 	=> $result['category_id'],
				"title" 		=> $result['name'],
				"count"         => $this->model_common_common->getTotalIndpost($result['category_id'],'1'),
				"linkto"		=> $this->seourls->rewrite($categorygotourl. "&cid=".$result['category_id']),
				"sort_order" 	=> $result['sort_order'] 
			);
		} 
		if (isset($this->session->data['error']) and !empty($this->session->data['error'])) {
			foreach($this->session->data['error'] as $key=>$value) {
				$this->data[$key] = $value;
			}
			unset($this->session->data['error']);
		} 
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/home.tpl';
		} else {
			$this->template = 'default/template/template/common/home.tpl';
		}  
		$this->children = array(
			'common/header',
                        'common/column_left',
			'common/footer'
                        
		); 
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
  	} 
}
?>