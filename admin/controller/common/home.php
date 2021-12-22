<?php   
class ControllerCommonHome extends Controller {   
	public function index() {
    	$this->load->language('common/home'); 
		$this->document->title = $this->language->get('heading_title'); 
                $this->data['heading_title'] = $this->language->get('heading_title'); 
		$this->data['text_overview'] = $this->language->get('text_overview');
		
		
    	/*foreach ($results as $result) {
			$action = array(); 
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => HTTPS_SERVER . 'index.php?route=sale/order/update&order_id=' . $result['order_id']
			); 
			$this->data['orders'][] = array(
				'order_id'   => $result['order_id'],
				'name'       => $result['name'],
				'status'     => $result['status'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'total'      => $this->currency->format($result['total'], $result['currency'], $result['value']),
				'action'     => $action
			);
		} */
		if ($this->config->get('config_currency_auto')) {
			$this->load->model('localisation/currency'); 
			$this->model_localisation_currency->updateCurrencies();
		} 
		$this->template = 'common/home.tpl';
		$this->children = array(
			'common/header',	
			'common/footer',
			'common/leftcol'
		); 
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
  	}
	
	public function chart() {
		$this->load->language('common/home'); 
		$data = array(); 
		$data['order'] = array();
		$data['siteusers'] = array();
		$data['xaxis'] = array(); 
		$data['order']['label'] = $this->language->get('text_order');
		$data['siteusers']['label'] = $this->language->get('text_siteusers'); 
		/*if (isset($this->request->get['range'])) {
			$range = $this->request->get['range'];
		} else {
			$range = 'month';
		} 
		switch ($range) {
			case 'day':
				for ($i = 0; $i < 24; $i++) {
					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0' AND (DATE(date_added) = DATE(NOW()) AND HOUR(date_added) = '" . (int)$i . "') GROUP BY HOUR(date_added) ORDER BY date_added ASC"); 
					if ($query->num_rows) {
						$data['order']['data['su_id']][]  = array($i, (int)$query->row['total']);
					} else {
						$data['order']['data['su_id']][]  = array($i, 0);
					} 
					$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "siteusers WHERE DATE(date_added) = DATE(NOW()) AND HOUR(date_added) = '" . (int)$i . "' GROUP BY HOUR(date_added) ORDER BY date_added ASC"); 
					if ($query->num_rows) {
						$data['siteusers']['data['su_id']][] = array($i, (int)$query->row['total']);
					} else {
						$data['siteusers']['data['su_id']][] = array($i, 0);
					} 
					$data['xaxis'][] = array($i, date('H', mktime($i, 0, 0, date('n'), date('j'), date('Y'))));
				}					
				break;
			case 'week':
				$date_start = strtotime('-' . date('w') . ' days');  
				for ($i = 0; $i < 7; $i++) {
					$date = date('Y-m-d', $date_start + ($i * 86400)); 
					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0' AND DATE(date_added) = '" . $this->db->escape($date) . "' GROUP BY DATE(date_added)");
			
					if ($query->num_rows) {
						$data['order']['data['su_id']][] = array($i, (int)$query->row['total']);
					} else {
						$data['order']['data['su_id']][] = array($i, 0);
					}
				
					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "siteusers` WHERE DATE(date_added) = '" . $this->db->escape($date) . "' GROUP BY DATE(date_added)");
			
					if ($query->num_rows) {
						$data['siteusers']['data['su_id']][] = array($i, (int)$query->row['total']);
					} else {
						$data['siteusers']['data['su_id']][] = array($i, 0);
					}
		
					$data['xaxis'][] = array($i, date('D', strtotime($date)));
				}
				
				break;
			default:
			case 'month':
				for ($i = 1; $i <= date('t'); $i++) {
					$date = date('Y') . '-' . date('m') . '-' . $i;
					
					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0' AND (DATE(date_added) = '" . $this->db->escape($date) . "') GROUP BY DAY(date_added)");
					
					if ($query->num_rows) {
						$data['order']['data['su_id']][] = array($i, (int)$query->row['total']);
					} else {
						$data['order']['data['su_id']][] = array($i, 0);
					}	
				
					$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "siteusers WHERE DATE(date_added) = '" . $this->db->escape($date) . "' GROUP BY DAY(date_added)");
			
					if ($query->num_rows) {
						$data['siteusers']['data['su_id']][] = array($i, (int)$query->row['total']);
					} else {
						$data['siteusers']['data['su_id']][] = array($i, 0);
					}	
					
					$data['xaxis'][] = array($i, date('j', strtotime($date)));
				}
				break;
			case 'year':
				for ($i = 1; $i <= 12; $i++) {
					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0' AND YEAR(date_added) = '" . date('Y') . "' AND MONTH(date_added) = '" . $i . "' GROUP BY MONTH(date_added)");
					
					if ($query->num_rows) {
						$data['order']['data['su_id']][] = array($i, (int)$query->row['total']);
					} else {
						$data['order']['data['su_id']][] = array($i, 0);
					}
					
					$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "siteusers WHERE YEAR(date_added) = '" . date('Y') . "' AND MONTH(date_added) = '" . $i . "' GROUP BY MONTH(date_added)");
					
					if ($query->num_rows) { 
						$data['siteusers']['data['su_id']][] = array($i, (int)$query->row['total']);
					} else {
						$data['siteusers']['data['su_id']][] = array($i, 0);
					}
					
					$data['xaxis'][] = array($i, date('M', mktime(0, 0, 0, $i, 1, date('Y'))));
				}			
				break;	
		}*/
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($data));
	}
	
	public function login() {
		if (!$this->user->isLogged()) {
			return $this->forward('common/login');
		}
	}
	
	public function permission() {
		if (isset($this->request->get['route'])) {
			$route = $this->request->get['route'];
		  
			$part = explode('/', $route);
			
			$ignore = array(
				'common/home',
				'common/login',
				'common/logout',
				'common/permission',
				'error/error_403',
				'error/error_404'		
			);
			
			if (!in_array(@$part[0] . '/' . @$part[1], $ignore)) {
                        
				if (!$this->user->hasPermission('access', @$part[0] . '/' . @$part[1])) {
					return $this->forward('error/permission');
				}
			}
		}
	}
}
?>