<?php 
class ControllerDashboardLogout extends Controller {
	public function index() {
        if ($this->siteusers->isLogged()) {
      		$this->siteusers->logout();
    		unset($this->session->data['firstname']); 
                
            }
            
            unset($this->session->data['pid']);
            unset($this->session->data['firstname']);
            $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login'));
            
  	}
}
?>
