<?php
class ModelDashboardDashboard extends Model{
              
        public function getSalesReport($data){
                if($data['type_id']=="1"){
                $sql = "SELECT sum(invoice_total)-sum(discount) as yAxis ,HOUR(invoice_date) as xAxis FROM " . DB_PREFIX . "pos_invoice 
                    WHERE  `invoice_date` > DATE_SUB('".$data['cur_datetime']."', INTERVAL '".$data['cur_hour']."' HOUR) AND invoice_status=2
                    GROUP BY HOUR(invoice_date)
                    ORDER BY HOUR(`invoice_date`) DESC
        		";
                }
                else if($data['type_id']=="2"){
                    $sql = "SELECT sum(invoice_total)-sum(discount) as yData,DAYNAME(invoice_date) as xData FROM pos_invoice 
                            WHERE  `invoice_date` > DATE_SUB('".$data['cur_datetime']."', INTERVAL DAYOFWEEK('".$data['cur_datetime']."') DAY) AND invoice_status=2
                            GROUP BY DAY(invoice_date)
                            ORDER BY `invoice_date` DESC";
                }
                else if($data['type_id']=="3"){
                    $sql = "SELECT sum(invoice_total)-sum(discount) as yData,DAYOFMONTH(invoice_date) as xData FROM pos_invoice 
                            WHERE  `invoice_date` > DATE_SUB('".$data['cur_datetime']."', INTERVAL DAYOFMONTH('".$data['cur_datetime']."') DAY) AND MONTH(invoice_date)=MONTH('".$data['cur_datetime']."') AND invoice_status=2
                            GROUP BY DATE(invoice_date)
                            ORDER BY DATE(invoice_date) DESC";
                }
                else if($data['type_id']=="4"){
                    $sql = "SELECT sum(invoice_total)-sum(discount) as yData,MONTHNAME(invoice_date)  as xData FROM pos_invoice 
                            WHERE  `invoice_date` > DATE_SUB('".$data['cur_datetime']."', INTERVAL 3 MONTH) AND invoice_status=2
                            GROUP BY MONTH(invoice_date)
                            ORDER BY `invoice_date` DESC";
                }
                else if($data['type_id']=="5"){
                    $sql = "SELECT sum(invoice_total)-sum(discount) as yData,MONTHNAME(invoice_date)  as xData FROM pos_invoice 
                            WHERE  `invoice_date` > DATE_SUB('".$data['cur_datetime']."', INTERVAL MONTH('".$data['cur_datetime']."') MONTH) AND invoice_status=2
                            GROUP BY MONTH(invoice_date)
                            ORDER BY `invoice_date` DESC";
                }
                else if($data['type_id']=="6" || $data['type_id']=="7" || $data['type_id']=="8" || $data['type_id']=="9" || $data['type_id']=="10"){
                    $sql = "SELECT sum(invoice_total)-sum(discount) as yData, invoice_date as xData FROM pos_invoice 
                            WHERE  `invoice_date` > DATE_SUB('".$data['cur_datetime']."', INTERVAL '".$data['dur_day']."' DAY) AND invoice_status=2
                            GROUP BY DATE(invoice_date)
                            ORDER BY `invoice_date` DESc";
                }
                $query = $this->db->query($sql);
		return $query->rows;
        }
        
