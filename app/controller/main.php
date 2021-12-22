<?php
class ControllerMain extends Controller {
	public function index() {
		
	}

	public function seekers(){
           $usertype= $this->siteusers->getUserType();  
           if($usertype==1){
                $this->redirect(HTTPS_SERVER . 'index.php?route=dashboard/seekers'); 
           }
           else{
               $this->redirect(HTTPS_SERVER . 'index.php?route=seekers/howitworks'); 
               
           }
        }
        public function providers(){
            $usertype= $this->siteusers->getUserType();  
           if($usertype==2){
                $this->redirect(HTTPS_SERVER . 'index.php?route=dashboard/providers'); 
           }
           else{
               $this->redirect(HTTPS_SERVER . 'index.php?route=providers/howitworks'); 
           }
        }
        public function industry_board(){
            $this->redirect(HTTPS_SERVER . 'index.php?route=service/services/providers'); 
        }
        public function resource(){
            $this->redirect(HTTPS_SERVER . 'index.php?route=resource/news'); 
        }
}
?>
