<?php
class ModelFaqsFaqs extends Model {
	public function addFaqs($data) { 
		$this->db->query("INSERT INTO " . DB_PREFIX . "faqs SET sort_order = '" . (int)$this->request->post['sort_order'] . "', status = '" . (int)$data['fc_status'] . "', category_id='".(int)$data['fc_faq_id']."',seo_keywords='".$data['keyword']."', date_added=NOW(), date_modified = NOW()"); 
		$faq_id = $this->db->getLastId();  
		foreach ($data['faq_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "faq_description SET faq_id = '" . (int)$faq_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['title']) . "'");
		}
		/*if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'faq_id=" . (int)$faq_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}*/
		$this->cache->delete('faqs');
                return $faq_id;
	}
	public function addQuestionFaqs($data){
            foreach ($data['faq_description'] as $language_id => $value) {
             $question = $this->db->escape($value['question']);
             $answer = $this->db->escape($value['answer']);
            }
            $sql ="INSERT INTO " . DB_PREFIX . "faq_questions SET parent_id = '".(int)$this->request->get['pid'] ."',question = '".$question."',answer='".$answer."',q_sort = '" . (int)$this->request->post['sort_order'] . "',
                   q_status = '" . (int)$data['fc_status'] . "', q_seo='".$data['keyword']."', date_added=NOW(),date_modified=NOW()" ;
            $this->db->query($sql);
        }
	public function editFaqs($faq_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "faqs SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['fc_status'] . "', category_id='".(int)$data['fc_faq_id']."',seo_keywords='".$data['keyword']."' WHERE faq_id = '" . (int)$faq_id . "'"); 
		$this->db->query("DELETE FROM " . DB_PREFIX . "faq_description WHERE faq_id = '" . (int)$faq_id . "'"); 
		foreach ($data['faq_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "faq_description SET faq_id = '" . (int)$faq_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['title']) . "'");
		} 
		/*if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'faq_id=" . (int)$faq_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}*/
		$this->cache->delete('faqs');
	} 
        public function editQuestion($faq_id , $qid,$data) {
                 foreach ($data['faq_description'] as $language_id => $value) {
                 $question = $this->db->escape($value['question']);
                 $answer = $this->db->escape($value['answer']);
                }
		$this->db->query("UPDATE " . DB_PREFIX . "faq_questions SET question='".$question."',answer='".$answer."', q_sort = '" . (int)$data['sort_order'] . "', q_status = '" . (int)$data['fc_status'] . "',q_seo='".$data['keyword']."' WHERE parent_id = '" . (int)$faq_id . "' AND q_id='".$qid."'"); 
		
		$this->cache->delete('faq_questions');
	} 
	public function deleteFaqs($faq_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "faqs WHERE faq_id = '" . (int)$faq_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "faq_description WHERE faq_id = '" . (int)$faq_id . "'");
                $this->db->query("DELETE FROM " . DB_PREFIX . "faq_questions WHERE parent_id = '" . (int)$faq_id . "'");    
		$this->cache->delete('faqs');
	}	 
        public function deleteQuestions($q_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "faq_questions WHERE q_id = '" . (int)$q_id . "'");    
                echo 'here';
		$this->cache->delete('faqs');
	}	 
	public function getFaqs($faq_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'faq_id=" . (int)$faq_id . "') AS keyword FROM " . DB_PREFIX . "faqs WHERE faq_id = '" . (int)$faq_id . "'"); 
		return $query->row;
	}
        public function getQuestion($faq_id,$qid) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "faq_questions WHERE parent_id = '" . (int)$faq_id . "' AND q_id='".$qid."'"); 
		return $query->row;
	}
		
	public function getFaqsp($data) {
		
                $faqs_data = $this->cache->get('faqs.' . $this->config->get('config_language_id')); 
                if (!$faqs_data) {
                        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "faqs c LEFT JOIN " . DB_PREFIX . "faq_description cd ON (c.faq_id = cd.faq_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY sort_order "); 
                        $faqs_data = $query->rows; 
                        $this->cache->set('faqs.' . $this->config->get('config_language_id'), $faqs_data);
                }	 
                return $faqs_data;			
		
	}
        public function getQuestionsp($data,$id) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "faq_questions  where parent_id ='".$id."' ORDER BY q_sort"); 
            $faqs_data = $query->rows; 
            return $faqs_data;			
		
	}
	
	public function getFaqsDescriptions($faq_id) {
		$faqs_description_data = array(); 
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "faq_description WHERE faq_id = '" . (int)$faq_id . "'"); 
		foreach ($query->rows as $result) {
			$faqs_description_data[$result['language_id']] = array(
				'title'       => $result['name'],
				'description' => $result['description']
			);
		} 
		return $faqs_description_data;
	}

	public function getTotalFaqs() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "faqs"); 
		return $query->row['total'];
	}
        public function getTotalQuestions($faq_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "faq_questions WHERE parent_id='".$faq_id."'"); 
		return $query->row['total'];
	}
        public function getAlltopics(){
            $sql = "SELECT * FROM " . DB_PREFIX . "faqs c LEFT JOIN " . DB_PREFIX . "faq_description cd ON (c.faq_id = cd.faq_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.date_added"; 
            $query = $this->db->query($sql);
            return $query->rows;
        }
	
}

?>