        public function  getProductReport($data){
            $sql_part = ($data['scale']=="item_price") ? "pid.inv_".$data['scale']."* pid.inv_item_quantity" :"pid.inv_".$data['scale'];
            if($data['type_id']=="1"){
                $sql = "SELECT sum(".$sql_part.") as yData ,itm.item_name as xData FROM " . DB_PREFIX . "pos_invoice p 
                        LEFT JOIN " . DB_PREFIX . "pos_invoice_detail pid ON (p.invoice_id = pid.inv_id)
                        LEFT JOIN " . DB_PREFIX . "item itm ON (itm.id = pid.inv_item_id)
                        WHERE  p.invoice_date > DATE_SUB('".$data['cur_datetime']."', INTERVAL '".$data['cur_hour']."' HOUR)  AND invoice_status=2
                        GROUP BY  pid.inv_item_id 
                        ORDER BY yData DESC
                        LIMIT 0,5
        		";
            }
            else if($data['type_id']=="2"){
                $sql = "SELECT sum(".$sql_part.") as yData ,itm.item_name as xData FROM " . DB_PREFIX . "pos_invoice p 
                        LEFT JOIN " . DB_PREFIX . "pos_invoice_detail pid ON (p.invoice_id = pid.inv_id)
                        LEFT JOIN " . DB_PREFIX . "item itm ON (itm.id = pid.inv_item_id)
                        WHERE  p.invoice_date > DATE_SUB('".$data['cur_datetime']."', INTERVAL DAYOFWEEK('".$data['cur_datetime']."') DAY)  AND invoice_status=2
                        GROUP BY pid.inv_item_id  
                        ORDER BY yData DESC
                        LIMIT 0,5";
            }
            else if($data['type_id']=="3"){                
                $sql = "SELECT sum(".$sql_part.") as yData ,itm.item_name as xData FROM " . DB_PREFIX . "pos_invoice p 
                        LEFT JOIN " . DB_PREFIX . "pos_invoice_detail pid ON (p.invoice_id = pid.inv_id)
                        LEFT JOIN " . DB_PREFIX . "item itm ON (itm.id = pid.inv_item_id)
                        WHERE  p.invoice_date > DATE_SUB('".$data['cur_datetime']."', INTERVAL DAYOFMONTH('".$data['cur_datetime']."') DAY) AND MONTH(invoice_date)=MONTH('".$data['cur_datetime']."') AND invoice_status=2
                        GROUP BY pid.inv_item_id  
                        ORDER BY yData DESC
                        LIMIT 0,5";
            }
            else if($data['type_id']=="4"){
                $sql = "SELECT sum(".$sql_part.") as yData ,itm.item_name as xData FROM " . DB_PREFIX . "pos_invoice p 
                        LEFT JOIN " . DB_PREFIX . "pos_invoice_detail pid ON (p.invoice_id = pid.inv_id)
                        LEFT JOIN " . DB_PREFIX . "item itm ON (itm.id = pid.inv_item_id)
                        WHERE  p.invoice_date > DATE_SUB('".$data['cur_datetime']."', INTERVAL 3 MONTH)
                        GROUP BY pid.inv_item_id  
                        ORDER BY yData DESC
                        LIMIT 0,5";
            }
            else if($data['type_id']=="5"){
                $sql = "SELECT sum(".$sql_part.") as yData ,itm.item_name as xData FROM " . DB_PREFIX . "pos_invoice p 
                        LEFT JOIN " . DB_PREFIX . "pos_invoice_detail pid ON (p.invoice_id = pid.inv_id)
                        LEFT JOIN " . DB_PREFIX . "item itm ON (itm.id = pid.inv_item_id)
                        WHERE  p.invoice_date > DATE_SUB('".$data['cur_datetime']."', INTERVAL MONTH('".$data['cur_datetime']."') MONTH) AND invoice_status=2
                        GROUP BY pid.inv_item_id 
                        ORDER BY yData DESC
                        LIMIT 0,5";
            }
            else if($data['type_id']=="6" || $data['type_id']=="7" || $data['type_id']=="8" || $data['type_id']=="9" || $data['type_id']=="10"){
                $sql = "SELECT sum(".$sql_part.") as yData ,itm.item_name as xData FROM " . DB_PREFIX . "pos_invoice p 
                        LEFT JOIN " . DB_PREFIX . "pos_invoice_detail pid ON (p.invoice_id = pid.inv_id)
                        LEFT JOIN " . DB_PREFIX . "item itm ON (itm.id = pid.inv_item_id)
                        WHERE  p.invoice_date > DATE_SUB('".$data['cur_datetime']."', INTERVAL '".$data['dur_day']."' DAY) AND invoice_status=2
                        GROUP BY pid.inv_item_id 
                        ORDER BY yData DESC
                        LIMIT 0,5";
            }
            
            $query = $this->db->query($sql);
            return $query->rows;
        }
        
