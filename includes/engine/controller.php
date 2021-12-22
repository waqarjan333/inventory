<?php
abstract class Controller {
	protected $registry;	
	protected $id;
	protected $template;
	protected $children = array();
	protected $data = array();
	protected $output;
	
	public function __construct($registry) {
		$this->registry = $registry;
	}
	
	public function __get($key) {
		return $this->registry->get($key);
	}
	
	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}
			
	protected function forward($route, $args = array()) {
		return new Action($route, $args);
	}

	protected function redirect($url) {
		header('Location: ' . str_replace('&amp;', '&', $url));
		exit();
	}
	
	protected function render($return = FALSE) {
		foreach ($this->children as $child) {
			$action = new Action($child);
			$file   = $action->getFile();
			$class  = $action->getClass();
			$method = $action->getMethod();
			$args   = $action->getArgs();
		
			if (file_exists($file)) {
				require_once($file);
                                
				$controller = new $class($this->registry);
				
				$controller->index();
				
				$this->data[$controller->id] = $controller->output;
			} else {
				exit('Error: Could not load controller ' . $child . '!');
			}
		}
                
		$this->setDataGlobally();
                
		if ($return) {
                        
			return $this->fetch($this->template);
		} else {
			$this->output = $this->fetch($this->template);
		}
	}
	
	protected function fetch($filename) {
		$file = DIR_TEMPLATE . $filename;
                
		if (file_exists($file)) {
			extract($this->data);
			
      		ob_start();
      
	  		require($file);
      
	  		$content = ob_get_contents();

      		ob_end_clean();

      		return $content;
    	} else {
      		exit('Error: Could not load template ' . $file . '!');
    	}
	}
        
        protected function setDataGlobally(){   
            //This will set the data globally for the pages.
            
            $this->data['theme'] = $this->themes;
            
       
        }
	protected function renderPDF($vcod='') { 
        require_once(DIR_INC.'lib/tcpdf/config/lang/eng.php');
        require_once(DIR_INC.'lib/tcpdf/tcpdf.php');  
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('0ne24deal');
		$pdf->SetTitle('One24 deal Coupon');
		$pdf->SetSubject('One24 deal Coupon');
		$pdf->SetKeywords('One24 deal, Coupon'); 
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		// set default header data
		//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE."                     voucher code:".$vcod , PDF_HEADER_STRING); 
		// set header and footer fonts
		//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA)); 
		// set default monospaced font
		//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); 
		//set margins
		//$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
		$pdf->SetMargins(10, 5, 10,true);
		//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER); 
		//set auto page breaks
		$pdf->SetAutoPageBreak(false, 0); 
		//set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
		//set some language-dependent strings
		$pdf->setLanguageArray($l); 
		// --------------------------------------------------------- 
		// set font
		$pdf->SetFont('helvetica', '', 10); 
		// add a page
		$pdf->AddPage(); 
		/* NOTE:
		 * *********************************************************
		 * You can load external XHTML using :
		 *
		 * $html = file_get_contents('/path/to/your/file.html');
		 *
		 * External CSS files will be automatically loaded.
		 * Sometimes you need to fix the path of the external CSS.
		 * *********************************************************
		 */ 
		// define some HTML content with style
		$tablecontent = $this->fetch($this->template); 
		//print $tablecontent;
		// output the HTML content
		$pdf->writeHTML($tablecontent, true, false, true, false, ''); 
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
		// reset pointer to the last page
		$pdf->lastPage(); 
		// --------------------------------------------------------- 
		//Close and output PDF document
		ob_end_clean();
		$this->output =  $pdf->Output('DijeecomVoucher-'.$vcod.'.pdf', 'I'); 
	}
	
	
}
?>