<?php
class ModelAccountJournalview extends Model {
        public function addInvoice($data) { 
            date_default_timezone_set("Asia/Karachi");
            $date = date('Y-m-d H:i:s');
            $debit_cur_rate = 1;
            $credit_cur_rate = 1;
            $debit_cur_id = '0';
            $credit_cur_id = '0';
            $count = 0;
            
            $id = $this->db->query("SELECT MAX(entry_id) as entry_id FROM " . DB_PREFIX . "journal_invoice");
            $this->db->query("INSERT INTO " . DB_PREFIX . "journal_invoice SET entry_id='".($id->row['entry_id'] + 1)."', inv_date ='".$date."', update_date ='".$date."'");
            $last_id = $this->db->getLastId();
            
            foreach ($data as $item){
                $name_id = $this->db->query("SELECT acc_id as id FROM " . DB_PREFIX . " account_chart WHERE acc_name = '".$item->name."'");
                $this->db->query("INSERT INTO " . DB_PREFIX . "journal_invoice_details SET inv_id='".$last_id."', acc_name='".$item->acc_name."', debit_amount='".$item->debit_amount."', credit_amount='".(-1 * $item->credit_amount)."', memo  = '". $item->memo. "', name_ = '".$name_id->row['id']."'");
                $acc_id = $this->db->query("SELECT acc_id as id FROM " . DB_PREFIX . " account_chart WHERE acc_name = '".$item->acc_name."'");
                $item->acc_name = $acc_id->row['id'];
                if($count == 0){
                    if($item->debit_amount){
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$item->acc_name."', journal_amount='".(1 * $item->debit_amount)."', journal_details  = '" . $item->memo . "',inv_id= '".($id->row['entry_id'] + 1)."' ,currency_rate='".$debit_cur_rate."',currency_id='".$debit_cur_id."', entry_date ='".$date."', type = 'Jour_UI' "); 
                        $last = $this->db->getLastId();
                        $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last."' WHERE journal_id='".$last."'");
                        $this->db->query("UPDATE " . DB_PREFIX . "journal_invoice_details SET ref_id='".$last."' WHERE inv_id='".$last_id."'");
                        $count ++;
                    }
                    else if ($item->credit_amount){
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$item->acc_name."', journal_amount='".(-1 * $item->credit_amount)."', journal_details  = '" . $item->memo . "',inv_id= '".($id->row['entry_id'] + 1)."' ,currency_rate='".$debit_cur_rate."',currency_id='".$debit_cur_id."', entry_date ='".$date."', type = 'Jour_UI' "); 
                        $last = $this->db->getLastId();
                        $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last."' WHERE journal_id='".$last."'");
                        $this->db->query("UPDATE " . DB_PREFIX . "journal_invoice_details SET ref_id='".$last."' WHERE inv_id='".$last_id."'");
                        $count ++;
                    }
                }
                else{
                    if($item->debit_amount){
                        echo "hello";
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$item->acc_name."', journal_amount='".(1 * $item->debit_amount)."', journal_details  = '" . $item->memo . "',inv_id= '".($id->row['entry_id'] + 1)."' ,ref_id='".$last."',currency_rate='".$credit_cur_rate."',currency_id='".$credit_cur_id."', entry_date ='".$date."', type = 'Jour_UI' ");
                        $this->db->query("UPDATE " . DB_PREFIX . "journal_invoice_details SET ref_id='".$last."' WHERE inv_id='".$last_id."'");
                    }
                    else if ($item->credit_amount){
                        echo "hello";
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$item->acc_name."', journal_amount='".(-1 * $item->credit_amount)."', journal_details  = '" . $item->memo . "',inv_id= '".($id->row['entry_id'] + 1)."' ,ref_id='".$last."',currency_rate='".$credit_cur_rate."',currency_id='".$credit_cur_id."', entry_date ='".$date."', type = 'Jour_UI' ");
                        $this->db->query("UPDATE " . DB_PREFIX . "journal_invoice_details SET ref_id='".$last."' WHERE inv_id='".$last_id."'");
                    }
                }
            }
            return ($last_id);
        }
        
        public function updateInvoice($data, $entry_id){
            date_default_timezone_set("Asia/Karachi");
            $date = date('Y-m-d H:i:s');
            $debit_cur_rate = 1;
            $credit_cur_rate = 1;
            $debit_cur_id = '0';
            $credit_cur_id = '0';
            $count = 0;
            
            $this->db->query("UPDATE " . DB_PREFIX . "journal_invoice SET update_date ='".$date."' WHERE entry_id = '".$entry_id."'");
            $inv_id = $this->db->query ("SELECT inv_id as id FROM " . DB_PREFIX . "journal_invoice WHERE entry_id = '".$entry_id."'");
            $ref_id = $this->db->query ("SELECT ref_id as id FROM " . DB_PREFIX . "journal_invoice_details WHERE inv_id = '".$inv_id->row['id']."'");
            $this->db->query("DELETE FROM " . DB_PREFIX . "account_journal WHERE ref_id = '".$ref_id->row['id']."'");
            $this->db->query("DELETE FROM " . DB_PREFIX . "journal_invoice_details WHERE inv_id = '".$inv_id->row['id']."'");
            foreach ($data as $item){
                $name_id = $this->db->query("SELECT acc_id as id FROM " . DB_PREFIX . " account_chart WHERE acc_name = '".$item->name."'");
                $this->db->query("INSERT INTO  " . DB_PREFIX . "journal_invoice_details SET inv_id = '".$inv_id->row['id']."', acc_name='".$item->acc_name."', debit_amount='".$item->debit_amount."', credit_amount='".(-1 * $item->credit_amount)."', memo  = '". $item->memo. "', name_ = '".$name_id->row['id']."'");
                $acc_id = $this->db->query("SELECT acc_id as id FROM " . DB_PREFIX . " account_chart WHERE acc_name = '".$item->acc_name."'");
                $item->acc_name = $acc_id->row['id'];
                
                if($count == 0){
                    if($item->debit_amount){
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$item->acc_name."', journal_amount='".(1 * $item->debit_amount)."', journal_details  = '" . $item->memo . "',inv_id= '".$entry_id."' ,currency_rate='".$debit_cur_rate."',currency_id='".$debit_cur_id."', entry_date ='".$date."', type = 'Jour_UI' "); 
                        $last = $this->db->getLastId();
                        $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last."' WHERE journal_id='".$last."'");
                        $this->db->query("UPDATE " . DB_PREFIX . "journal_invoice_details SET ref_id='".$last."' WHERE inv_id='".$inv_id->row['id']."'");
                        $count ++;
                    }
                    else if ($item->credit_amount){
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$item->acc_name."', journal_amount='".(-1 * $item->credit_amount)."', journal_details  = '" . $item->memo . "',inv_id= '".$entry_id."' ,currency_rate='".$debit_cur_rate."',currency_id='".$debit_cur_id."', entry_date ='".$date."', type = 'Jour_UI' "); 
                        $last = $this->db->getLastId();
                        $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last."' WHERE journal_id='".$last."'");
                        $this->db->query("UPDATE " . DB_PREFIX . "journal_invoice_details SET ref_id='".$last."' WHERE inv_id='".$inv_id->row['id']."'");
                        $count ++;
                    }
                }
                else {
                    if($item->debit_amount){
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$item->acc_name."', journal_amount='".(1 * $item->debit_amount)."', journal_details  = '" . $item->memo . "',inv_id= '".$entry_id."' ,ref_id='".$last."',currency_rate='".$credit_cur_rate."',currency_id='".$credit_cur_id."', entry_date ='".$date."', type = 'Jour_UI' ");
                        $this->db->query("UPDATE " . DB_PREFIX . "journal_invoice_details SET ref_id='".$last."' WHERE inv_id='".$inv_id->row['id']."'");
                    }
                    else if ($item->credit_amount){
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$item->acc_name."', journal_amount='".(-1 * $item->credit_amount)."', journal_details  = '" . $item->memo . "',inv_id= '".$entry_id."' ,ref_id='".$last."',currency_rate='".$credit_cur_rate."',currency_id='".$credit_cur_id."', entry_date ='".$date."', type = 'Jour_UI' ");
                        $this->db->query("UPDATE " . DB_PREFIX . "journal_invoice_details SET ref_id='".$last."' WHERE inv_id='".$inv_id->row['id']."'");
                    }
                }
            }
            return ($inv_id->row['id']);
        }
        
        public function previousInvoice($previous_id){
            $max_id = $this->db->query("SELECT MAX(entry_id) as max FROM " . DB_PREFIX . "journal_invoice");
            
            if($previous_id == null){
                $query = $this->db->query("SELECT inv_id as id, entry_id as entry_id, inv_date as date FROM " . DB_PREFIX . "journal_invoice WHERE entry_id = '".($max_id->row['max'])."' ");
                
            }
            else{
                $previous_id = $this->db->query("SELECT MAX(entry_id) as previous FROM " . DB_PREFIX . "journal_invoice WHERE entry_id < '".$previous_id."'  ");
                $previous_id = $previous_id->row['previous'];
                $query = $this->db->query("SELECT inv_id as id, entry_id as entry_id, inv_date as date FROM " . DB_PREFIX . "journal_invoice WHERE entry_id = '".$previous_id."'");
            }
            
            return $query->row;
        }
        
        public function nextInvoice($next_id){
            $next_id = $this->db->query("SELECT MIN(entry_id) as next FROM " . DB_PREFIX . "journal_invoice WHERE entry_id > '".$next_id."'  ");
            $next_id = $next_id->row['next'];
            $query = $this->db->query("SELECT inv_id as id, entry_id as entry_id, inv_date as date FROM " . DB_PREFIX . "journal_invoice WHERE entry_id = '".$next_id."'");
            
            return $query->row;
        }
        
        public function thisInvoice($id){
            $query = $this->db->query("SELECT inv_id as id, entry_id as entry_id, inv_date as date FROM " . DB_PREFIX . "journal_invoice WHERE entry_id = '".$id."'");
            
            return $query->row;
        }
        
        public function deleteInvoice($entry_id){
            
            $inv_id = $this->db->query("SELECT inv_id as invoice_id FROM " . DB_PREFIX . "journal_invoice WHERE entry_id = '".$entry_id."' ");
            $ref_id = $this->db->query ("SELECT ref_id as id FROM " . DB_PREFIX . "journal_invoice_details WHERE inv_id = '".$inv_id->row['invoice_id']."'");
            $query = $this->db->query("DELETE FROM " . DB_PREFIX . "account_journal WHERE ref_id = '".$ref_id->row['id']."'");
            $this->db->query("DELETE  FROM " . DB_PREFIX . "journal_invoice_details WHERE inv_id = '".$inv_id->row['invoice_id']."' ");
            $this->db->query("DELETE FROM " . DB_PREFIX . "journal_invoice WHERE entry_id = '".$entry_id."'");
            return $query;
        }
        
        public function minmaxId(){
            $query = $this->db->query("SELECT MAX(entry_id) as max, MIN(entry_id) as min FROM " . DB_PREFIX . "journal_invoice");
            return $query->row;
        }
        
        public function InvoiceDetails($id){
            $query = $this->db->query("SELECT acc_name as acc_name, debit_amount as debit_amount, credit_amount as credit_amount, memo as memo, name_ as name FROM " . DB_PREFIX . "journal_invoice_details WHERE inv_id = '".$id."'");
            return $query->rows;
        }
        
        public function nameID($data){
            $empty = "";
            if ($data == 0){
                return $empty;
            }
            else{
                $name_id = $this->db->query("SELECT acc_name as name FROM " . DB_PREFIX . " account_chart WHERE acc_id = '".$data."'");
                return $name_id->row['name'];
            }
        }
        
        public function retrieveID($date){
            //$date = $this->db->query("SELECT CONVERT(varchar,'". $date ."', 101)");
            //echo $date;
            $query = $this->db->query("SELECT inv_id as id, entry_id as entry_id, inv_date as inv_date FROM " . DB_PREFIX . "journal_invoice WHERE update_date >= ''".$date."''");
            return $query->rows;
        }
        
        public function retrieveDetails($id){
            $query = $this->db->query("SELECT acc_name as account, debit_amount as debit, credit_amount as credit, memo as memo FROM " . DB_PREFIX . "journal_invoice_details WHERE inv_id = '".$id."' group by inv_id");
            return $query->rows;
        }
}

?>