        public function  getPCustomerReport($data){
            if($data['type_id']=="1"){
                $sql = "SELECT sum(p.invoice_total)-sum(p.discount) as yData ,cust.cust_name as xData FROM " . DB_PREFIX . "pos_invoice p
                        LEFT JOIN " . DB_PREFIX . "customer cust ON (cust.cust_id = p.cust_id)
                        WHERE  p.invoice_date > DATE_SUB('".$data['cur_datetime']."', INTERVAL '".$data['cur_hour']."' HOUR)  AND invoice_status=2
                        GROUP BY cust.cust_id
                        ORDER BY yData DESC
                        limit 0,5
        		";
            }
            else if($data['type_id']=="2"){
                $sql = "SELECT sum(p.invoice_total)-sum(p.discount) as yData ,cust.cust_name as xData FROM " . DB_PREFIX . "pos_invoice p
                        LEFT JOIN " . DB_PREFIX . "customer cust ON (cust.cust_id = p.cust_id)
                        WHERE  p.invoice_date > DATE_SUB('".$data['cur_datetime']."', INTERVAL DAYOFWEEK('".$data['cur_datetime']."') DAY)  AND invoice_status=2
                        GROUP BY cust.cust_id
                        ORDER BY yData DESC
                        limit 0,5";
            }
            else if($data['type_id']=="3"){
                $sql = "SELECT sum(p.invoice_total)-sum(p.discount) as yData ,cust.cust_name as xData FROM " . DB_PREFIX . "pos_invoice p
                        LEFT JOIN " . DB_PREFIX . "customer cust ON (cust.cust_id = p.cust_id)
                        WHERE  p.invoice_date > DATE_SUB('".$data['cur_datetime']."', INTERVAL DAYOFMONTH('".$data['cur_datetime']."') DAY) AND MONTH(invoice_date)=MONTH('".$data['cur_datetime']."') AND invoice_status=2
                        GROUP BY cust.cust_id
                        ORDER BY yData DESC
                        limit 0,5";
            }
            else if($data['type_id']=="4"){
                $sql = "SELECT sum(p.invoice_total)-sum(p.discount) as yData ,cust.cust_name as xData FROM " . DB_PREFIX . "pos_invoice p
                        LEFT JOIN " . DB_PREFIX . "customer cust ON (cust.cust_id = p.cust_id) 
                        WHERE  p.invoice_date > DATE_SUB('".$data['cur_datetime']."', INTERVAL 3 MONTH)
                        GROUP BY cust.cust_id
                        ORDER BY yData DESC
                        limit 0,5";
            }
            else if($data['type_id']=="5"){
                $sql = "SELECT sum(p.invoice_total)-sum(p.discount) as yData ,cust.cust_name as xData FROM " . DB_PREFIX . "pos_invoice p
                        LEFT JOIN " . DB_PREFIX . "customer cust ON (cust.cust_id = p.cust_id)
                        WHERE  p.invoice_date > DATE_SUB('".$data['cur_datetime']."', INTERVAL MONTH('".$data['cur_datetime']."') MONTH) AND invoice_status=2
                        GROUP BY cust.cust_id
                        ORDER BY yData DESC
                        limit 0,5";
            }
            else if($data['type_id']=="6" || $data['type_id']=="7" || $data['type_id']=="8" || $data['type_id']=="9" || $data['type_id']=="10"){
                $sql = "SELECT sum(p.invoice_total)-sum(p.discount) as yData ,cust.cust_name as xData FROM " . DB_PREFIX . "pos_invoice p
                        LEFT JOIN " . DB_PREFIX . "customer cust ON (cust.cust_id = p.cust_id)
                        WHERE  p.invoice_date > DATE_SUB('".$data['cur_datetime']."', INTERVAL '".$data['dur_day']."' DAY) AND invoice_status=2
                        GROUP BY cust.cust_id
                        ORDER BY yData DESC
                        limit 0,5";
            }
            $query = $this->db->query($sql);
            return $query->rows;
        }
       
}
?>
