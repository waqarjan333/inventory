<?php
class ModelLoginForgetpassword extends Model {  
       public function checkUserName($data){
        $sql = "SELECT * FROM " . DB_PREFIX . "siteusers WHERE username = '".$data['username']."' AND user_type='2'";
        $query = $this->db->query($sql);
            if($query->num_rows>0){
                return array('id' => $query->row['su_id'], 'username' => $query->row['username']);
            }
        }
        
        public function adminQuestions($id){
        $sql = "SELECT q.question as question, a.answer as answer FROM " . DB_PREFIX . "security_question q "
                . "LEFT JOIN " . DB_PREFIX . "answer a ON ( a.question_id = q.id )
                    WHERE  a.user_id='".$id."'";
        $query = $this->db->query($sql);
            if($query->num_rows>0){
                    return $query->rows;
            }
        }
        
        public function updatePass($data) {
        $password = "";
        //$data =array();
        if(isset($data['pass']) && !empty($data['pass'])){
            $password = "password = '" . $this->db->escape(md5($data['pass'])) . "',";
        }
        $query = $this->db->query("UPDATE " . DB_PREFIX . "siteusers SET 
                    ".$password." update_pass = '1'
                    WHERE su_id= '" . $data["user_hidden_id"] . "'
                    ");
        return array('id' => $data["user_hidden_id"], 'type' => '2');
    }
        
       
}
?>