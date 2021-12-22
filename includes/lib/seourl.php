<?php
final class Seourl { 
	private $otherurls;
  	public function __construct($registry) {
		$this->config = $registry->get('config'); 
		$this->session = $registry->get('session'); 
		$this->request = $registry->get('request');
		$this->db = $registry->get('db'); 
		$this->otherurls=$this->getSEOurls();
	}
	public function cleanurl() {
                if (isset($this->request->get['_route_'])) {
                    
			$parts = explode('/', $this->request->get['_route_']);
			foreach ($parts as $part) {
                                //$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($part) . "'"); 
				if (0) {
					$url = explode('=', $query->row['query']);  
					if ($url[0] == 'cms_id') {
						$this->request->get['cms_id'] = $url[1];
					}
					if ($url[0] == 'pop_id') {
						$this->request->get['pop_id'] = $url[1];
					}
					if ($url[0] == 'id') {
						$this->request->get['id'] = $url[1];
					} 
				} else {
					$marry=$this->otherurls;
                                        
					$marry=array_flip($marry);
					if(array_key_exists($part,$marry)) { 
						$this->request->get['route'] = $marry[$part]; 
                                                
					} 
				}
			} 
			if (isset($this->request->get['pop_id'])) {
				$this->request->get['route'] = 'cms/cms/loadInfo'; 
			} elseif (isset($this->request->get['cms_id'])) {
				$this->request->get['route'] = 'cms/cms';
			}
                        
			if (isset($this->request->get['route'])) {
                            
                            return new Action($this->request->get['route'], array());  // fixe for the the seo urls
                            //return $this->forward($this->request->get['route']);
			}
		}
	}
	public function rewrite($link) {
		if ($this->config->get('config_seo_url')) {
                        
			$url_data = parse_url(str_replace('&amp;', '&', $link));  
			$url = '';  
			$data = array(); 
			parse_str($url_data['query'], $data); 
			foreach ($data as $key => $value) {
				if (($key == 'pop_id') || ($key == 'cs_id') || ($key == 'cms_id')) {
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "'"); 
					if ($query->num_rows) {
						$url .= '/' . $query->row['keyword']; 
						unset($data[$key]);
					}	 
				} elseif ($key == 'route') {   
						if(array_key_exists($value,$this->otherurls)) {
							$url .= '/' . $this->otherurls[$value];
							unset($data[$key]);
						} 
				}
			} 
			if ($url) {
				unset($data['route']); 
				$query = ''; 
				if ($data) {
					foreach ($data as $key => $value) {
						$query .= '&' . $key . '=' . $value;
					} 
					if ($query) {
						$query = '?' . trim($query, '&');
					}
				} 
				return $url_data['scheme'] . '://' . $url_data['host'] . (isset($url_data['port']) ? ':' . $url_data['port'] : '') . str_replace('/index.php', '', $url_data['path']) . $url . $query;
			} else {
				return $link;
			}
		} else {
			return $link;
		}		
	} 
	private function getSEOurls(){
		 $arrs=array(
			'common/home' => 'home',
			'dashboard/login' => 'login',
                        'dashboard/logout' => 'logout'
		  );
		  $sql="SELECT * FROM " . DB_PREFIX . "seo_url";
		  $query = $this->db->query($sql); 
		  foreach ($query->rows as $result) {
			$arrs[$result['mainurl']]=$result['seourl'];
		  }  
		  return $arrs;
	}
}
?>