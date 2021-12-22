<?php
class ModelReportsCustom extends Model {

	
        public function get_customer(){
                       
            $sql = "SELECT c.cust_id as cust_id,c.cust_name as cust_name,
                        c.cust_group_id as cust_group_id,cg.cust_group_name as cust_group_name,
                        c.cust_type_id as cust_type_id,ct.cust_type_name as cust_type_name FROM ".DB_PREFIX."customer c
                        LEFT JOIN ".DB_PREFIX."customer_groups cg ON (cg.id = c.cust_group_id)
                        LEFT JOIN ".DB_PREFIX."customer_types ct ON (ct.id = c.cust_type_id)    
                        WHERE c.cust_id!='0'";
            
            $query = $this->db->query($sql);            
            return $query->rows;
        }

        public function item_quantity($item_id)
        {
             $sql="SELECT item_id,SUM(CASE WHEN `invoice_type`!='' THEN qty*conv_from ELSE 0 END) AS QtyOnHand, SUM(CASE WHEN `invoice_type`='6' THEN qty*conv_from ELSE 0 END) AS OpeningQty, SUM(CASE WHEN `invoice_type`='2' THEN qty*conv_from ELSE 0 END) AS SaleQty, SUM(CASE WHEN `invoice_type`='4' THEN qty*conv_from ELSE 0 END) AS PurchaseQty, SUM(CASE WHEN `invoice_type`='7' THEN qty*conv_from ELSE 0 END) AS AdjustQty, SUM(CASE WHEN `invoice_type`='1' THEN qty*conv_from ELSE 0 END) AS S_RetunQty, SUM(CASE WHEN `invoice_type`='5' THEN qty*conv_from ELSE 0 END) AS P_ReturnQty FROM item_warehouse WHERE item_id='$item_id' GROUP BY item_id ";
          // echo $sql;exit;
              $query = $this->db->query($sql);
            $qty = $query->row['QtyOnHand']==NULL ? 0 :$query->row['QtyOnHand'];            
            return $qty;
        }
        
        public function get_stock($data){
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "item                              
                    ");             
            $results = $query->rows; 
            $items = array();
            foreach ($results as $result) {
                // $purchase_qty = $this->get_purchase_items($result['id']);
                // $sale_qty = $this->get_sale_items($result['id']);
                // $adjust_qty = $this->get_adjust_items($result['id']);
                // $qty = $result['quantity']+$adjust_qty+$purchase_qty-$sale_qty;   
                 $ItemQty= $this->item_quantity($result['id']);                               
                
                $items[] = array(
                    'item_id'             => $result['id'],
                    'item_name'             => $result['item_name'],
                    'qty'             => $ItemQty,
                    'cldate'             => date('d/m/Y',strtotime($data["end_date"]))
                );
                
            }
            return $items;
        }
        
        public function get_invoices($data){
            $query = $this->db->query("SELECT 
                    inv.invoice_no AS inv_no, 
                    inv.invoice_date AS inv_date,
                    inv.invoice_type AS inv_type, 
                    inv.cust_id AS inv_cust, 
                    pos.inv_item_id AS item_id, 
                    pos.inv_item_name AS item_name, 
                    pos.inv_item_price  AS item_price, 
                    pos.inv_item_quantity AS item_qty, 
                    (pos.inv_item_price*(pos.inv_item_discount/100) )*pos.item_quantity AS item_discount, 
                    pos.inv_item_subTotal AS item_net_price, 
                    ct.id AS cust_type, 
                    c.cust_group_id AS cust_town
                    FROM pos_invoice_detail pos
                    LEFT JOIN pos_invoice inv ON (pos.inv_id = inv.invoice_id)
                    LEFT JOIN customer c ON (c.cust_id = inv.cust_id)
                    LEFT JOIN customer_types ct ON (c.cust_type_id = ct.id)
                    WHERE inv.invoice_date>='".$data["start_date"]."' AND inv.invoice_date<'".$data["end_date"]."' + INTERVAL 1 DAY");                         
            
            return $query->rows;
        }
        
        private function get_purchase_items($item_id){
            
            $sql = "SELECT sum( pd.inv_item_quantity ) 
                    AS qty 
                    FROM ". DB_PREFIX . "po_invoice_detail AS pd
                    LEFT JOIN " . DB_PREFIX . "po_invoice inv ON ( pd.inv_id = inv.invoice_id )
                    LEFT JOIN " . DB_PREFIX . "item i ON ( pd.inv_item_id = i.id )
                    LEFT JOIN " . DB_PREFIX . "category c ON ( c.id = i.category_id )                    
                    WHERE i.id='".$item_id."' AND inv.invoice_status >= '2'  
                    ";            
            $query = $this->db->query($sql);
            $qty = $query->row['qty']==NULL ? 0 :$query->row['qty'];            
            return $qty;
        }
        
        private function get_sale_items($item_id){
            
            $sql = "SELECT sum( pd.inv_item_quantity ) 
                AS qty 
                FROM ". DB_PREFIX . "pos_invoice_detail AS pd
                LEFT JOIN " . DB_PREFIX . "pos_invoice inv ON ( pd.inv_id = inv.invoice_id )
                LEFT JOIN " . DB_PREFIX . "item i ON ( pd.inv_item_id = i.id )
                LEFT JOIN " . DB_PREFIX . "category c ON ( c.id = i.category_id )                    
                WHERE i.id='".$item_id."'  AND inv.invoice_status >= '2' 
                ";
            // echo $sql;exit;
            $query = $this->db->query($sql);
            $qty = $query->row['qty']==NULL ? 0 :$query->row['qty'];
            return $qty;
        }
        
        private function get_adjust_items($item_id){            
            $sql = "SELECT sum( qty ) 
                AS qty 
                FROM ". DB_PREFIX . "stock_adjust                            
                WHERE item_id='".$item_id."' ";
            
            $query = $this->db->query($sql);
            $qty = $query->row['qty']==NULL ? 0 :$query->row['qty'];
            return $qty;
        }
        
        
}
?>
