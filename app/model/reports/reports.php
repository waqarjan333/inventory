<?php
class ModelReportsReports extends Model {

    public function sale_report($data) {
        //bugs fixed
            $date_range = "";
            $search_category = "";
            $all_cat_col="";
            $all_cat="";
            $wareh="";
            $search_product = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND inv.invoice_date>='". $start_date ."' AND inv.invoice_date < '". $end_date ."' + interval 1 day";
                }
            }
            if(isset($data['category_id']) && !empty($data['category_id'])){
                $search_category = " AND i.category_id IN (".$data['category_id'].")";
            }
            if($data['warehouse']!='-1')
            {
               $warehouse=$data['warehouse'];
               $wareh=" AND pd.warehouse_id='".$warehouse."'"; 
            }
            if(isset($data["product_id"]) && !empty($data["product_id"])){
                $search_product = " AND pd.inv_item_id IN ('".$data["product_id"]."')";
            }

            if($data['print_category_report']==1)
            {   $category="sub_cat";
                $all_cat_col=",d.parent_id AS m_parent,d.name AS category,d.id AS m_id";
                $all_cat="LEFT JOIN " . DB_PREFIX . "category d ON (d.id=c.parent_id)";
            }
            else{
                $category="category";
            }
           

            $sql = "SELECT pd.inv_item_id AS item_id,c.name AS ".$category.",c.parent_id as main_id, i.item_name AS product,i.id as id,
                    pd.warehouse_id AS ware_id,
                    w.warehouse_name AS warehouse,
                    i.type_id AS type,
                    i.quantity  AS qty,
                    pd.conv_from, 
                    i.normal_price as trade, 
                    i.sale_price as s_price, 
                    SUM(pd.inv_item_price*pd.item_quantity)AS sale,
                   sum((pd.inv_item_price*(pd.inv_item_discount/100) )*pd.item_quantity) AS discount,
                   SUM(pd.inv_item_subTotal) AS sales,
                    SUM(pd.item_purchase_price*pd.item_quantity) as item_cost,SUM(pd.inv_item_quantity) AS s_qty
                    ".$all_cat_col."
                    FROM " . DB_PREFIX . "pos_invoice_detail AS pd
                    LEFT JOIN " . DB_PREFIX . "pos_invoice inv ON ( pd.inv_id = inv.invoice_id )
                    LEFT JOIN " . DB_PREFIX . "item i ON ( pd.inv_item_id = i.id )
                    LEFT JOIN " . DB_PREFIX . "category c ON ( c.id = i.category_id )
                    LEFT JOIN " . DB_PREFIX . "warehouses w ON ( w.warehouse_id = pd.warehouse_id )
                    ".$all_cat."
                    WHERE inv.invoice_status >= '2' AND inv.sale_return='0' ".$search_category." ".$search_product." ".$date_range."
                    ".$wareh."
                    GROUP BY i.id,w.warehouse_id order by w.warehouse_id,i.category_id DESC,i.item_name ASC";
            
            $query = $this->db->query($sql);            
            return $query->rows;
            
    }

    public function SaleReturn_report($data)
    {
         $date_range = "";
            $search_category = "";
            $all_cat_col="";
            $all_cat="";
            $wareh="";
            $search_product = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND inv.invoice_date>='". $start_date ."' AND inv.invoice_date < '". $end_date ."' + interval 1 day";
                }
            }
            if(isset($data['category_id']) && !empty($data['category_id'])){
                $search_category = " AND i.category_id IN (".$data['category_id'].")";
            }
            else{
             $wareh=" AND pd.warehouse_id !=''";   
            }
            if(isset($data["product_id"]) && !empty($data["product_id"])){
                $search_product = " AND pd.inv_item_id IN ('".$data["product_id"]."')";
            }
           

            $sql = "SELECT c.name AS category,c.parent_id as main_id, i.item_name AS product,i.id as id,
                    i.type_id AS type,
                    i.quantity  AS qty,
                    pd.conv_from, 
                    i.normal_price as trade, 
                    i.sale_price as s_price, 
                    SUM(pd.inv_item_price*pd.item_quantity)AS sale,
                   sum((pd.inv_item_price*(pd.inv_item_discount/100) )*pd.item_quantity) AS discount,
                   SUM(pd.inv_item_subTotal) AS sales,
                    SUM(pd.item_purchase_price*pd.item_quantity) as item_cost,SUM(pd.inv_item_quantity) AS s_qty
                    ".$all_cat_col."
                    FROM " . DB_PREFIX . "pos_invoice_detail AS pd
                    LEFT JOIN " . DB_PREFIX . "pos_invoice inv ON ( pd.inv_id = inv.invoice_id )
                    LEFT JOIN " . DB_PREFIX . "item i ON ( pd.inv_item_id = i.id )
                    LEFT JOIN " . DB_PREFIX . "category c ON ( c.id = i.category_id )
                    ".$all_cat."
                    WHERE inv.invoice_status >= '2' AND inv.sale_return='1' ".$search_category." ".$search_product." ".$date_range."
                    ".$wareh."
                    GROUP BY i.id order by i.category_id DESC,i.item_name ASC";
            
            
            $query = $this->db->query($sql);            
            return $query->rows;
    }

    public function SaleReportCatWise($data)
    {
         $date_range = "";
            $search_category = "";
            $all_cat_col="";
            $all_cat="";
            $wareh="";
            $search_product = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND inv.invoice_date>='". $start_date ."' AND inv.invoice_date < '". $end_date ."' + interval 1 day";
                }
            }
            if(isset($data['category_id']) && !empty($data['category_id'])){
                $search_category = " AND i.category_id IN (".$data['category_id'].")";
            }
            

            $sql = "SELECT c.name AS category,c.parent_id as main_id, i.item_name AS product,i.id as id,
                    i.quantity  AS qty,
                    pd.conv_from, 
                    i.normal_price as trade, 
                    i.sale_price as s_price, 
                    SUM(pd.inv_item_price*pd.item_quantity)AS sale,
                    sum((pd.inv_item_price*(pd.inv_item_discount/100) )*pd.item_quantity) AS discount,
                    SUM(pd.inv_item_subTotal) AS sales,
                    SUM(pd.item_purchase_price*pd.item_quantity) as item_cost,SUM(pd.inv_item_quantity) AS s_qty
                    ".$all_cat_col."
                    FROM " . DB_PREFIX . "pos_invoice_detail AS pd
                    LEFT JOIN " . DB_PREFIX . "pos_invoice inv ON ( pd.inv_id = inv.invoice_id )
                    LEFT JOIN " . DB_PREFIX . "item i ON ( pd.inv_item_id = i.id )
                    LEFT JOIN " . DB_PREFIX . "category c ON ( c.id = i.category_id )
                   
                    WHERE inv.invoice_status >= '2' AND inv.sale_return='0' ".$search_category." ".$date_range."
                    GROUP BY i.category_id order by i.category_id";
            
            
            $query = $this->db->query($sql);            
            return $query->rows;
    }

    public function getAmountRecievExpenseSaleRep($data){
            $search_repID = $date_range = '';
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND j.entry_date>='". $start_date ."' AND j.entry_date < '". $end_date ."' + interval 1 day";
                }
            }
            if(!empty($data['rep_id']) && $data['rep_id'] !='-1'){
                $search_repID = " AND rep_det.salesrep_id = '".$data['rep_id']."'";
            }
            $sql = "SELECT 
                    SUM( IF( rep_det.type_id = '4' AND j.journal_amount >0, j.journal_amount, 0 ) ) AS ExpenseAmount, 
                    SUM( IF( rep_det.type_id = '1' AND j.journal_amount >0, j.journal_amount, 0 ) ) AS RecivedAmount,
                    rep.salesrep_name AS saleRepName, rep_det.salesrep_id AS saleRepID
                    FROM  salesrep_detail rep_det
                    LEFT JOIN  account_journal j ON ( rep_det.ref_id = j.ref_id ) 
                    LEFT JOIN  salesrep rep ON ( rep_det.salesrep_id = rep.id )
                    WHERE rep_det.sr_idx!='' ".$search_repID." ".$date_range." GROUP BY rep_det.salesrep_id";
            // echo $sql;exit;
            $query = $this->db->query($sql);
            return $query->rows;
    }

    public function get_stock_inventory($data)
    {
              $date_range = "";
            $search_category = "";
            $all_cat_col="";
            $all_cat="";
            $wareh="";
            $search_product = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND inv.invoice_date>='". $start_date ."' AND inv.invoice_date < '". $end_date ."' + interval 1 day";
                }
            }
            if($data['category_id']!=''){
                $search_category = " AND i.category_id = '".$data['category_id']."'";
            }
             if($data['warehouse']!='-1')
            {
                $warehouse=$data['warehouse'];
               $wareh=" AND pd.warehouse_id='".$warehouse."'"; 
            }
            else{
             $wareh=" AND pd.warehouse_id !='-1'";   
            }
            if(isset($data["product_id"]) && !empty($data["product_id"])){
                $search_product = " AND pd.inv_item_id IN ('".$data["product_id"]."')";
            }

        $sql="SELECT SUM(pd.inv_item_quantity) qty, SUM(pd.inv_item_quantity*pd.inv_item_price) AS sale,i.item_name AS product,c.name AS category,i.avg_cost AS trade,i.sale_price,i.id FROM pos_invoice_detail pd LEFT JOIN pos_invoice inv ON (inv.invoice_id=pd.inv_id) LEFT JOIN item i ON (i.id=pd.inv_item_id) LEFT JOIN category c ON (c.id=i.category_id) WHERE inv.invoice_status >= '2' AND inv.sale_return='0' ".$search_category." ".$search_product." ".$date_range."
                    ".$wareh."  GROUP BY i.id ORDER by i.item_name ASC";
        
            $query = $this->db->query($sql);            
            return $query->rows;              
    }

    public function get_purchase_qty($item_id,$data)
    {
         $start_date =date('Y-m-d', strtotime($data['start_date']));
         $end_date =date('Y-m-d', strtotime($data['end_date']));
         $sql="SELECT SUM(CASE WHEN invoice_type='4' THEN qty*conv_from ELSE NULL END) AS purchase_qty FROM " . DB_PREFIX . " item_warehouse WHERE item_id='$item_id' AND inv_date>='$start_date' AND inv_date < '". $end_date ."' + interval 1 day";
         
            $query = $this->db->query($sql);
            $qty = $query->row['purchase_qty']==NULL ? 0 :$query->row['purchase_qty'];            
            return $qty;
    }
    public function get_purchaseRet_qty($item_id,$data)
    {
                 $start_date =date('Y-m-d', strtotime($data['start_date']));
         $end_date =date('Y-m-d', strtotime($data['end_date']));
        $sql="SELECT SUM(CASE WHEN invoice_type='5' THEN qty*conv_from ELSE NULL END) AS purchaseRet_qty FROM " . DB_PREFIX . " item_warehouse WHERE item_id='$item_id' AND inv_date>='$start_date' AND inv_date < '". $end_date ."' + interval 1 day";
         
            $query = $this->db->query($sql);
            $qty = $query->row['purchaseRet_qty']==NULL ? 0 :-1*$query->row['purchaseRet_qty'];            
            return $qty;
    }

    public function getSaleRetqty($item_id,$data)
    {
         $start_date =date('Y-m-d', strtotime($data['start_date']));
         $end_date =date('Y-m-d', strtotime($data['end_date']));
     $sql="SELECT SUM(CASE WHEN invoice_type='1' THEN qty*conv_from ELSE NULL END) AS saleRet_qty FROM " . DB_PREFIX . " item_warehouse WHERE item_id='$item_id' AND inv_date>='$start_date' AND inv_date < '". $end_date ."' + interval 1 day";
         
            $query = $this->db->query($sql);
            $qty = $query->row['saleRet_qty']==NULL ? 0 :$query->row['saleRet_qty'];            
            return $qty;   
    }
      public function getadjuststockQty($item_id,$data)
    {
         $start_date =date('Y-m-d', strtotime($data['start_date']));
         $end_date =date('Y-m-d', strtotime($data['end_date']));
     $sql="SELECT SUM(CASE WHEN invoice_type='7' THEN qty*conv_from ELSE NULL END) AS adjust_qty FROM " . DB_PREFIX . " item_warehouse WHERE item_id='$item_id' AND inv_date>='$start_date' AND inv_date < '". $end_date ."' + interval 1 day";
         
            $query = $this->db->query($sql);
            $qty = $query->row['adjust_qty']==NULL ? 0 :$query->row['adjust_qty'];            
            return $qty;   
    }

    public function sqlOpenStockqty($item_id,$data)
    {
      $start_date =date('Y-m-d', strtotime($data['start_date']));
         $end_date =date('Y-m-d', strtotime($data['end_date']));
     $sql="SELECT SUM(CASE WHEN invoice_type='6' THEN qty*conv_from ELSE NULL END) AS opening_StockQty FROM " . DB_PREFIX . " item_warehouse WHERE item_id='$item_id' AND inv_date>='$start_date' AND inv_date < '". $end_date ."' + interval 1 day";
         
            $query = $this->db->query($sql);
            $qty = $query->row['opening_StockQty']==NULL ? 0 :$query->row['opening_StockQty'];            
            return $qty;      
    }

        public function main_category($cat_id)
        {
            $sql="SELECT * FROM category WHERE id='$cat_id'";
              
            // $query = $this->db->query($sql);            
            $query = $this->db->query($sql);
            return $query->row;
            
        } 

         public function sub_category($cat_id)
        {
            $sql="SELECT * FROM category WHERE id='$cat_id'";
              
            // $query = $this->db->query($sql);            
            $query = $this->db->query($sql);
            return $query->row;
            
        }



    public function sale_Returnreport($data) {
            $date_range = "";
            $search_category = "";
            $search_product = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND inv.invoice_date>='". $start_date ."' AND inv.invoice_date < '". $end_date ."' + interval 1 day";
                }
            }
            if($data['category_id']!=''){
                $search_category = " AND i.category_id = '".$data['category_id']."'";
            }
            if(isset($data["product_id"]) && !empty($data["product_id"])){
                $search_product = " AND pd.inv_item_id = '".$data["product_id"]."'";
            }
            $sql = "SELECT c.name AS category, i.item_name AS product,i.id AS id, 
                    sum(pd.inv_item_quantity)  AS qty, pd.inv_item_price as sale_price, 
                    sum((pd.inv_item_price*(pd.inv_item_discount/100) )*pd.item_quantity) AS discount,
                    sum( pd.item_quantity * pd.inv_item_price) AS sale, 
                    sum( pd.item_purchase_price * pd.item_quantity ) AS cost
                    FROM " . DB_PREFIX . "pos_invoice_detail AS pd
                    LEFT JOIN " . DB_PREFIX . "pos_invoice inv ON ( pd.inv_id = inv.invoice_id )
                    LEFT JOIN " . DB_PREFIX . "item i ON ( pd.inv_item_id = i.id )
                    LEFT JOIN " . DB_PREFIX . "category c ON ( c.id = i.category_id )
                    WHERE inv.sale_return='1' ".$search_category." ".$search_product." ".$date_range." 
                    GROUP BY i.category_id, i.id";
            
            $query = $this->db->query($sql);            
            return $query->rows;
        }
   // public function daily_sale_report($data){
   //          $date_range = "";
   //          if(isset($data["start_date"]) && isset($data["end_date"]) ){
   //              if(!empty($data["start_date"]) && !empty($data["end_date"])){
   //                  $start_date = $data["start_date"];
   //                  $end_date = $data["end_date"];
   //                  $date_range = "AND invoice_date>='". $start_date ."' AND invoice_date < '". $end_date ."' + interval 1 day";
   //              }
   //          }  
   //           $sql = "SELECT COUNT( * ) AS invoices,  `invoice_date` AS date, SUM(  `invoice_total` ) AS amount
   //                  FROM  `pos_invoice` 
   //                  WHERE `invoice_status`>=2 AND  `invoice_type` IN  ('1','2') ".$date_range." GROUP BY date(  `invoice_date` )";
   //          $query = $this->db->query($sql);
   //          return $query->rows;
   //  }
          public function daily_sale_report($data){
            $date_range = "";
            $search_customer="";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND invoice_date>='". $start_date ."' AND invoice_date < '". $end_date ."' + interval 1 day";
                }
            }
            if($data['customer_region']!='-1'){                
                $search_customer = " AND cust.cust_group_id = '".$data['customer_region']."'";
            }  
             $sql = "SELECT COUNT(DISTINCT(invoice_id)) AS no,  GROUP_CONCAT(DISTINCT(invoice_id)) AS invoices, inv.`invoice_date` AS date, SUM(inv.`invoice_total`) AS amount ,grp.cust_group_name AS region,SUM(pos.inv_item_quantity) AS qty FROM `pos_invoice` inv LEFT JOIN customer cust ON (cust.cust_id=inv.cust_id) LEFT JOIN customer_groups grp ON (grp.id=cust.cust_group_id) LEFT JOIN pos_invoice_detail pos ON (pos.inv_id=inv.invoice_id) WHERE inv.`invoice_status`>=2 ".$date_range."  GROUP BY grp.id,date(inv.`invoice_date`) ORDER BY grp.cust_group_name";
                    // echo $sql;exit;

            $query = $this->db->query($sql);
            return $query->rows;
    }
    public function getPayableLoan($data){
            $acc_type="";
            $date_range = "";
            if(isset($data["start_date"]) ){
                if(!empty($data["start_date"])){
                    $start_date = $data["start_date"];
                    $date_range = " AND j.entry_date < '". $start_date ."' + interval 1 day";
                }
            }
            $sql = "SELECT SUM( j.journal_amount ) AS amount, ac.acc_id AS acc_id, ac.acc_name as acc_name, ac.acc_type_id as acc_type_id
                    FROM  account_chart ac
                    LEFT JOIN  account_journal j ON ( ac.acc_id = j.acc_id ) 
                    WHERE ac.acc_type_id=15 ".$date_range." GROUP BY ac.acc_id";
            $query = $this->db->query($sql);
            return $query->rows;
    }
    
    public function getReceivableLoan($data){
            $acc_type="";
            $date_range = "";
            if(isset($data["start_date"]) ){
                if(!empty($data["start_date"])){
                    $start_date = $data["start_date"];
                    $date_range = " AND j.entry_date < '". $start_date ."' + interval 1 day";
                }
            }
            $sql = "SELECT SUM( j.journal_amount ) AS amount, ac.acc_id AS acc_id, ac.acc_name as acc_name, ac.acc_type_id as acc_type_id
                    FROM  account_chart ac
                    LEFT JOIN  account_journal j ON ( ac.acc_id = j.acc_id ) 
                    WHERE ac.acc_type_id=14 ".$date_range." GROUP BY ac.acc_id";
            $query = $this->db->query($sql);
            return $query->rows;
    }
    
    public function daily_sale_return_report($date){
            $date_range = "";
            if(isset($date) ){
                    $date_range = "AND invoice_date>='". $date ."' AND invoice_date < '". $date ."' + interval 1 day";
            } 
             $sql = "SELECT COUNT( * ) AS invoice, SUM(  `invoice_paid` ) AS amounts
                    FROM  `pos_invoice` 
                    WHERE `invoice_status`>=2 AND `invoice_type` IN  ('3','4') ".$date_range."";
            $query = $this->db->query($sql);
            return $query->row;
    }
    
    public function daily_sale_qty_report($date){
        // echo $date;

          $date_range = "";
            if(isset($date) ){
                    $date_range = "AND inv.invoice_date>='". $date ."' AND inv.invoice_date < '". $date ."' + interval 1 day";
            } 
             $sql = "SELECT SUM( pos.inv_item_quantity ) AS qty
                    FROM  `pos_invoice` inv
                    LEFT JOIN  `pos_invoice_detail` pos ON ( inv.invoice_id = pos.inv_id ) 
                    WHERE inv.invoice_status>='2' ".$date_range."";
            $query = $this->db->query($sql);
            return $query->row['qty'];
    }

    public function total_sale_return($data) {
            $date_range = "";
            $search_category = "";
            $search_product = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND inv.invoice_date>='". $start_date ."' AND inv.invoice_date < '". $end_date ."' + interval 1 day";
                }
            }
            if($data['category_id']!=''){
                $search_category = " AND i.category_id = '".$data['category_id']."'";
            }
            if(isset($data["product_id"]) && !empty($data["product_id"])){
                $search_product = " AND pd.inv_item_id = '".$data["product_id"]."'";
            }
            if(isset($data['show_in_coton']) && $data['show_in_coton']=='true')
            {
                $cotton="sum( pd.inv_item_quantity/conv_from ) AS return_qty";
            }
            else{
                $cotton="sum( pd.inv_item_quantity) AS return_qty";
            }
            $sql = "SELECT ".$cotton.", 
                           sum( pd.inv_item_subTotal ) AS return_sales,
                           sum( pd.inv_item_price * pd.item_quantity) AS return_sale,
                           sum((pd.item_quantity*pd.inv_item_price) *(pd.inv_item_discount)/100) AS return_discount,
                           sum( pd.item_purchase_price * pd.item_quantity ) AS return_cost
                    FROM `pos_invoice_detail` AS pd
                    LEFT JOIN `pos_invoice` inv ON ( pd.inv_id = inv.invoice_id )
                    LEFT JOIN `item` i ON ( pd.inv_item_id = i.id )
                    LEFT JOIN `category` c ON ( c.id = i.category_id )                    
                    WHERE pd.inv_item_quantity < 0 AND inv.invoice_status >= '2' ".$search_category." ".$search_product." ".$date_range." 
                    "; 
                    // echo $sql;exit;
                    $query = $this->db->query($sql);            
                    return $query->rows;

    }   
        
    
   public function total_discount($data){
            $date_range = "";
            $search_rep = "";
            $_dis=0;
            if($data['category_id']!=''){
                $_dis=0;
            }
            else if(isset($data["product_id"]) && !empty($data["product_id"])){
                $_dis=0;
            }
            else{
                if(isset($data['rep_id']) && !empty($data['rep_id']) && $data['rep_id']!='-1'){
                    $search_rep = " AND salesrep_id = '".$data['rep_id']."' ";
                }
                if(isset($data["start_date"]) && isset($data["end_date"]) ){
                    if(!empty($data["start_date"]) && !empty($data["end_date"])){
                        $start_date = $data["start_date"];
                        $end_date = $data["end_date"];
                        $date_range = "AND invoice_date>='". $start_date ."' AND invoice_date < '". $end_date ."' + interval 1 day";
                    }
                }

                $sql = "SELECT SUM(discount_invoice) AS _discount
                        FROM " . DB_PREFIX . "pos_invoice
                        WHERE invoice_status >= '2' AND sale_return='0' ".$search_rep.$date_range. " 
                        AND discount_invoice!=0";
                
                
                $query = $this->db->query($sql);
               $_dis=$query->row['_discount'];
            }
            return $_dis;

    }

    public function total_Deduction($data)
    {
             $date_range = "";
            $search_rep = "";
            $_dis=0;
            if($data['category_id']!=''){
                $_dis=0;
            }
            else if(isset($data["product_id"]) && !empty($data["product_id"])){
                $_dis=0;
            }
            else{
                if(isset($data['rep_id']) && !empty($data['rep_id']) && $data['rep_id']!='-1'){
                    $search_rep = " AND salesrep_id = '".$data['rep_id']."' ";
                }
                if(isset($data["start_date"]) && isset($data["end_date"]) ){
                    if(!empty($data["start_date"]) && !empty($data["end_date"])){
                        $start_date = $data["start_date"];
                        $end_date = $data["end_date"];
                        $date_range = "AND invoice_date>='". $start_date ."' AND invoice_date < '". $end_date ."' + interval 1 day";
                    }
                }

                $sql = "SELECT SUM(discount_invoice) AS _discount
                        FROM " . DB_PREFIX . "pos_invoice
                        WHERE invoice_status >= '2' AND sale_return='1' ".$search_rep.$date_range. " 
                        AND discount_invoice!=0";
                
                
                $query = $this->db->query($sql);
               $_dis=$query->row['_discount'];
            }
            return $_dis;
    }
    public function get_sale($data){
      $date_range = "";           
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND entry_date>='". $start_date ."' AND entry_date < '". $end_date ."' + interval 1 day";
                }
            }
            $query = "SELECT sum(journal_amount)*-1 AS amount FROM account_journal WHERE acc_id='5' and acc_id!=8 and inv_id!=0 and type in ('S','POS') ".$date_range."";
             $query_sale = $this->db->query($query);
             return  $query_sale->row['amount']==NULL ? 0: $query_sale->row['amount'];
            
    }
    
    public function get_cost($data){
      $date_range = "";           
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND entry_date>='". $start_date ."' AND entry_date < '". $end_date ."' + interval 1 day";
                }
            }
            $query = "SELECT sum(journal_amount) AS amount FROM account_journal WHERE acc_id='2' and inv_id!=0 and type in ('S','POS') ".$date_range."";
             $query_cost = $this->db->query($query);  
            return  $query_cost->row['amount']==NULL ? 0: $query_cost->row['amount']; 
            
        
    }
    public function get_discount($data){
      $date_range = "";           
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND entry_date>='". $start_date ."' AND entry_date < '". $end_date ."' + interval 1 day";
                }
            }
            $query = "SELECT sum(journal_amount) AS amount FROM account_journal WHERE acc_id='10'  and type='DIS' ".$date_range."";
             $query_dis = $this->db->query($query);
             return  $query_dis->row['amount']==NULL ? 0: $query_dis->row['amount'];             
        
    }
    
    public function get_sale_return($data){
      $date_range = "";           
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND entry_date>='". $start_date ."' AND entry_date < '". $end_date ."' + interval 1 day";
                }
            }
            $query = "SELECT sum(journal_amount) AS amount FROM account_journal WHERE acc_id='11' and acc_id!=8 and inv_id!=0 and type in ('POS_RET','SALE_RET') ".$date_range."";
             $query_sale = $this->db->query($query);  
             return  $query_sale->row['amount']==NULL ? 0: $query_sale->row['amount'];
        }
    public function get_cost_return($data){
      $date_range = "";           
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND entry_date>='". $start_date ."' AND entry_date < '". $end_date ."' + interval 1 day";
                }
            }
            $query = "SELECT sum(journal_amount)*-1 AS amount FROM account_journal WHERE acc_id='2' and inv_id!=0 and type in ('POS_RET','SALE_RET') ".$date_range."";
             $query_cost = $this->db->query($query);
             return  $query_cost->row['amount']==NULL ? 0: $query_cost->row['amount'];
                          
        
    }
    public function get_discount_return($data){
      $date_range = "";           
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND entry_date>='". $start_date ."' AND entry_date < '". $end_date ."' + interval 1 day";
                }
            }
            $query = "SELECT sum(journal_amount)*-1 AS amount FROM account_journal WHERE acc_id='12' and inv_id!=0 and type='SALE_RET_I' ".$date_range."";
             $query_dis = $this->db->query($query);  
             return  $query_dis->row['amount']==NULL ? 0: $query_dis->row['amount'];
            
        
    }
    
        public function get_expense($data){
            $date_range = "";           
            if( isset($data["start_date"]) &&  isset($data["end_date"])){
                if(!empty($data["start_date"])){                   
                    $start_date = $data["start_date"];
                    $date_range .= "AND j.entry_date > '". $start_date ."' ";
                }                
                if(!empty($data["end_date"])){                   
                    $end_date = $data["end_date"];
                    $date_range .= " AND j.entry_date < '". $end_date ."' + interval 1 day";
                }
            }
            
            $query = "SELECT sum( j.journal_amount ) 
                    AS amount, acc.acc_name as account_name  
                    FROM ". DB_PREFIX . "account_journal AS j
                    LEFT JOIN " . DB_PREFIX . "account_chart acc ON ( acc.acc_id = j.acc_id )
                    LEFT JOIN " . DB_PREFIX . "account_type acc_type ON ( acc_type.acc_type_id = acc.acc_type_id )                    
                    WHERE acc_type.acc_type_id='5' and acc.acc_id !=9 and acc.acc_id!='10'  ".$date_range." group by acc.acc_id";
            
            $query_income = $this->db->query($query);  
            return $query_income->rows;
        }
    public function get_expenses($data){
            $date_range = "";  $report_expense_combo="";         
            if( isset($data["start_date"]) &&  isset($data["end_date"])){
                if(!empty($data["start_date"])){                   
                    $start_date = $data["start_date"];
                    $date_range .= "AND j.entry_date > '". $start_date ."' ";
                }                
                if(!empty($data["end_date"])){                   
                    $end_date = $data["end_date"];
                    $date_range .= " AND j.entry_date < '". $end_date ."' + interval 1 day";
                }
            }
            if($data['report_expense_combo']!='-1'){
                $report_expense_combo = " AND acc.acc_id = '".$data['report_expense_combo']."'";
            }
            $query = "SELECT acc.acc_id as acc_id, j.journal_amount  
                    AS amount, j.journal_details as journal_details, j.entry_date as date, j.ref_id as ref_id, acc.acc_name as account_name  
                    FROM ". DB_PREFIX . "account_journal AS j
                    LEFT JOIN " . DB_PREFIX . "account_chart acc ON ( acc.acc_id = j.acc_id )
                    LEFT JOIN " . DB_PREFIX . "account_type acc_type ON ( acc_type.acc_type_id = acc.acc_type_id )                    
                    WHERE acc_type.acc_type_id='5' and acc.acc_id !=9 and acc.acc_id!='10' ".$report_expense_combo."  ".$date_range." order by acc.acc_id";
            
            $query_income = $this->db->query($query);  
            return $query_income->rows;
        }
        
        public function account_type($ref_id){
           $query = $this->db->query("SELECT acc.acc_name AS account_name
            FROM ". DB_PREFIX . "account_journal AS j
            LEFT JOIN ". DB_PREFIX . "account_chart acc ON ( acc.acc_id = j.acc_id ) 
            WHERE j.ref_id =  '".$ref_id."'
            AND j.journal_amount <0"); 
        return $query->row['account_name'];
       }
       
    public function total_sale_return_dis($data){
            $date_range = "";
            $search_rep = "";
            $_dis=0;
            if($data['category_id']!=''){
                $_dis=0;
            }
            else if(isset($data["product_id"]) && !empty($data["product_id"])){
                $_dis=0;
            }
            else{
                if(isset($data['rep_id']) && !empty($data['rep_id']) && $data['rep_id']!='-1'){
                    $search_rep = " AND salesrep_id = '".$data['rep_id']."' ";
                }
                if(isset($data["start_date"]) && isset($data["end_date"]) ){
                    if(!empty($data["start_date"]) && !empty($data["end_date"])){
                        $start_date = $data["start_date"];
                        $end_date = $data["end_date"];
                        $date_range = "AND updated_date>='". $start_date ."' AND updated_date < '". $end_date ."' + interval 1 day";
                    }
                }

                $sql = "SELECT sum(discount) AS return_total_discount
                        FROM " . DB_PREFIX . "pos_invoice
                        WHERE invoice_status >= '2' AND sale_return='1' ".$search_rep.$date_range." 
                        ";
                
                
                $query = $this->db->query($sql);
               $_dis=$query->row['return_total_discount'];
            }
            return $_dis;

    }
        public function sale_rep_item_report($data){
            $date_range = "";
            $search_category = "";
            $search_product = "";
            $search_rep = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND inv.updated_date>='". $start_date ."' AND inv.updated_date < '". $end_date ."' + interval 1 day";
                }
            }
            if($data['category_id']!='0'){
                $search_category = " AND i.category_id = '".$data['category_id']."'";
            }
            if($data['rep_id']!='-1'){
                $search_rep = " AND inv.salesrep_id = '".$data['rep_id']."'";
            }
            if(isset($data["product_id"]) && !empty($data["product_id"])){
                $search_product = " AND pd.inv_item_id = '".$data["product_id"]."'";
            }
            $sql = "SELECT sum( pd.inv_item_quantity * (pd.inv_item_price - (pd.inv_item_price * (pd.inv_item_discount/100) ) ) )
                    AS sale, pd.inv_id AS inv_id, sp.salesrep_name as rep_name, sp.id as rep_id
                    FROM " . DB_PREFIX . "pos_invoice_detail AS pd
                    LEFT JOIN " . DB_PREFIX . "pos_invoice inv ON ( pd.inv_id = inv.invoice_id )
                    LEFT JOIN " . DB_PREFIX . "item i ON ( pd.inv_item_id = i.id )
                    LEFT JOIN " . DB_PREFIX . "category c ON ( c.id = i.category_id )
                    LEFT JOIN " . DB_PREFIX . "salesrep sp ON ( sp.id = inv.salesrep_id )
                    WHERE inv.invoice_status >= '2' AND inv.sale_return=0 ".$search_rep." ".$search_category." ".$search_product." ".$date_range." 
                    GROUP BY inv.salesrep_id";
            $query = $this->db->query($sql);
            return $query->rows;

    }
        public function sale_rep_report($data) {
            
            $date_range = "";
            $rep = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND inv.invoice_date>='". $start_date ."' AND inv.invoice_date < '". $end_date ."' + interval 1 day";
                }
            }
              
            if(isset($data["rep_id"]) && ($data["rep_id"]!='-1')){
                $rep = " AND inv.salesrep_id = '".$data["rep_id"]."'";
            }
             $this->db->query("SET group_concat_max_len=9999999");
            $sql = "SELECT group_concat(cast(inv.invoice_id as char) separator ',') AS inv_id, rep.salesrep_name AS rep_name, rep.id as rep_id 
                    FROM " . DB_PREFIX . "pos_invoice AS inv
                    LEFT JOIN " . DB_PREFIX . "salesrep rep ON ( rep.id = inv.salesrep_id )
                    WHERE inv.invoice_status >= '2' ".$date_range." ".$rep." 
                    GROUP BY inv.salesrep_id";
                    // echo $sql;exit;

            $query = $this->db->query($sql);            
            return $query->rows;
        }
    
        
        public function sale_rep_report_cat($inv_id, $data) {
            $search_category = "";
            $search_product = "";

            
            if($data['category_id']!=''){
                $search_category = " AND i.category_id = '".$data['category_id']."'";
            }
            if(isset($data["product_id"]) && !empty($data["product_id"])){
                $search_product = " AND pd.inv_item_id = ".$data["product_id"]."";
            }
            $this->db->query("SET group_concat_max_len=9999999");
            $sql = "SELECT group_concat(cast(pd.inv_item_id as char) separator ',') AS item_id, pd.inv_id as inv_id, c.name as cat_name, i.category_id as cat_id
                    FROM " . DB_PREFIX . "pos_invoice_detail AS pd
                    LEFT JOIN " . DB_PREFIX . "item i ON ( pd.inv_item_id = i.id )
                    LEFT JOIN " . DB_PREFIX . "category c ON ( i.category_id = c.id )
                    WHERE pd.inv_id IN (".$inv_id.") ".$search_product." ".$search_category." GROUP BY i.category_id";
            // echo $sql;exit;
            $query = $this->db->query($sql);            
            return $query->rows;
        }
    public function sale_rep_report_cat_values($item_id,$rep_id) {
            
            
            $sql = "SELECT SUM( pd.inv_item_quantity ) AS qty, SUM( pd.inv_item_price * pd.item_quantity ) AS sale, SUM( (
                    pd.inv_item_price * ( pd.inv_item_discount /100 ) ) * pd.item_quantity
                    ) AS discount
                    FROM " . DB_PREFIX . "pos_invoice_detail AS pd
                    LEFT JOIN " . DB_PREFIX . "pos_invoice inv ON ( pd.inv_id = inv.invoice_id ) 
                    LEFT JOIN " . DB_PREFIX . "item i ON ( pd.inv_item_id = i.id ) 
                    WHERE pd.inv_item_id IN ( ".$item_id." ) 
                    AND inv.salesrep_id = ".$rep_id." ";
            // echo $sql;exit;
            $query = $this->db->query($sql);            
            return $query->rows;
    }
    public function sale_rep_report_rep_values($inv_id,$data) {
        $search_category = "";
        $search_product = "";
            if($data['category_id']!=''){
                $search_category = " AND i.category_id = '".$data['category_id']."'";
            }
            if(isset($data["product_id"]) && !empty($data["product_id"])){
                $search_product = " AND pd.inv_item_id = ".$data["product_id"]."";
            }
            $sql = "SELECT sum(pd.inv_item_quantity ) AS qty,
                sum( pd.inv_item_price*pd.item_quantity) AS sale,
                sum((pd.inv_item_price*(pd.inv_item_discount/100) )*pd.item_quantity) AS discount
                    FROM " . DB_PREFIX . "pos_invoice_detail AS pd
                    LEFT JOIN " . DB_PREFIX . "item i ON ( pd.inv_item_id = i.id )
                    WHERE pd.inv_id IN (".$inv_id.") ".$search_product." ".$search_category." ";
            // echo $sql;exit;
            $query = $this->db->query($sql);            
            return $query->rows;
        }
    public function sale_rep_report_item($item_id) {
            
            $this->db->query("SET group_concat_max_len=9999999"); 

            
            $sql = "SELECT id, item_name
                    FROM " . DB_PREFIX . "item
                    WHERE id IN (".$item_id.")";
            // echo $sql;exit;
            $query = $this->db->query($sql);            
            return $query->rows;
        }
       public function sale_rep_report_item_data($item_id,$rep_id,$data) {
            $date_range = "";
            $rep = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND inv.invoice_date>='". $start_date ."' AND inv.invoice_date < '". $end_date ."' + interval 1 day";
                }
            }
            
            $sql = "SELECT pd.inv_item_name as item_name, sum(pd.inv_item_quantity ) AS qty,
                sum( pd.inv_item_price*pd.item_quantity) AS sale,
                    sum((pd.inv_item_price*(pd.inv_item_discount/100) )*pd.item_quantity) AS discount
                    FROM " . DB_PREFIX . "pos_invoice_detail pd 
                    LEFT JOIN " . DB_PREFIX . "pos_invoice inv ON ( pd.inv_id = inv.invoice_id )
                    WHERE inv.salesrep_id = '".$rep_id."' AND pd.inv_item_id = ".$item_id." ".$date_range." ";
            // echo $sql;exit;
            $query = $this->db->query($sql);            
            return $query->rows;
        }
        
    public function sale_rep_units($item_id, $uom){
        
         $sql = "SELECT conv_from
                    FROM " . DB_PREFIX . "unit_mapping
                    WHERE item_id = ".$item_id." AND uom_id=".$uom." ";
         // echo $sql;
            $query = $this->db->query($sql); 
            if($query->num_rows>0){
               return $query->row['conv_from']; 
            } else {
               return '---'; 
            }
            
    }
    public function sale_user_report($data){
            $date_range = "";
            $search_category = "";
            $search_product = "";
            $search_rep = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND updated_date>='". $start_date ."' AND updated_date < '". $end_date ."' + interval 1 day";
                }
            }
            if($data['category_id']!=''){
                $search_category = " AND i.category_id = '".$data['category_id']."'";
            }
            if($data['user_id']!='-1'){
                $search_rep = " AND user_id = '".$data['user_id']."'";
            }
            if(isset($data["product_id"]) && !empty($data["product_id"])){
                $search_product = " AND pd.inv_item_id = '".$data["product_id"]."'";
            }
            $sql = "SELECT u.username,user_id, SUM(CASE WHEN `sale_return` = '0' THEN (`invoice_total`-`discount`) ELSE NULL END) AS `sale`, SUM(CASE WHEN `sale_return` = '1' THEN (`invoice_total`-`discount`) ELSE NULL END) AS `sale_return` FROM " . DB_PREFIX . "pos_invoice
                    LEFT JOIN " . DB_PREFIX . "siteusers u ON (pos_invoice.user_id=u.su_id)
                    WHERE invoice_status >= '2' ".$search_rep." ".$search_category." ".$search_product." ".$date_range." 
                    GROUP BY user_id";
                    // echo $sql;exit;
            $query = $this->db->query($sql);
            return $query->rows;
            
            
           

    }
        
    public function sale_user_item_report($data){
            $date_range = "";
            $search_category = "";
            $search_product = "";
            $search_rep = "";
            $ware_g = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND inv.updated_date>='". $start_date ."' AND inv.updated_date < '". $end_date ."' + interval 1 day";
                }
            }
            if($data['category_id']!=''){
                $search_category = " AND i.category_id = '".$data['category_id']."'";
            }
            if($data['user_id']!='-1'){
                $search_rep = " AND inv.user_id = '".$data['user_id']."'";
            }
            if(isset($data["product_id"]) && !empty($data["product_id"])){
                $search_product = " AND pd.inv_item_id = '".$data["product_id"]."'";
            }
            $sql = "SELECT sum( pd.inv_item_quantity * (pd.inv_item_price - (pd.inv_item_price * (pd.inv_item_discount/100) ) ) )
                    AS sale, pd.inv_id AS inv_id, su.username as user_name, su.su_id as user_id 
                    FROM " . DB_PREFIX . "pos_invoice_detail AS pd
                    LEFT JOIN " . DB_PREFIX . "pos_invoice inv ON ( pd.inv_id = inv.invoice_id )
                    LEFT JOIN " . DB_PREFIX . "item i ON ( pd.inv_item_id = i.id )
                    LEFT JOIN " . DB_PREFIX . "category c ON ( c.id = i.category_id )
                    LEFT JOIN " . DB_PREFIX . "siteusers su ON ( su.su_id = inv.user_id )
                    WHERE inv.invoice_status >= '2' AND inv.sale_return=0 ".$search_rep." ".$search_category." ".$search_product." ".$date_range." 
                    GROUP BY inv.salesrep_id";
            $query = $this->db->query($sql);
            return $query->rows;

    }  

        public function get_warehouse_items_qty($data)
        {
            $date_range = "";
            $search_category = "";
            $search_product = "";
            $search_rep = "";
            $ware_id="";
            if( isset($data["end_date"]) ){
                if(!empty($data["end_date"])){                   
                    $end_date = $data["end_date"];
                    if(isset($sdate)){
                        $date_range = " AND inv_date < '". $sdate ."'  + interval 1 day";
                    }
                    else{
                        $date_range = " AND inv_date < '". $end_date ."' + interval 1 day";
                    }
                }
            }
            if($data['category_id']!=''){
                $search_category = " AND i.category_id IN (".$data['category_id'].")";
            }
            
            if(isset($data["product_id"]) && !empty($data["product_id"])){
                $search_product = " AND item_id = '".$data["product_id"]."'";
            }
            if($data['warehouse'] !='-1')
            {
                 $ware_id = " AND iw.warehouse_id='".$data['warehouse']."'";
                 $ware_g=" GROUP BY iw.item_id order by iw.warehouse_id,c.id DESC";
            }
            else{
                $ware_id=" AND iw.warehouse_id !=''";
                $ware_g=" GROUP BY iw.warehouse_id,iw.item_id order by iw.warehouse_id,c.id DESC";
            }

            $sql = "SELECT  wh.warehouse_name AS w_name,sum(iw.qty*iw.conv_from) AS qty,i.item_name AS item_name,iw.item_id AS id,
                    c.name AS category,c.id AS category_id,i.id AS id,i.item_code AS item_code,i.avg_cost As avg_cost,i.sale_price AS sale_price
                     FROM ". DB_PREFIX . "item_warehouse iw 
                    LEFT JOIN " . DB_PREFIX . "item i ON ( iw.item_id = i.id )
                    LEFT JOIN " . DB_PREFIX . "category c ON (c.id=i.category_id)                     
                    LEFT JOIN " . DB_PREFIX . "warehouses wh ON (wh.warehouse_id=iw.warehouse_id)
                    WHERE i.item_status='1' AND type_id !='3'  ".$ware_id."   ".$search_rep." ".$search_category." ".$search_product." ".$date_range." ".$ware_g.",i.item_name ASC";
                      // echo $sql;exit;        
                      $query = $this->db->query($sql);
            return $query->rows;

        }

        public function get_last_convfrom($id)
        {
            $sql="SELECT  MAX(conv_from) AS conv_from FROM `unit_mapping` WHERE  item_id='$id'";
            // echo $sql;
             $query = $this->db->query($sql);

            $conv_from = $query->row['conv_from']==NULL ? 0 :$query->row['conv_from'];            
            return $conv_from;
        }
        
    
        public function get_purchase_items($item_id,$data,$sdate=null){
            $date_range = "";
            $search_category = "";
            $search_product = "";
            $search_warehouse = "";
            $search_rep = "";
               if( isset($data["end_date"]) ){
                if(!empty($data["end_date"])){                   
                    $end_date = $data["end_date"];
                    if(isset($sdate)){
                        $date_range = " AND iw.inv_date < '". $sdate ."'";
                    }
                    else{
                        $date_range = " AND iw.inv_date < '". $end_date ."' + interval 1 day";
                    }
                }
            }
            if($data['category_id']!='0' && $data['category_id']!=''){
                $search_category = " AND i.category_id = '".$data['category_id']."'";
            }
            
            // if(isset($data["product_id"]) && !empty($data["product_id"])){
            //     $search_product = " AND pd.inv_item_id = '".$data["product_id"]."'";
            // } 
            

            $sql = "SELECT  sum( iw.qty*iw.conv_from ) AS qty,w.warehouse_name AS w_name 
                    FROM ". DB_PREFIX . "item_warehouse AS iw
                    LEFT JOIN " . DB_PREFIX . "po_invoice inv ON ( iw.inv_id = inv.invoice_id )
                    LEFT JOIN " . DB_PREFIX . "item i ON ( iw.item_id = i.id )
                    LEFT JOIN " . DB_PREFIX . "category c ON ( c.id = i.category_id )                    
                    LEFT JOIN " . DB_PREFIX . "warehouses w ON ( w.warehouse_id = iw.warehouse_id )                    
                    WHERE i.id='".$item_id."'  ".$search_category." AND iw.invoice_type=4  ".$date_range." 
                    ";
             // echo $sql;exit;                 
            $query = $this->db->query($sql);

            $qty = $query->row['qty']==NULL ? 0 :$query->row['qty'];            
            return $qty;
        }
        
        public function get_purchase_items_interval($item_id,$data){
            $date_range = "";
            $search_category = "";
            $search_product = "";
            $search_rep = "";
            if( isset($data["end_date"]) ){
                if(!empty($data["end_date"])){                   
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    
                    $date_range = " AND inv.invoice_date>='". $start_date ."' AND inv.invoice_date < '". $end_date ."' + interval 1 day";
                    
                }
            }
            if($data['category_id']!='0'){
                $search_category = " AND i.category_id = '".$data['category_id']."'";
            }
            
            if(isset($data["product_id"]) && !empty($data["product_id"])){
                $search_product = " AND pd.inv_item_id = '".$data["product_id"]."'";
            }
            $sql = "SELECT sum( pd.inv_item_quantity ) 
                    AS qty 
                    FROM ". DB_PREFIX . "po_invoice_detail AS pd
                    LEFT JOIN " . DB_PREFIX . "po_invoice inv ON ( pd.inv_id = inv.invoice_id )
                    LEFT JOIN " . DB_PREFIX . "item i ON ( pd.inv_item_id = i.id )
                    LEFT JOIN " . DB_PREFIX . "category c ON ( c.id = i.category_id )                    
                    WHERE i.id='".$item_id."' AND inv.invoice_status >= '2' ".$search_rep." ".$search_category." ".$search_product." ".$date_range." 
                    ";            
            $query = $this->db->query($sql);
            $qty = $query->row['qty']==NULL ? 0 :$query->row['qty'];            
            return $qty;
        }



        public function get_open_qty($item_id,$data)
        {
            $inv_date =date('Y-m-d', strtotime($data['start_date']));
            $sql="SELECT SUM(qty*conv_from ) AS open_qty FROM " . DB_PREFIX . " item_warehouse WHERE item_id='$item_id' AND inv_date <'$inv_date' ";
            $query = $this->db->query($sql);
            $qty = $query->row['open_qty']==NULL ? 0 :$query->row['open_qty'];            
            return $qty;
        }
        
        public function get_sale_items($item_id,$data,$sdate=null){
            $date_range = "";
            $search_category = "";
            $search_product = "";
            $search_warehouse = "";
            $search_rep = "";

              if( isset($data["end_date"]) ){
                if(!empty($data["end_date"])){                   
                    $end_date = $data["end_date"];
                    if(isset($sdate)){
                        $date_range = " AND pdw.inv_date < '". $sdate ."'";
                    }
                    else{
                        $date_range = " AND pdw.inv_date < '". $end_date ."' + interval 1 day";
                    }
                }
            }
            if($data['category_id']!='0'){
                $search_category = " AND i.category_id = '".$data['category_id']."'";
            }
            
            if(isset($data["product_id"]) && !empty($data["product_id"])){
                $search_product = " AND pdw.item_id = '".$data["product_id"]."'";
            }
            if(isset($data["ware_id"]) && !empty($data["ware_id"])){
                $search_warehouse = " AND pdw.warehouse_id = '".$data["ware_id"]."'";
            }
            $sql = "SELECT sum( -1*pdw.qty*conv_from ) 
                AS qty 
                FROM ". DB_PREFIX . "item_warehouse AS pdw
                LEFT JOIN " . DB_PREFIX . "item i ON ( pdw.item_id = i.id )
                LEFT JOIN " . DB_PREFIX . "category c ON ( c.id = i.category_id )                    
                WHERE i.id='".$item_id."'  AND pdw.invoice_type  = '2' ".$search_rep."  ".$date_range." 
                ";
            // echo $sql;exit();
            $query = $this->db->query($sql);
            $qty = $query->row['qty']==NULL ? 0 :$query->row['qty'];
            return $qty;
        }
                
               
        
        public function get_inventory_items($data){
            $search_category = "";
            $search_product = "";
            $date_range ="";
            if($data['category_id']!=''){
                $search_category = " AND i.category_id = '".$data['category_id']."'";
            }

            if( isset($data["end_date"]) ){
                if(!empty($data["end_date"])){                                       
                    $end_date = $data["end_date"];                    
                    $date_range = " AND i.added_date <'". $data['end_date'] ."' + interval 1 day";                    
                }
            }
            if(isset($data["product_id"]) && !empty($data["product_id"])){
                $search_product = " AND i.id = '".$data["product_id"]."'";
            } 
            //   if(isset($data["warehouse"]) && !empty($data["warehouse"])){
            //     $search_product = " AND i.id = '".$data["warehouse"]."'";
            // }

               if($data['units']==0)
               {
                $sql = "SELECT i.*,c.name as category,c.id as category_id,m.unit_id AS unit,m.sale_price AS m_price, u.name AS u_name,u.id AS u_id
                     FROM item i LEFT JOIN category c ON ( c.id = i.category_id ) LEFT JOIN unit_mapping m ON (i.id=m.item_id AND i.unit=m.unit_id) LEFT JOIN units u ON (m.unit_id=u.id)
                    WHERE i.item_status='1' ". $search_category. $search_product . $date_range." ORDER BY c.id ASC";   
               }          
            // $sql = "SELECT i.*,c.name as category,c.id as cat_id FROM " . DB_PREFIX . "item i
            //         LEFT JOIN " . DB_PREFIX . "category c ON ( c.id = i.category_id )
            //         WHERE i.item_status='1' ". $search_category. $search_product . $date_range." ORDER BY c.id"; 
                else{
                     $sql = "SELECT i.*,c.name as category,c.id as category_id ,u.id AS u_id,u.name AS u_name,
                            m.avg_cost AS p_price,m.sale_price AS m_price,m.unit_id AS unit,(i.avg_cost*m.conv_from)AS avg_cost_tot,m.conv_from AS convt_qty
                            FROM item i LEFT JOIN category c ON ( c.id = i.category_id )  LEFT JOIN unit_mapping m ON (i.id=m.item_id AND i.purchase_unit=m.unit_id) 
                            LEFT JOIN units u ON (m.unit_id=u.id)
                    WHERE  i.item_status='1' ". $search_category. $search_product . $date_range." ORDER BY c.name DESC";
                }           
            

            // echo $sql;exit();
            $query = $this->db->query($sql);
            return $query->rows;
        }


           public function get_inventory_items_units($data){
            $search_category = "";
            $search_product = "";
            $date_range ="";
            $start_date ="";
            $end_date ="";
              if( isset($data["end_date"]) ){
                if(!empty($data["end_date"])){                   
                    $end_date =date('Y-m-d', strtotime($data['end_date']));
                    $date_range = " AND iw.inv_date <'". $end_date."' + interval 1 day"; 
                }
            }
            if($data['category_id']!=''){
                $search_category = " AND i.category_id = '".$data['category_id']."'";
            }

            if(isset($data["product_id"]) && !empty($data["product_id"])){
                $search_product = " AND i.id = '".$data["product_id"]."'";
            }

               if($data['units']==0)
               {
                $sql = "SELECT SUM(iw.qty*iw.conv_from) AS qty, i.item_name,i.item_code,i.avg_cost,i.sale_price,c.name as category,um.sale_price AS m_price, u.name AS u_name,w.warehouse_name FROM item_warehouse iw LEFT JOIN item i ON ( i.id = iw.item_id )
                    LEFT JOIN category c ON (c.id=i.category_id)
                    LEFT JOIN unit_mapping um on (i.id=um.item_id AND i.unit=um.unit_id) LEFT JOIN units u on (u.id=um.unit_id)
                    LEFT JOIN warehouses w ON (w.warehouse_id=iw.warehouse_id)
                    WHERE i.item_status='1' ". $search_category. $search_product . $date_range." GROUP BY iw.item_id,iw.warehouse_id order by iw.warehouse_id,i.category_id DESC,i.item_name ASC";   
               }          
                else{
                     $sql = "SELECT SUM((iw.qty*iw.conv_from)/um.conv_from) AS qty, i.item_name,i.item_code,(i.avg_cost*um.conv_from) AS avg_cost,(i.sale_price*um.conv_from) AS sale_price,c.name as category, u.name AS u_name,w.warehouse_name FROM item_warehouse iw LEFT JOIN item i ON ( i.id = iw.item_id ) LEFT JOIN category c ON (c.id=i.category_id) LEFT JOIN unit_mapping um on (i.id=um.item_id AND i.purchase_unit=um.unit_id) LEFT JOIN units u on (u.id=um.unit_id) LEFT JOIN warehouses w ON (w.warehouse_id=iw.warehouse_id) WHERE i.item_status='1' ". $search_category. $search_product . $date_range."  GROUP BY iw.item_id,iw.warehouse_id order by iw.warehouse_id,i.category_id DESC,i.item_name ASC";
                }           
            

            // echo $sql;exit();
            $query = $this->db->query($sql);
            return $query->rows;
        }



        
        public function get_inventory_items_lowstock($data){
            $search_category = "";
            $search_product = "";
            
            if($data['category_id']!='0' && !empty($data['category_id'])){
                $search_category = " AND i.category_id = '".$data['category_id']."'";
            }
            
            if(isset($data["product_id"]) && !empty($data["product_id"])){
                $search_product = " AND i.id = '".$data["product_id"]."'";
            }
                        
            $sql = "SELECT SUM(iw.qty*iw.conv_from) AS qty ,iw.warehouse_id As ware,i.item_name,c.name as category,c.id as cat_id,w.warehouse_name,i.reorder_point,
                    i.sale_price,i.avg_cost,i.id
                 FROM item_warehouse iw LEFT JOIN item i ON ( i.id = iw.item_id ) LEFT JOIN category c ON ( c.id = i.category_id )
            LEFT JOIN warehouses w ON ( w.warehouse_id = iw.warehouse_id )
            WHERE i.item_status='1'  ".$search_category." ".$search_product."
                    GROUP BY i.category_id,i.id,iw.warehouse_id ";            
            // echo $sql;exit;
            $query = $this->db->query($sql);
            return $query->rows;
        }
        
        public function set_inventory($qty,$id){
             $this->db->query("UPDATE " . DB_PREFIX . "item SET quantity=".$qty." WHERE id=".$id);
        }
        public function getCustomers($data){
            $search_customer = "";
            $over_limit = "";
            
            if($data['customer_id']!='-1'){
                $search_customer = " AND cust.cust_id = '".$data['customer_id']."'";
            }
            if($data['customer_region']!='-1'){                
                $search_customer = " AND cust.cust_group_id = '".$data['customer_region']."'";
            }
            if($data['over_limit_detail']!='0' && $data['over_limit_detail']!='')
            {
                $over_limit="HAVING SUM(j.journal_amount) > cust.cust_credit_limit  AND cust.cust_credit_limit !=0";
            }
            
            $sql = "SELECT cust.cust_name AS cust_name,cust.cust_mobile AS cust_mobile,cust.cust_phone AS cust_phone,
                    cgroup.cust_group_name as cust_region,cust.cust_credit_limit AS cradit_limit,cust.cust_acc_id AS acc_id,
                    sum(j.journal_amount) AS balance
                    FROM " . DB_PREFIX . "customer AS cust
                    LEFT JOIN " . DB_PREFIX . "customer_groups cgroup ON ( cust.cust_group_id = cgroup.id ) 
                     LEFT JOIN " . DB_PREFIX . " account_journal j ON(j.acc_id=cust.cust_acc_id)
                    WHERE cust.cust_status='1' AND cust.cust_id !='0' ".$search_customer."  GROUP BY cust.cust_id ".$over_limit." ORDER BY cgroup.id ";
            // echo $sql;exit;
            $query = $this->db->query($sql);
            return $query->rows;
        }
        
        public function getVendors($data){
            $date_range = "vendor_id>0 ";
            $search_vendor = "";
                        
            if($data['vendor_id']!='-1'){
                $search_vendor = " AND vendor_id = '".$data['vendor_id']."'";
            }
                        
            $sql = "SELECT *                  
                    FROM " . DB_PREFIX . "vendor
                    WHERE ".$date_range." ".$search_vendor."
                    ORDER BY vendor_name";
            
            //echo $sql;
            $query = $this->db->query($sql);
            return $query->rows;
        }
        public function getSaleCustomer($data){
            $date_range = "";
            $search_customer = "";
            $search_type = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND inv.invoice_date>='". $start_date ."' AND inv.invoice_date < '". $end_date ."' + interval 1 day";
                }
            }
            if($data['customer_id']!='-1'){
                $search_customer = " AND inv.cust_id = '".$data['customer_id']."'";
            }
            if($data['customer_region']!='-1'){                
                $search_customer = " AND cust.cust_group_id = '".$data['customer_region']."'";
            }
            
            if(isset($data["invoice_type"]) && !empty($data["invoice_type"])){
                $search_type = " AND inv.invoice_type = '".$data["invoice_type"]."'";
            }
            $sql = "SELECT sum( inv.invoice_total) - sum(inv.discount) AS amount,
                    cust.cust_id AS cust_id, cust.cust_name AS cust_name,
                    cgroup.cust_group_name as group_name
                    FROM " . DB_PREFIX . "pos_invoice AS inv
                    LEFT JOIN " . DB_PREFIX . "customer cust ON ( cust.cust_id = inv.cust_id )
                    LEFT JOIN " . DB_PREFIX . "customer_groups cgroup ON ( cust.cust_group_id = cgroup.id )
                    WHERE inv.invoice_status >= '2' AND inv.sale_return=0 ".$search_customer." ".$search_type." ".$date_range." 
                    GROUP BY inv.cust_id";
            
            
            
            
            $query = $this->db->query($sql);
            return $query->rows;
        }
        public function get_sale_customer($data){
            $date_range = "";
            $search_customer = "";
            $search_type = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND inv.updated_date>='". $start_date ."' AND inv.updated_date < '". $end_date ."' + interval 1 day";
                }
            }
            if($data['customer_id']!='-1'){
                $search_customer = " AND inv.cust_id = '".$data['customer_id']."'";
            }
            if($data['customer_region']!='-1'){                
                $search_customer = " AND cust.cust_group_id = '".$data['customer_region']."'";
            }
            
            if(!empty($data["invoice_type"]) && $data['invoice_type']!='-1'){
                $search_type = " AND inv.invoice_type = '".$data["invoice_type"]."'";
            }

                if($data['cust_saleDetail']==0)
                {
                    $sql = "SELECT sum( inv.invoice_total) AS amount,
                    cust.cust_id AS cust_id, cust.cust_name AS cust_name,
                    cgroup.cust_group_name as group_name,inv.invoice_date AS bill_date
                    FROM " . DB_PREFIX . "pos_invoice AS inv
                    LEFT JOIN " . DB_PREFIX . "customer cust ON ( cust.cust_id = inv.cust_id )
                    LEFT JOIN " . DB_PREFIX . "customer_groups cgroup ON ( cust.cust_group_id = cgroup.id )
                    WHERE inv.invoice_status >= '2' AND inv.sale_return=0 ".$search_customer." ".$search_type." ".$date_range." 
                    GROUP BY inv.cust_id";
                }   
                else{
                    $sql = "SELECT sum( inv.invoice_total) AS amount,
                    cust.cust_id AS cust_id, cust.cust_name AS cust_name,
                    cgroup.cust_group_name as group_name,inv.invoice_date AS bill_date
                    FROM " . DB_PREFIX . "pos_invoice AS inv
                    LEFT JOIN " . DB_PREFIX . "customer cust ON ( cust.cust_id = inv.cust_id )
                    LEFT JOIN " . DB_PREFIX . "customer_groups cgroup ON ( cust.cust_group_id = cgroup.id )
                    WHERE inv.invoice_status >= '2' AND inv.sale_return=0 ".$search_customer." ".$search_type." ".$date_range." 
                    GROUP BY inv.cust_id,inv.invoice_date";
                }     
            
            
            
            
            
            $query = $this->db->query($sql);
            return $query->rows;
        }
        
        
        public function get_sale_customer_item($data){
            $date_range = "";
            $search_customer = "";
            $search_type = "";
            $search_category = "";
            $search_product = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND inv.updated_date>='". $start_date ."' AND inv.updated_date < '". $end_date ."' + interval 1 day";
                }
            }
            if($data['customer_id']!='-1'){
                $search_customer = " AND inv.cust_id = '".$data['customer_id']."'";
            }
            if($data['customer_region']!='-1'){                
                $search_customer = " AND cust.cust_group_id = '".$data['customer_region']."'";
            }
            if($data['category_id']!=''){
                $search_category = " AND i.category_id = '".$data['category_id']."'";
            }
            
            if(isset($data["product_id"]) && !empty($data["product_id"])){
                $search_product = " AND i.id = '".$data["product_id"]."'";
            }
            
            if(isset($data["invoice_type"]) && !empty($data["invoice_type"])){
                $search_type = " AND inv.invoice_type = '".$data["invoice_type"]."'";
            }
            
            // $sql = "SELECT sum( inv.invoice_total) - sum(inv.discount)AS amount,
            //         cust.cust_id AS cust_id,cust.cust_name AS cust_name,
            //         cgroup.cust_group_name as group_name,
            //         ctype.cust_type_name as cust_type
            //         FROM " . DB_PREFIX . "pos_invoice AS inv
            //         LEFT JOIN " . DB_PREFIX . "customer cust ON ( cust.cust_id = inv.cust_id )
            //         LEFT JOIN " . DB_PREFIX . "customer_groups cgroup ON ( cust.cust_group_id = cgroup.id )                                         
            //         LEFT JOIN " . DB_PREFIX . "customer_types ctype ON ( cust.cust_type_id = ctype.id )
            //         WHERE inv.invoice_status >= '2' AND inv.sale_return=0 ".$search_customer." ".$search_category." ".$search_product." ".$date_range." 
            //         GROUP BY inv.cust_id";

                             $sql = "SELECT sum( inv.invoice_total) AS amount,
                    cust.cust_id AS cust_id,cust.cust_name AS cust_name,
                    cgroup.cust_group_name as group_name,
                    ctype.cust_type_name as cust_type
                    FROM " . DB_PREFIX . "pos_invoice AS inv
                    LEFT JOIN " . DB_PREFIX . "customer cust ON ( cust.cust_id = inv.cust_id )
                    LEFT JOIN " . DB_PREFIX . "customer_groups cgroup ON ( cust.cust_group_id = cgroup.id )                                         
                    LEFT JOIN " . DB_PREFIX . "customer_types ctype ON ( cust.cust_type_id = ctype.id )
                    WHERE inv.invoice_status >= '2' AND inv.sale_return=0 ".$search_customer." ".$search_category." ".$search_product." ".$date_range." 
                    GROUP BY inv.cust_id";
            
             // echo $sql;
           
            
            $query = $this->db->query($sql);
            return $query->rows;
        }
        public function get_sale_item_customer_item($data){
            $date_range = "";
            $search_customer = "";
            $search_type = "";
            $search_category = "";
            $search_product = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND inv.updated_date>='". $start_date ."' AND inv.updated_date < '". $end_date ."' + interval 1 day";
                }
            }
            if($data['customer_id']!='-1'){
                $search_customer = " AND inv.cust_id = '".$data['customer_id']."'";
            }
            if($data['customer_region']!='-1'){                
                $search_customer = " AND cust.cust_group_id = '".$data['customer_region']."'";
            }
            if($data['category_id']!=''){
                $search_category = " AND i.category_id = '".$data['category_id']."'";
            }
            
            if(isset($data["product_id"]) && !empty($data["product_id"])){
                $search_product = " AND i.id = '".$data["product_id"]."'";
            }
            
            if($data["invoice_type"] !='-1'){
                $search_type = " AND inv.invoice_type = '".$data["invoice_type"]."'";
            }
            
            $sql = "SELECT cust.cust_id AS cust_id,cust.cust_name AS cust_name, sum(inv_det.inv_item_price*inv_det.inv_item_quantity )- sum((inv_det.inv_item_price*(inv_det.inv_item_discount/100) )*inv_det.inv_item_quantity) AS amount, cgroup.cust_group_name as group_name,ctype.cust_type_name as cust_type                    
                    FROM " . DB_PREFIX . "pos_invoice_detail AS inv_det                    
                    LEFT JOIN " . DB_PREFIX . "pos_invoice inv ON ( inv.invoice_id = inv_det.inv_id )                                            
                    LEFT JOIN " . DB_PREFIX . "customer cust ON ( cust.cust_id = inv.cust_id )                    
                    LEFT JOIN " . DB_PREFIX . "customer_groups cgroup ON ( cust.cust_group_id = cgroup.id )                  
                    LEFT JOIN " . DB_PREFIX . "item i ON ( i.id = inv_det.inv_item_id )                                                
                    LEFT JOIN " . DB_PREFIX . "customer_types ctype ON ( cust.cust_type_id = ctype.id )                    
                    WHERE inv.invoice_status >= '2' AND sale_return=0 ".$search_customer." ".$search_type." ".$date_range." ".$search_product." ".$search_category." 
                    GROUP BY cgroup.id,inv.cust_id";
            // echo $sql;exit;
            $query = $this->db->query($sql);
            return $query->rows;
        }
        
        
        public function get_purchase_items_val($item_id,$data){
            $date_range = "";
            $search_category = "";
            $search_product = "";
            $search_rep = "";
              if( isset($data["end_date"])){
                if(!empty($data["end_date"])){                   
                    $end_date = $data["end_date"];
                    $start_date = $data["start_date"];
                    $date_range = " AND inv.invoice_date < '". $end_date ."' + interval 1 day";
                }
            }
            if($data['category_id']!='0'){
                $search_category = " AND i.category_id = '".$data['category_id']."'";
            }
            
            if(isset($data["product_id"]) && !empty($data["product_id"])){
                $search_product = " AND pd.inv_item_id = '".$data["product_id"]."'";
            }
            $sql = "SELECT sum( pd.inv_item_quantity ) 
                    AS qty , max(inv.invoice_date) as date
                    FROM ". DB_PREFIX . "po_invoice_detail AS pd
                    LEFT JOIN " . DB_PREFIX . "po_invoice inv ON ( pd.inv_id = inv.invoice_id )
                    LEFT JOIN " . DB_PREFIX . "item i ON ( pd.inv_item_id = i.id )
                    LEFT JOIN " . DB_PREFIX . "category c ON ( c.id = i.category_id )                    
                    WHERE i.id='".$item_id."' AND inv.invoice_status >= '2' ".$search_rep." ".$search_category." ".$search_product." ".$date_range." 
                    ";            
            //echo $sql;
            $query = $this->db->query($sql);            
            $qty = $query->row['qty']==NULL ? 0 :$query->row['qty'];
            return $qty;
        }
        public function get_adjust_items($item_id,$data,$sdate=null){
            $date_range = "";
            $search_product = "";
                  if( isset($data["end_date"]) ){
                if(!empty($data["end_date"])){                   
                    $end_date = $data["end_date"];                 
                    if(isset($sdate)){
                        $date_range = " AND inv_date < '". $end_date ."' + interval 1 day";
                    }
                    else{
                        $date_range = " AND inv_date< '". $end_date ."' + interval 1 day";
                    }
                }
            }
            if(isset($data["product_id"]) && !empty($data["product_id"])){
                $search_product = " AND item_id = '".$data["product_id"]."'";
            }
               if(isset($data["ware_id"]) && !empty($data["ware_id"])){
                $search_warehouse = " AND warehouse_id = '".$data["ware_id"]."'";
            }

            $sql = "SELECT sum( qty*conv_from ) 
                AS qty 
                FROM ". DB_PREFIX . "item_warehouse                            
                WHERE item_id='".$item_id."' ".$search_product." AND invoice_type=7 ".$date_range;
            // echo $sql;exit;
            $query = $this->db->query($sql);
            $qty = $query->row['qty']==NULL ? 0 :$query->row['qty'];
            return $qty;
        }
        
        //   public function get_unit_items($item_id,$data,$sdate=null){
        //     $date_range = "";
        //     $search_product = "";
        //     if( isset($data["end_date"]) ){
        //         if(!empty($data["end_date"])){                   
        //             $end_date = $data["end_date"];                 
        //             if(isset($sdate)){
        //                 $date_range = " AND updated_date < '". $end_date ."' + interval 1 day";
        //             }
        //             else{
        //                 $date_range = " AND updated_date< '". $end_date ."' + interval 1 day";
        //             }
        //         }
        //     }
        //     if(isset($data["product_id"]) && !empty($data["product_id"])){
        //         $search_product = " AND item_id = '".$data["product_id"]."'";
        //     }
        //     $sql = "SELECT conv_from 
        //         AS conv_qty 
        //         FROM ". DB_PREFIX . "unit_mapping                            
        //         WHERE conv_from>1 AND item_id='".$item_id."' ".$search_product." ".$date_range;
        //     // echo $sql;exit;
        //     $query = $this->db->query($sql);
        //     $qty = $query->row['conv_from'];
        //     return $qty;
        // }
        
        
        
        public function get_sale_items_val($item_id,$data){
            $date_range = "";
            $search_category = "";
            $search_product = "";
            $search_rep = "";
            if( isset($data["end_date"]) ){
                if(!empty($data["end_date"]) && !empty($data["start_date"])){                   
                    $end_date = $data["end_date"];
                    $start_date = $data["start_date"];
                    $date_range = " AND inv.invoice_date>='". $start_date ."' AND  inv.invoice_date < '". $end_date ."' + interval 1 day";
                }
            }
            if($data['category_id']!='0'){
                $search_category = " AND i.category_id = '".$data['category_id']."'";
            }
            
            if(isset($data["product_id"]) && !empty($data["product_id"])){
                $search_product = " AND pd.inv_item_id = '".$data["product_id"]."'";
            }
            $sql = "SELECT sum( pd.inv_item_quantity ) 
                AS qty , max(inv.invoice_date) as date
                FROM ". DB_PREFIX . "pos_invoice_detail AS pd
                LEFT JOIN " . DB_PREFIX . "pos_invoice inv ON ( pd.inv_id = inv.invoice_id )
                LEFT JOIN " . DB_PREFIX . "item i ON ( pd.inv_item_id = i.id )
                LEFT JOIN " . DB_PREFIX . "category c ON ( c.id = i.category_id )                    
                WHERE i.id='".$item_id."'  AND inv.invoice_status >= '2' ".$search_rep." ".$search_category." ".$search_product." ".$date_range." 
                ";
            
            $query = $this->db->query($sql);
            $qty = $query->row;
            return $qty;
        }
        
        public function get_valuation_detail($item_id,$data){
            $date_range = "";
            if( isset($data["end_date"]) && isset($data["start_date"]) ){
                if(!empty($data["end_date"])){                   
                    $end_date = $data["end_date"];
                    $start_date = $data["start_date"];
                    $date_range = " AND entry_date>='". $start_date ."' AND  entry_date< '". $end_date ."' + interval 1 day";
                }
            }
            $sql = "SELECT * FROM " . DB_PREFIX . "account_journal                     
                    WHERE item_id='".$item_id."'". $date_range." and type!='CUST_OB' and type!='VEND_OB' GROUP BY inv_id,item_id ORDER BY entry_date ASC";                         
            // echo $sql;exit;
            $query = $this->db->query($sql);
            return $query->rows;
        }
        public function get_cust_name($inv_id){
            $id = $inv_id*-1;
            $sql = "SELECT c.cust_name AS cust_name FROM " . DB_PREFIX . "customer as c 
                    LEFT JOIN " . DB_PREFIX . "pos_invoice inv ON ( c.cust_id = inv.cust_id ) WHERE inv.invoice_id='".$id."'";
                    // echo $sql;exit;                         
          
            $query = $this->db->query($sql);
            return $query->row['cust_name'];
        }
        public function get_vend_name($inv_id){
            $id = $inv_id;
            $sql = "SELECT v.vendor_name AS vendor_name FROM " . DB_PREFIX . "vendor as v 
                    LEFT JOIN " . DB_PREFIX . "po_invoice inv ON ( v.vendor_id = inv.vendor_id ) WHERE inv.invoice_id='".$id."'";                         
            // echo $sql;exit;
            $query = $this->db->query($sql);
            return $query->row['vendor_name'];
        }
        public function get_item_qty($item_id,$ware_id){
             $search_warehouse="";
                if(isset($ware_id) && $ware_id!='-1'){
                $search_warehouse = " AND warehouse_id = '".$ware_id."'";
            }
            $sql = "SELECT  SUM(qty) AS quantity                  
                FROM ". DB_PREFIX . "item_warehouse                            
                WHERE item_id='".$item_id."' ".$search_warehouse." AND invoice_type='6'";
            // echo $sql;exit;
            $query = $this->db->query($sql);
            $qty = $query->row['quantity']==NULL ? 0 :$query->row['quantity'];
            return $qty;
        }
        public function get_so_qty($so_id,$item_id,$ware_id){
            $search_warehouse="";
                if(isset($ware_id) && $ware_id!='-1'){
                $search_warehouse = " AND pid.warehouse_id = '".$ware_id."'";
            }
            $sql = "SELECT  sum(inv_item_quantity) as qty                 
                FROM ". DB_PREFIX . "pos_invoice_detail as pid    
                LEFT JOIN " . DB_PREFIX . "pos_invoice inv ON ( pid.inv_id = inv.invoice_id )
                WHERE pid.inv_id='".$so_id."' AND pid.inv_item_id='".$item_id."' ".$search_warehouse."  AND inv.invoice_status >= '2'";
            // echo $sql;exit;
            $query = $this->db->query($sql);
            $qty = $query->row['qty']==NULL ? 0 :$query->row['qty'];
            return $qty;
        }
        public function get_po_qty($po_id,$item_id,$ware_id){
            $search_warehouse="";
                if(isset($ware_id) && $ware_id!='-1'){
                $search_warehouse = " AND pid.warehouse_id = '".$ware_id."'";
            }
            $sql = "SELECT  sum(inv_item_quantity) as qty                 
                FROM ". DB_PREFIX . "po_invoice_detail as pid         
                LEFT JOIN " . DB_PREFIX . "po_invoice inv ON ( pid.inv_id = inv.invoice_id )
                WHERE pid.inv_id='".$po_id."' AND pid.inv_item_id='".$item_id."' ".$search_warehouse."";
                // echo $sql;exit;
                // WHERE pid.inv_id='".$po_id."' AND pid.inv_item_id='".$item_id."' AND inv.invoice_status>='2'";
            
            $query = $this->db->query($sql);
            $qty = $query->row['qty']==NULL ? 0 :$query->row['qty'];
            return $qty;
        }
        
        public function get_po_cost($po_id,$item_id){
            $sql = "SELECT  (item_quantity*inv_item_price) as inv_item_price                
                FROM ". DB_PREFIX . "po_invoice_detail as pid         
                LEFT JOIN " . DB_PREFIX . "po_invoice inv ON ( pid.inv_id = inv.invoice_id )
                WHERE pid.inv_id='".$po_id."' AND pid.inv_item_id='".$item_id."'";
                // WHERE pid.inv_id='".$po_id."' AND pid.inv_item_id='".$item_id."' AND inv.invoice_status>='2'";
            // echo $sql;
            $query = $this->db->query($sql);
            $price = $query->row['inv_item_price']==NULL ? 0 :$query->row['inv_item_price'];
            return $price;
        }
        
        public function get_adjust_qty($adjst_id,$item_id,$ware_id){
               // $sql = "SELECT  qty                 
               //  FROM ". DB_PREFIX . "stock_adjust                       
               //  WHERE item_id='".$item_id."' GROUP BY adjust_id";
             $search_warehouse="";
                if(isset($ware_id) && !empty($ware_id) && $ware_id!='-1'){
                $search_warehouse = " AND w.warehouse_id = '".$ware_id."'";
            }
            $sql = "SELECT  qty AS qty                
                FROM ". DB_PREFIX . "stock_adjust                 
                WHERE adjust_id='".$adjst_id."' AND item_id='".$item_id."' ".$search_warehouse."";
            // echo $sql;
            $query = $this->db->query($sql);
            $qty = 0;
            if($query->num_rows){
                $qty = $query->row['qty']==NULL ? 0 :$query->row['qty'];
            }
            return $qty;
        }
        
        public function updateAvgCost($item_id,$date)
        {            
            $sql = "SELECT pd.inv_item_quantity as qty,pd.inv_item_price as price,inv.invoice_date as p_date,inv.invoice_id as inv_id FROM ".DB_PREFIX."po_invoice_detail as pd
                    LEFT JOIN " . DB_PREFIX . "po_invoice inv ON ( pd.inv_id = inv.invoice_id )
                    WHERE  pd.inv_item_id='".$item_id."' AND inv.invoice_date <'". $date ."' + interval 1 day";
            
            $query = $this->db->query($sql);
            $record = $query->rows;            
            $query = $this->db->query("SELECT quantity,avg_cost,normal_price FROM ".DB_PREFIX."item WHERE id='".$item_id."'");
            $r_count = $query->row['quantity']==NULL?0:$query->row['quantity'];
            $avg_rate = $query->row['normal_price'];
            $purchase_count = $r_count;            
            $query = $this->db->query("SELECT sum(qty) as qty FROM ".DB_PREFIX."stock_adjust WHERE item_id='".$item_id."' AND updated_date <'". $date ."' + interval 1 day");
            $adjust_qty = $query->row['qty']==NULL?0:$query->row['qty'];
            $purchase_count = $r_count +$adjust_qty;
            if(count($record)){
                for ($c=0; $c<count($record); $c++){                                
                    $query = $this->db->query("SELECT sum(pid.inv_item_quantity) as qty FROM ".DB_PREFIX."pos_invoice_detail pid
                              LEFT JOIN ".DB_PREFIX."pos_invoice p ON (p.invoice_id = pid.inv_id)  
                              WHERE pid.inv_item_id='".$item_id."' AND p.last_po_id<'".$record[$c]["inv_id"]."'  AND p.invoice_date <'". $date ."' + interval 1 day");
                    $sold=$query->row['qty']==NULL?0:$query->row['qty'];
                    $r = $purchase_count - $sold;
                    if(($r+$record[$c]["qty"])>0){
                     $avg_rate = ($r*$avg_rate + $record[$c]["qty"]*$record[$c]["price"])/($r+$record[$c]["qty"]);
                    }
                    $purchase_count = $purchase_count+$record[$c]["qty"];
                }            
            }
            else{
                $query = $this->db->query("SELECT avg_cost,normal_price FROM ".DB_PREFIX."item WHERE id='".$item_id."'");
                $avg_rate = $query->row['avg_cost']?$query->row['avg_cost']:$query->row['normal_price'];
            }
            return $avg_rate;            
        }

        public function get_openStockPrice($item_id,$start_date,$end_date)
        {
            $sql="SELECT COUNT(journal_id), journal_amount FROM account_journal  WHERE  item_id='".$item_id."' AND type='E' AND entry_date >='". $start_date ."' AND entry_date <'".$end_date."' + interval 1 day";
            // echo $sql;exit;
            $query = $this->db->query($sql);
            return $qty = $query->row['journal_amount']==NULL ? 0 :$query->row['journal_amount'];
        }

        public function get_AdjustStockPrice($item_id,$inv_id,$start_date,$end_date)
        {
            $sql="SELECT COUNT(journal_id), journal_amount FROM account_journal  WHERE  item_id='".$item_id."' AND type='A' AND inv_id='".$inv_id."' AND entry_date >='". $start_date ."' AND entry_date <'".$end_date."' + interval 1 day";
            // echo $sql;
            $query = $this->db->query($sql);
            return $qty = $query->row['journal_amount']==NULL ? 0 :$query->row['journal_amount'];
        }

        public function get_PriceByInvoice($inv_id,$item_id)
        {
             $sql="SELECT COUNT(pos_idx), item_purchase_price AS price FROM pos_invoice_detail  WHERE  inv_id='".-1*$inv_id."' AND item_id='".$item_id."'";
            // echo $sql;
            $query = $this->db->query($sql);
            return $qty = $query->row['price']==NULL ? 0 :$query->row['price'];
        }
           public function get_PriceByPOInvoice($item_id)
        {
             $sql="SELECT * FROM `po_invoice_detail` WHERE  inv_item_id='".$item_id."' ORDER BY `inv_id` ASC LIMIT 1 ";
            // echo $sql;
            $query = $this->db->query($sql);
            return $query->row;
        }

               public function get_PriceByPORetInvoice($item_id,$inv_id)
        {
             $sql="SELECT po.*,p.invoice_id FROM `po_invoice_detail` po LEFT JOIN po_invoice p ON p.invoice_id=po.inv_id WHERE po.inv_item_id='".$item_id."' AND po.inv_id='".$inv_id."' AND p.invoice_status=2 ORDER BY po.inv_id DESC LIMIT 1";
            // echo $sql;exit;
            $query = $this->db->query($sql);
            return $query->row;
        }
        
        public function get_account_receivable($data,$walkInCustomer=false,$cust_status=false){
            $date_range = " 1 ";
            if($walkInCustomer==false){
                $date_range = " cust.cust_id>0 ";
            }
            if($cust_status==true){
                $date_range .= " AND cust.cust_status=1 ";
            }
            $search_customer = "";
            $search_customer_type = "";
            $search_customer_group = "";
            $order="";
            
            if($data['customer_id']!='-1' AND $data['customer_id']!='All'){
                $search_customer = " AND cust.cust_id = '".$data['customer_id']."'";
            }
            if($data['customer_type']!='-1'){
                $search_customer_type = " AND cust.cust_type_id = '".$data['customer_type']."'";
            }
            if($data['customer_region']!='-1'){
                $search_customer_group = " AND cust.cust_group_id = '".$data['customer_region']."'";
                $order="ORDER BY cust.cust_group_id,cust.cust_name,cust.order_no ASC";
            }
            else{
                $order="ORDER BY cust.cust_group_id,cust.cust_name ASC";
            }
            
            $sql = "SELECT cust.cust_id AS cust_id,cust.cust_name AS cust_name,cust.cust_mobile AS cust_mobile,cust.cust_type_id, cust.cust_group_id, cust.cust_acc_id,                   
                    cgroup.cust_group_name as group_name, ctype.cust_type_name as type_name, acc_Chart.opening_balance as opening_balance, cust.cust_credit_limit AS cust_credit_limit
                    FROM " . DB_PREFIX . "customer AS cust                    
                    INNER JOIN " . DB_PREFIX . "customer_groups cgroup ON ( cust.cust_group_id = cgroup.id )                    
                    INNER JOIN " . DB_PREFIX . "customer_types ctype ON ( cust.cust_type_id = ctype.id )
                    INNER JOIN " . DB_PREFIX . "account_chart acc_Chart ON ( cust.cust_acc_id = acc_Chart.acc_id )
                    WHERE ".$date_range." ".$search_customer." ".$search_customer_type." ".$search_customer_group." ".$order." 
                    ";
            
            //echo $sql;exit;
            $query = $this->db->query($sql);
            return $query->rows;
            
        }
        
        public function get_account_payable($data){
            $date_range = "vendor_id>0";
            $search_vendor = "";
                        
            if($data['vendor_id']!='-1' && $data['vendor_id']!='All'){
                $search_vendor = " AND vendor_id = '".$data['vendor_id']."'";
            }
                        
            $sql = "SELECT *                  
                    FROM " . DB_PREFIX . "vendor
                    WHERE ".$date_range." ".$search_vendor."
                    ";
            
            // echo $sql;exit;
            $query = $this->db->query($sql);
            return $query->rows;
            
        }
        public function get_vendor_payment($data){
            $date_range = "vendor_id>0 ";
            $search_vendor = "";
            if( isset($data["end_date"]) ){
                if(!empty($data["end_date"]) && !empty($data["start_date"])){                   
                    $end_date = $data["end_date"];
                    $start_date = $data["start_date"];
                    $date_range = " AND acc.entry_date>='". $start_date ."' AND  acc.entry_date < '". $end_date ."' + interval 1 day";
                }
            }           
            if($data['vendor_id']!='-1'){
                $search_vendor = " AND vend.vendor_id = '".$data['vendor_id']."'";
            }
                        
             $sql = "SELECT vend.*, acc.*                 
                    FROM " . DB_PREFIX . "vendor AS vend
                    LEFT JOIN " . DB_PREFIX . "account_journal acc ON ( vend.vendor_acc_id = acc.acc_id )
                    WHERE acc.type='VENDOR_PAY' ".$date_range." ".$search_vendor."
                    ORDER BY vend.vendor_name";
            
            $query = $this->db->query($sql);
            return $query->rows;
            
        }
        
        public function get_purchase_order_detail_summary($data){
            $date_range = "";
            $search_vendor = "";
            if( isset($data["end_date"]) ){
                if(!empty($data["end_date"]) && !empty($data["start_date"])){                   
                    $end_date = $data["end_date"];
                    $start_date = $data["start_date"];
                    $date_range = " AND po.invoice_date>='". $start_date ."' AND  po.invoice_date < '". $end_date ."' + interval 1 day";
                }
            }           
            if($data['vendor_id']!='-1'){
                $search_vendor = " AND vend.vendor_id = '".$data['vendor_id']."'";
            }
                        
             $sql = "SELECT pod.*, po.invoice_no AS po_no, i.item_name as item_name, i.item_code as code, po.invoice_id AS po_id, po.invoice_date AS po_date, po.invoice_total AS po_amount, vend.vendor_name AS po_vend_name                 
                    FROM " . DB_PREFIX . "po_invoice_detail pod
                    LEFT JOIN " . DB_PREFIX . "po_invoice po ON ( pod.inv_id = po.invoice_id )
                    LEFT JOIN " . DB_PREFIX . "item i ON ( pod.inv_item_id = i.id )
                    LEFT JOIN " . DB_PREFIX . "vendor vend ON ( po.vendor_id = vend.vendor_id )
                    WHERE po.invoice_id!='' AND po.invoice_type='1' AND po.invoice_status='3' ".$date_range." ".$search_vendor."";
            //echo $sql;
            $query = $this->db->query($sql);
            return $query->rows;
            
        }
        public function get_purchase_order_summary($data){
            $date_range = "";
            $search_vendor = "";
            if( isset($data["end_date"]) ){
                if(!empty($data["end_date"]) && !empty($data["start_date"])){                   
                    $end_date = $data["end_date"];
                    $start_date = $data["start_date"];
                    $date_range = " AND po.invoice_date>='". $start_date ."' AND  po.invoice_date < '". $end_date ."' + interval 1 day";
                }
            }           
            if($data['vendor_id']!='-1'){
                $search_vendor = " AND vend.vendor_id = '".$data['vendor_id']."'";
            }
                        
             $sql = "SELECT po.invoice_no AS po_no, po.invoice_id AS po_id, po.invoice_date AS po_date, po.invoice_total AS po_amount, vend.vendor_name AS po_vend_name                 
                    FROM " . DB_PREFIX . "po_invoice po
                    LEFT JOIN " . DB_PREFIX . "vendor vend ON ( po.vendor_id = vend.vendor_id )
                    WHERE po.invoice_id!='' AND po.invoice_type='1' AND po.invoice_status='3' ".$date_range." ".$search_vendor."";
            
            $query = $this->db->query($sql);
            return $query->rows;
            
        }
        
        
        public function get_vendor_wise_saleReturn_report_summary($data,$items_id){
            $date_range = "";
           if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND inv.invoice_date>='". $start_date ."' AND inv.invoice_date < '". $end_date ."' + interval 1 day";
                }
            } 
            //echo $items_id; exit;
           $sql = "SELECT sum(pd.inv_item_quantity ) AS sold_qty, 
                    sum( pd.inv_item_price*pd.item_quantity) AS amount,
                    sum(pd.item_purchase_price*pd.item_quantity) AS cost, 
                    sum((pd.inv_item_price*(pd.inv_item_discount/100) )*pd.item_quantity) AS discount 
                    FROM " . DB_PREFIX . "pos_invoice_detail AS pd
                    LEFT JOIN " . DB_PREFIX . "pos_invoice inv ON ( pd.inv_id = inv.invoice_id )
                    WHERE pd.item_quantity < 0 AND pd.inv_item_id IN (".$items_id.")".$date_range.""; 
            //echo $sql;
            $query = $this->db->query($sql); 
            return $query->rows==NULL?0:$query->rows;

        }
        public function get_vendor_wise_saleReport_summary($data){
            $sql = "";
            if($data['vendor_id']=='-1'){
                $sql = "SELECT pod.inv_item_id AS item_id, po.vendor_id AS vendor_id, vend.vendor_name AS vendor_name, i.item_name AS item_name, i.item_code AS barcode FROM " . DB_PREFIX . "po_invoice_detail AS pod LEFT JOIN " . DB_PREFIX . "po_invoice AS po ON (pod.inv_id=po.invoice_id) LEFT JOIN " . DB_PREFIX . "vendor AS vend ON (po.vendor_id=vend.vendor_id) LEFT JOIN " . DB_PREFIX . "item AS i ON (pod.inv_item_id=i.id) WHERE po.vendor_id!='' GROUP BY pod.inv_item_id ORDER BY po.vendor_id";
            } else {
                $sql = "SELECT pod.inv_item_id AS item_id, po.vendor_id AS vendor_id, vend.vendor_name AS vendor_name, i.item_name AS item_name, i.item_code AS barcode FROM " . DB_PREFIX . "po_invoice_detail AS pod LEFT JOIN " . DB_PREFIX . "po_invoice AS po ON (pod.inv_id=po.invoice_id) LEFT JOIN " . DB_PREFIX . "vendor AS vend ON (po.vendor_id=vend.vendor_id) LEFT JOIN " . DB_PREFIX . "item AS i ON (pod.inv_item_id=i.id) WHERE po.vendor_id='".$data['vendor_id']."' GROUP BY pod.inv_item_id ORDER BY po.vendor_id";
            }
            //echo $sql;
            $query = $this->db->query($sql);
            return $query->rows==NULL?0:$query->rows;
        }
        
        public function get_vendor_wise_saleReport_summary_detail($data,$items_id){
            $date_range = "";
           if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND inv.invoice_date>='". $start_date ."' AND inv.invoice_date < '". $end_date ."' + interval 1 day";
                }
            } 
           $sql = "SELECT sum(pd.inv_item_quantity ) AS sold_qty, 
                    sum( pd.inv_item_price*pd.item_quantity) AS amount,
                    sum(pd.item_purchase_price*pd.item_quantity) AS cost, 
                    sum((pd.inv_item_price*(pd.inv_item_discount/100) )*pd.item_quantity) AS discount 
                    FROM " . DB_PREFIX . "pos_invoice_detail AS pd
                    LEFT JOIN " . DB_PREFIX . "pos_invoice inv ON ( pd.inv_id = inv.invoice_id )
                    WHERE inv.invoice_status >= '2' AND inv.sale_return='0' AND pd.inv_item_id = '".$items_id."' ".$date_range." GROUP BY pd.inv_item_id"; 
           //echo $sql;
            $query = $this->db->query($sql);
            return $query->rows==NULL?0:$query->rows;
            //return $query->rows;
        }
        
        public function get_vendor_wise_saleReturnReport_summary_detail($data,$items_id){
            $date_range = "";
           if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND inv.invoice_date>='". $start_date ."' AND inv.invoice_date < '". $end_date ."' + interval 1 day";
                }
            } 
           $sql = "SELECT sum(pd.inv_item_quantity ) AS sold_qty, 
                    sum( pd.inv_item_price*pd.item_quantity) AS amount,
                    sum(pd.item_purchase_price*pd.item_quantity) AS cost, 
                    sum((pd.inv_item_price*(pd.inv_item_discount/100) )*pd.item_quantity) AS discount 
                    FROM " . DB_PREFIX . "pos_invoice_detail AS pd
                    LEFT JOIN " . DB_PREFIX . "pos_invoice inv ON ( pd.inv_id = inv.invoice_id )
                    WHERE inv.invoice_status >= '2' AND inv.sale_return='1' AND pd.inv_item_id = '".$items_id."' ".$date_range." GROUP BY pd.inv_item_id"; 
           //echo $sql;
            $query = $this->db->query($sql);
            return $query->rows==NULL?0:$query->rows;
            //return $query->rows;
        }
        
        
        public function get_vendor_name($vendor_id){
          $sql = "SELECT vendor_name                 
                    FROM " . DB_PREFIX . "vendor 
                    WHERE vendor_id=".$vendor_id."";
            
            $query = $this->db->query($sql);
            return $query->row['vendor_name'];  
        }
        public function getVendorPayType($ref_id){
          $sql = "SELECT ach.acc_name AS acc_name                 
                    FROM " . DB_PREFIX . "account_journal AS acc
                    LEFT JOIN " . DB_PREFIX . "account_chart ach ON ( acc.acc_id = ach.acc_id )
                    WHERE acc.type='VENDOR_PAY' AND acc.ref_id='".$ref_id."' AND acc.journal_amount<0";
            
            $query = $this->db->query($sql);
            return $query->row['acc_name'];  
        }
        
        public function getPurchaseInvoiceQty($po_id){
          $sql = "SELECT sum(inv_item_quantity) AS qty               
                    FROM " . DB_PREFIX . "po_invoice_detail
                    WHERE inv_id='".$po_id."'";
            
            $query = $this->db->query($sql);
            return $query->row['qty'];  
        }
        
        public function getBalance($cust_acc_id,$data){
            $date_range = "";
            if( isset($data["end_date"]) ){
                if(!empty($data["end_date"])){                   
                    $end_date = $data["end_date"];
                    //$start_date = $data["start_date"];
                    $date_range = " entry_date< '". $end_date ."' + interval 1 day";
                }
            }
            
            $sql = "SELECT SUM(journal_amount) as amount from account_journal
                    WHERE acc_id =".$cust_acc_id." AND".$date_range;
            
            // echo $sql;
            $query = $this->db->query($sql);
            return $query->row['amount']==NULL?0:$query->row['amount'];
        }

         public function getLastPayment($cust_acc_id,$data)
         {
            $check="";
            // $sql="";
           $query = $this->db->query('SELECT * FROM account_journal WHERE acc_id="'.$cust_acc_id.'" AND`type`="CUST_PAYME"');
             
            $num =$query->num_rows;
            if($num>0)
            {
                $sql = "SELECT journal_amount AS amount,entry_date FROM account_journal WHERE acc_id='".$cust_acc_id."' AND`type`='CUST_PAYME' ORDER BY journal_id DESC LIMIT 1";
            }
            else{
                $sql = "SELECT SUM(journal_amount) AS amount,entry_date FROM account_journal WHERE acc_id='".$cust_acc_id."' AND`type`='CUST_PAYME' ORDER BY journal_id DESC LIMIT 1";
            }
            
            // echo $sql;exit;
             $query = $this->db->query($sql);
            // return $query->rows;
             $amount=$query->row['amount']==NULL?0:$query->row['amount'];
             $date=$query->row['entry_date']==NULL?0:$query->row['entry_date'];
             return array("amount"=>$amount, "date"=>$date);
         }


        public function getOpeningBalance($acc_id){
            
             $this->db->query("SET SQL_BIG_SELECTS=1");
            $sql = "SELECT count(acc_id), (-1*journal_amount) AS opening_balance from account_journal
                    WHERE acc_id =".$acc_id." AND type='CUST_OB' ";
            // echo $sql;
            //echo $sql;
            $query = $this->db->query($sql);
            // return $query->row;
            return $query->row['opening_balance']==NULL?0:$query->row['opening_balance'];
        }
           public function getVendorOpeningBalance($acc_id){
            
             $this->db->query("SET SQL_BIG_SELECTS=1");
            $sql = "SELECT count(acc_id), (-1*journal_amount) AS opening_balance from account_journal
                    WHERE acc_id =".$acc_id." AND type='VEND_OB' ";
            // echo $sql;
            //echo $sql;
            $query = $this->db->query($sql);
            // return $query->row;
            return $query->row['opening_balance']==NULL?0:$query->row['opening_balance'];
        }
        public function getBalancePayable($vendor_acc_id,$data){
             $date_range = "";
            if( isset($data["end_date"]) ){
                if(!empty($data["end_date"])){                   
                    $end_date = $data["end_date"];
                    //$start_date = $data["start_date"];
                    $date_range = " entry_date< '". $end_date ."' + interval 1 day";
                }
            }
            
            $sql = "SELECT SUM(journal_amount) as amount from account_journal
                    WHERE acc_id =".$vendor_acc_id." AND (type='VENDOR_PAY' OR type='P_DIS' OR type='PO_RET' OR type='') AND".$date_range;
            
            //echo $sql;
            $query = $this->db->query($sql);
            return $query->row['amount']==NULL?0:$query->row['amount'];
        }
        
        public function get_ownership($data){            
            $report = array();
            $sql = "SELECT pos.*,cust.cust_name as cust_name                
                FROM ". DB_PREFIX . "pos_invoice AS pos
                LEFT JOIN " . DB_PREFIX . "customer cust ON ( cust.cust_id = pos.cust_id )                
                WHERE pos.custom like '%".$data['item_code']."%'  
                ";            
            //echo $sql;
            $query = $this->db->query($sql);
            $results = $query->rows;
            foreach ($results as $result) {
                $report['records'][] = array( 
                    'invoice_id'       =>$result['invoice_id'],    
                    'cust_name'       =>$result['cust_name'],                         
                    'invoice_date'     => date($this->language->get('date_format'), strtotime($result['invoice_date'])), 
                    'invoice_total'       =>$result['invoice_total'],                         
                    'is_type'       => 'Sale Invoice'
               );
            }
            
            $sql = "SELECT po.*,v.vendor_name as vendor_name                
                FROM ". DB_PREFIX . "po_invoice AS po
                LEFT JOIN " . DB_PREFIX . "vendor v ON ( po.vendor_id = v.vendor_id )                
                WHERE po.custom like '%".$data['item_code']."%'  
                ";            
            //echo $sql;
            $query = $this->db->query($sql);
            $results = $query->rows;
            foreach ($results as $result) {
                $report['records'][] = array( 
                    'invoice_id'       =>$result['invoice_id'],    
                    'cust_name'       =>$result['vendor_name'],                         
                    'invoice_date'     => date($this->language->get('date_format'), strtotime($result['invoice_date'])), 
                    'invoice_total'       =>$result['invoice_total'],                         
                    'is_type'       => 'Purchase Invoice'
               );
            }
            
            return $report;
        }
        public function sale_invoice_profit_report($data)
        {
            $report = array();
            $date_range = "";  
            $customer = "";
            $customerRegion = "";
            $invoice_type = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){                    
                    $date_range = " AND pos.invoice_date>='".$data["start_date"]."' AND pos.invoice_date<'".$data["end_date"]."' + INTERVAL 1 DAY";
                }
            }
            
            if(!empty($data["invoice_type"]) && $data['invoice_type']=='1'){
                 $invoice_type = " AND pos.invoice_type IN (1,2)";
            } else if (!empty($data["invoice_type"]) && $data['invoice_type']=='2'){
                $invoice_type = " AND pos.invoice_type IN (3,4)";
            } else {
                $invoice_type = " AND pos.invoice_type IN (1,2,3,4)";
            }
            if(isset($data["customer_id"]) && $data["customer_id"]!="-1"){
                $customer = " AND pos.cust_id=".$data["customer_id"];
            }
            if($data['customer_region']!="-1"){                
                $customerRegion .= " AND cust.cust_group_id = '".$data['customer_region']."'";
            }
            
            $sql = "SELECT pos.*,cust.cust_name as cust_name , cgroup.cust_group_name as region_name               
                FROM ". DB_PREFIX . "pos_invoice AS pos
                LEFT JOIN " . DB_PREFIX . "customer cust ON ( cust.cust_id = pos.cust_id )
                LEFT JOIN " . DB_PREFIX . "customer_groups cgroup ON ( cust.cust_group_id = cgroup.id )
                WHERE pos.invoice_status >= '2' ".$customer.$invoice_type.$date_range.$customerRegion ." ORDER BY cgroup.id ASC";  
                // echo $sql;exit;  
             $query = $this->db->query($sql);
             $results = $query->rows;
             return $results;
        }
        public function get_sales_order($data){
            $report = array();
            $date_range = "";  
            $customer = " 1";
            $invoice_type = " AND 1";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){                    
                    $date_range = " AND pos.updated_date>='". $data["start_date"] ."' AND pos.updated_date < '". $data["end_date"] ."' + interval 1 day";
                }
            }
            
            if(isset($data["invoice_type"]) && $data["invoice_type"]!="-1"){
                $invoice_type = " AND pos.invoice_type=".$data["invoice_type"];
            }
            if(isset($data["customer_id"]) && $data["customer_id"]!="-1"){
                $customer = " AND pos.cust_id=".$data["customer_id"];
            }
            if($data['customer_region']!="-1"){                
                $customer .= " AND cust.cust_group_id = '".$data['customer_region']."'";
            }
            
            $sql = "SELECT pos.*,cust.cust_name as cust_name , cgroup.cust_group_name as region_name               
                FROM ". DB_PREFIX . "pos_invoice AS pos
                LEFT JOIN " . DB_PREFIX . "customer cust ON ( cust.cust_id = pos.cust_id )
                LEFT JOIN " . DB_PREFIX . "customer_groups cgroup ON ( cust.cust_group_id = cgroup.id )
                WHERE pos.invoice_status >= '2' AND ".$customer.$invoice_type.$date_range ." ORDER BY cgroup.id ASC";    
             $query = $this->db->query($sql);
             $results = $query->rows;
             return $results;
        }
        
        public function get_register_payment($data){           
            $date_range = "";  
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){                    
                    $date_range = " j.entry_date >='". $data["start_date"] ."' AND j.entry_date < '". $data["end_date"] ."' + interval 1 day";
                }
            }
            
            $sql = "SELECT sum(j.journal_amount) as amount                
                FROM ". DB_PREFIX . "account_journal AS j
                LEFT JOIN " . DB_PREFIX . "account_chart ac ON ( ac.acc_id = j.acc_id )                    
                LEFT JOIN " . DB_PREFIX . "account_type at ON ( at.acc_type_id = ac.acc_type_id )                
                WHERE at.acc_type_id=1 AND  j.type='CUST_PAYME' AND ".$date_range ;    
            
             $query = $this->db->query($sql);
             $amount = $query->row['amount']==NULL ? 0 : $query->row['amount'] *-1;             
             return  $amount;
        }
        
        public function get_paid_amount($data,$post_data){
            $date_range = "";  
            if(isset($post_data["start_date"]) && isset($post_data["end_date"]) ){
                if(!empty($post_data["start_date"]) && !empty($post_data["end_date"])){                    
                    $date_range = "AND pay_date >='". $post_data["start_date"] ."' AND pay_date < '". $post_data["end_date"] ."' + interval 1 day";
                }
            }
            $sql = "SELECT sum(pay_amount) as amount                
                FROM ". DB_PREFIX . "invoice_payment 
                  WHERE  inv_id='".$data["invoice_id"]."' AND invoice_type='2' ".$date_range ;   
           // echo $sql;
             $query = $this->db->query($sql);
             
             return  $query->row['amount']==NULL ? 0: $query->row['amount'] ;
        }
        
        public function get_sale_discount($data){
             $sql = "SELECT sum(inv_item_price*inv_item_discount/100) as amount                
                FROM ". DB_PREFIX . "pos_invoice_detail 
                WHERE  inv_id='".$data["invoice_id"]."'";    
            
             $query = $this->db->query($sql);
             
             return  $query->row['amount']==NULL ? 0: $query->row['amount'] ;
        }
        public function getPurchaseInvoiceNo($id){
            $sql = "SELECT invoice_no                
                FROM ". DB_PREFIX . "po_invoice 
                WHERE  invoice_id='".$id."'";    
            
             $query = $this->db->query($sql);
             
             return  $query->row['invoice_no']==NULL ? "": $query->row['invoice_no'] ;
        }
        public function getInvoiceNo($id){
            $sql = "SELECT invoice_no                
                FROM ". DB_PREFIX . "pos_invoice 
                WHERE  invoice_id='".$id."'";    
            
             $query = $this->db->query($sql);
             
             return  $query->row['invoice_no']==NULL ? "": $query->row['invoice_no'] ;
        }
        public function get_invoice_cost($inv_id){
            /*$id = -1*$inv_id;
            $sql =  "SELECT SUM( journal_amount ) AS cost
                    FROM account_journal
                    WHERE acc_id =  '2'
                    AND inv_id =  '".$id."'
                    AND TYPE IN (
                     'S',  'POS', 'SALE_RET'
                    )";
                
            
             $query = $this->db->query($sql);*/
            $sql =  "SELECT SUM( item_quantity * item_purchase_price ) AS cost
                    FROM pos_invoice_detail
                    WHERE 
                    inv_id =  '".$inv_id."'
                    ";
            $query = $this->db->query($sql); 
            return  $query->row['cost']==NULL ? 0: $query->row['cost'] ;
        }
        public function sale_summary_report($data){
            $date_range = "";
            $search_customer = "";
            $search_type = "";
            $search_category = "";
            $search_product = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND inv.updated_date>='". $start_date ."' AND inv.updated_date < '". $end_date ."' + interval 1 day";
                }
            }
            if($data['category_id']!=''){
                $search_category = " AND i.category_id = '".$data['category_id']."'";
            }
            if(isset($data["product_id"]) && !empty($data["product_id"])){
                $search_product = " AND inv_det.inv_item_id = '".$data["product_id"]."'";
            }
            if($data['customer_id']!='-1'){
                $search_customer = " AND inv.cust_id = '".$data['customer_id']."'";
            }
            if($data['customer_region']!='-1'){                
                $search_customer = " AND cust.cust_group_id = '".$data['customer_region']."'";
            }
            
            if(!empty($data["invoice_type"]) && $data['invoice_type']!='-1'){
                $search_type = " AND inv.invoice_type = '".$data["invoice_type"]."'";
            }
            
            $sql = "SELECT sum(inv_det.inv_item_quantity) AS qty,sum(inv_det.item_quantity*(inv_det.inv_item_price-(inv_det.inv_item_price*inv_det.inv_item_discount/100)))  as total_val, cgroup.cust_group_name as group_name, 
                    inv_det.inv_item_id as item_id, inv_det.inv_item_name as item_name
                    FROM " . DB_PREFIX . "pos_invoice_detail AS inv_det                    
                    LEFT JOIN " . DB_PREFIX . "pos_invoice inv ON ( inv.invoice_id = inv_det.inv_id )                        
                    LEFT JOIN " . DB_PREFIX . "customer cust ON ( cust.cust_id = inv.cust_id )                    
                    LEFT JOIN " . DB_PREFIX . "customer_groups cgroup ON ( cust.cust_group_id = cgroup.id )
                    LEFT JOIN " . DB_PREFIX . "item i ON ( inv_det.inv_item_id = i.id )
                    WHERE inv.invoice_status >= '2' ".$search_category." ".$search_product." ".$search_customer." ".$search_type." ".$date_range." 
                    GROUP BY cgroup.id,inv_det.inv_item_id";
            // echo $sql;
            $query = $this->db->query($sql);
            return $query->rows;
        }
        
        public function register_report($data){
            $date_range = ""; 
            $search_customer = "";            
            $search_customer_group = "";

            if($data['customer_id']!='' && $data['customer_id']!='-1'){
                $search_customer = " AND cust.cust_id IN (".$data['customer_id'].")";
            }
            if($data['customer_region']!='-1'){
                $search_customer_group = " AND cust.cust_group_id = '".$data['customer_region']."'";
            }
            if( isset($data["start_date"]) &&  isset($data["end_date"])){
                if(!empty($data["start_date"])){                   
                    $start_date = $data["start_date"];
                    $date_range .= "AND j.entry_date > '". $start_date ."' ";
                }                
                if(!empty($data["end_date"])){                   
                    $end_date = $data["end_date"];
                    $date_range .= " AND j.entry_date < '". $end_date ."' + interval 1 day";
                }
            }
            if($data['non_collected']==true)
            {
                 $this->db->query("SET SQL_BIG_SELECTS=1");
                $query = "SELECT cust.cust_name as customer_name,cust_grp.cust_group_name as group_name,cust.cust_acc_id AS acc_id FROM account_chart acc  LEFT JOIN customer cust ON ( cust.cust_acc_id = acc.acc_id ) LEFT JOIN customer_groups cust_grp ON ( cust_grp.id = cust.cust_group_id )
       
                 WHERE acc.acc_type_id=1 AND cust.cust_id!=-1 ". $search_customer_group." ORDER BY cust_grp.cust_group_name ASC,cust.cust_name ASC";
            }
            else{
                $this->db->query("SET SQL_BIG_SELECTS=1");
                $query = " SELECT j.type,j.journal_id,j.acc_id,j.journal_details,j.journal_amount,j.entry_date,cust.cust_acc_id, cust.cust_name as customer_name,cust_grp.cust_group_name as group_name,sale_rep.salesrep_name AS sale_representative  
                    FROM ". DB_PREFIX . "account_journal AS j
                    LEFT JOIN " . DB_PREFIX . "account_chart acc ON ( acc.acc_id = j.acc_id )    
                    LEFT JOIN " . DB_PREFIX . "customer cust ON ( cust.cust_acc_id = acc.acc_id )                        
                    LEFT JOIN " . DB_PREFIX . "customer_groups cust_grp ON ( cust_grp.id = cust.cust_group_id )
                    LEFT JOIN " . DB_PREFIX . " salesrep_detail salerep_det ON (j.ref_id=salerep_det.ref_id)
                    LEFT JOIN " . DB_PREFIX . " salesrep sale_rep ON (sale_rep.id=salerep_det.salesrep_id) 
                    WHERE (j.type='S' || j.type='CUST_PAYME' || j.type='DIS' || j.type='CUST_OB') AND acc.acc_type_id=1 ".$search_customer.$search_customer_group.$date_range . " Order by cust_grp.cust_group_name ASC,cust.cust_name ASC";
            }
            
            
            // echo $query;exit;
            $query_income = $this->db->query($query);  
            return $query_income->rows;
        }
        
        public function getPreviousCustomer($data,$acc_id) {
            $date_range = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];                    
                    $date_range = " and aj.entry_date <'". $start_date ."'";
                }
            }   
            
            $sql = "SELECT ac.acc_name,sum(aj.journal_amount) as pre_total,cus.cust_name FROM "
                . DB_PREFIX . "account_journal aj                 
                LEFT JOIN " . DB_PREFIX . "account_chart ac ON (ac.acc_id = aj.acc_id)
                LEFT JOIN " . DB_PREFIX . "customer cus ON (cus.cust_acc_id = aj.acc_id)
                WHERE aj.acc_id=".$acc_id.$date_range; 
            
            $query = $this->db->query($sql);
            return $query->row;        
       }
            public function getPreviousCustomerWithoutDate($acc_id) {
          
            $sql = "SELECT ac.acc_name,sum(aj.journal_amount) as pre_total,cus.cust_name FROM "
                . DB_PREFIX . "account_journal aj                 
                LEFT JOIN " . DB_PREFIX . "account_chart ac ON (ac.acc_id = aj.acc_id)
                LEFT JOIN " . DB_PREFIX . "customer cus ON (cus.cust_acc_id = aj.acc_id)
                WHERE aj.acc_id=".$acc_id; 
            // echo $sql;exit;
            $query = $this->db->query($sql);
            return $query->row;        
       } 
        public function getPaidAmountWithDate($acc_id,$data) {
            $date_range = ""; 
            $search_customer = "";            
            $search_customer_group = "";
            
            if($data['customer_id']!='-1' && $data['customer_id']!='All'){
                $search_customer = " AND cust.cust_id = '".$data['customer_id']."'";
            }
            if($data['customer_region']!='-1'){
                $search_customer_group = " AND cust.cust_group_id = '".$data['customer_region']."'";
            }
            if( isset($data["start_date"]) &&  isset($data["end_date"])){
                if(!empty($data["start_date"])){                   
                    $start_date = $data["start_date"];
                    $date_range .= "AND j.entry_date > '". $start_date ."' ";
                }                
                if(!empty($data["end_date"])){                   
                    $end_date = $data["end_date"];
                    $date_range .= " AND j.entry_date < '". $end_date ."' + interval 1 day";
                }
            }
          
            $sql = "SELECT COUNT(j.journal_id) AS counting,j.type,j.journal_id,j.acc_id,j.journal_amount,sale_rep.salesrep_name AS sale_representative,j.entry_date  
                    FROM ". DB_PREFIX . "account_journal AS j
                    LEFT JOIN " . DB_PREFIX . "account_chart acc ON ( acc.acc_id = j.acc_id )
                    LEFT JOIN " . DB_PREFIX . "customer cust ON ( cust.cust_acc_id = acc.acc_id )      
                    LEFT JOIN " . DB_PREFIX . "customer_groups cust_grp ON ( cust_grp.id = cust.cust_group_id )                    
                    LEFT JOIN " . DB_PREFIX . " salesrep_detail salerep_det ON (j.ref_id=salerep_det.ref_id)
                    LEFT JOIN " . DB_PREFIX . " salesrep sale_rep ON (sale_rep.id=salerep_det.salesrep_id) 
                    WHERE (j.type='S' || j.type='CUST_PAYME' || j.type='DIS') AND acc.acc_type_id=1 AND j.acc_id='".$acc_id." '".$search_customer.$search_customer_group.$date_range; 
            // echo $sql;exit;
            $query = $this->db->query($sql);
            return $query->row;        
       }

       
       public function getBillPayable($vendor_acc_id,$data){
             $date_range = "";
            if( isset($data["end_date"]) ){
                if(!empty($data["end_date"])){                   
                    $end_date = $data["end_date"];
                    //$start_date = $data["start_date"];
                    $date_range = " entry_date< '". $end_date ."' + interval 1 day";
                }
            }
            
            $sql = "SELECT SUM(journal_amount) as amount from account_journal
                    WHERE acc_id =".$vendor_acc_id." AND type='P' AND".$date_range;
            
            // echo $sql;
            $query = $this->db->query($sql);
            $result_credit =  $query->row['amount']==NULL?0:$query->row['amount'];
            
            // $sql = "SELECT SUM(journal_amount) as amount from account_journal
            //         WHERE acc_id =".$vendor_acc_id." AND (type='VENDOR_PAY' OR type='P_DIS'  OR type='PO_RET_A' OR type='PO_RET' OR type='')  AND".$date_range;

            $sql = "SELECT SUM(journal_amount) as amount from account_journal
                     WHERE acc_id =".$vendor_acc_id." AND type IN('P_DIS','PO_RET','VENDOR_PAY')  AND".$date_range;

                    // echo $sql;exit;
            $query = $this->db->query($sql);
            $result_debit = $query->row['amount']==NULL?0:$query->row['amount'];
                        
            
            return array("credit"=>$result_credit, "debit"=>$result_debit);
        }

          public function get_vendor_qty($date,$acc_id)
        {
             // $date_range = "";
             // $search_vendor="";
            //   if($acc_id !='-1'){
            //     $search_vendor = " vendor_id = '".$acc_id."'";
            // }
            // else{
            //     $search_vendor = "vendor_id>0";
            // }
             $end_date = $date["end_date"];
            
            // if( isset($data["end_date"]) ){
            //     if(!empty($data["end_date"])){                   
            //         $end_date = $data["end_date"];
            //         //$start_date = $data["start_date"];
            //         $date_range = " x.invoice_date< '". $end_date ."' + interval 1 day";
            //     }
            // }

            $sql = "SELECT po.invoice_id,sum(po_d.inv_item_quantity) as qty,po.vendor_id,po.invoice_date,po_d.inv_id FROM po_invoice po LEFT JOIN po_invoice_detail po_d ON (po.invoice_id = po_d.inv_id) WHERE po.vendor_id=".$acc_id." AND  po.invoice_date<'".$end_date."'  + interval 1 day  GROUP BY po.vendor_id UNION  
                SELECT 0 as invoice_id, 0 as qty, 0 as vendor_id, 0 as invoice_date,0 as inv_id";
            //echo $sql;exit;
            $query = $this->db->query($sql);
           return $qty = $query->row['qty']==NULL?0:$query->row['qty'];
           // return $query->rows;
        }
        
        public function getStockValue($data){
            $date_range = "";
            if( isset($data["end_date"]) ){
                if(!empty($data["end_date"])){                   
                    $end_date = $data["end_date"];                    
                    $date_range = " entry_date< '". $end_date ."' + interval 1 day";
                }
            }
            $sql = "SELECT SUM(journal_amount) as amount from account_journal
                    WHERE acc_id =1 AND (type='E' OR type='A')  AND".$date_range;
            $query = $this->db->query($sql);
            $result_unknown = $query->row['amount']==NULL?0:$query->row['amount'];
            return $result_unknown;
        }
        
        public function getBillReceivable($cust_acc_id,$data){
             $date_range = "";
            if( isset($data["end_date"]) ){
                if(!empty($data["end_date"])){                   
                    $end_date = $data["end_date"];
                    //$start_date = $data["start_date"];
                    $date_range = " entry_date< '". $end_date ."' + interval 1 day";
                }
            }
            
            $sql = "SELECT SUM(journal_amount) as amount from account_journal
                    WHERE acc_id =".$cust_acc_id." AND  journal_amount>0  AND".$date_range;
            
            //echo $sql;
            $query = $this->db->query($sql);
            $result_debit =  $query->row['amount']==NULL?0:$query->row['amount'];
            
            $sql = "SELECT SUM(journal_amount) as amount from account_journal
                    WHERE acc_id =".$cust_acc_id." AND  journal_amount<0  AND".$date_range;
            $query = $this->db->query($sql);
            $result_credit =$query->row['amount']==NULL?0:$query->row['amount'];
                        
            
            return array("credit"=>$result_credit, "debit"=>$result_debit);
        }
        
        public function getWalkinCustomer($data){
             $date_range = "";
            if( isset($data["end_date"]) ){
                if(!empty($data["end_date"])){                   
                    $end_date = $data["end_date"];                    
                    $date_range = " paid_date< '". $end_date ."' + interval 1 day";
                }
            }
            $sql = "SELECT sum(invoice_paid) as amount FROM pos_invoice WHERE cust_id=0 AND invoice_status=2  AND".$date_range;
            $query = $this->db->query($sql);
            $result_walkincustomer = $query->row['amount']==NULL?0:$query->row['amount'];
            return $result_walkincustomer;
        }

        public function get_stock_transfer($data)
        {
             $date_range = "";
            $search_category = "";
            $all_cat_col="";
            $all_cat="";
            $from_wareh="";
            $to_wareh="";
            $search_product = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND s.date>='". $start_date ."' AND s.date < '". $end_date ."' + interval 1 day";
                }
            }
             if($data['warehouse']!='-1')
            {
                $warehouse=$data['warehouse'];
               $from_wareh=" s.from_warehouse='".$warehouse."'"; 
            }
            else{
             $from_wareh=" s.from_warehouse !=''";   
            }

               if($data['to_warehouse']!='-1')
            {
                $warehouse=$data['to_warehouse'];
               $to_wareh=" AND s.to_warehouse='".$warehouse."'"; 
            }
            else{
             $to_wareh=" AND s.to_warehouse !=''";   
            }
            if(isset($data["product_id"]) && !empty($data["product_id"])){
                $search_product = " AND s.item_id = '".$data["product_id"]."'";
            }

             if($data['warehouse_type']==0) 
             {
                $sql = "SELECT s.*,u.name AS unitname,i.item_name,c.name AS category,w.warehouse_name AS from_warehouse,tw.warehouse_name AS to_warehouse,c.id AS category_id
                    FROM " . DB_PREFIX . "stock_transfer s                    
                    LEFT JOIN " . DB_PREFIX . "item i ON ( i.id = s.item_id )         
                    LEFT JOIN " . DB_PREFIX . "category c ON ( c.id = i.category_id )         
                    LEFT JOIN " . DB_PREFIX . "units u ON ( u.id = s.unit_id )         
                    LEFT JOIN " . DB_PREFIX . "warehouses w ON ( w.warehouse_id = s.from_warehouse )         
                    LEFT JOIN " . DB_PREFIX . "warehouses tw ON ( tw.warehouse_id = s.to_warehouse )         
                    WHERE ".$from_wareh." ".$to_wareh." ".$search_product." ".$date_range." 
                    GROUP BY s.item_id,s.date,s.unit_id";
             }   
             else{
                $sql = "SELECT s.*,u.name AS unitname,i.item_name,c.name AS category,w.warehouse_name AS from_warehouse,tw.warehouse_name AS to_warehouse,c.id AS category_id
                    FROM " . DB_PREFIX . "stock_transfer s                    
                    LEFT JOIN " . DB_PREFIX . "item i ON ( i.id = s.item_id )         
                    LEFT JOIN " . DB_PREFIX . "category c ON ( c.id = i.category_id )         
                    LEFT JOIN " . DB_PREFIX . "units u ON ( u.id = s.unit_id )         
                    LEFT JOIN " . DB_PREFIX . "warehouses w ON ( w.warehouse_id = s.from_warehouse )         
                    LEFT JOIN " . DB_PREFIX . "warehouses tw ON ( tw.warehouse_id = s.to_warehouse )         
                    WHERE ".$from_wareh." ".$to_wareh." ".$search_product." ".$date_range." 
                    GROUP BY s.item_id,s.invoice_no";
             }
             
            // echo $sql;exit;
            $query = $this->db->query($sql);
            return $query->rows;

        }
        
        public function get_stock_reordering_point($data)
        {
            $search_category='';
            $search_product = "";
            $to_wareh="";
              if(isset($data["product_id"]) && !empty($data["product_id"])){
                $search_product = " wo.item_id = '".$data["product_id"]."'";
            }
            else
            {
             $search_product = " wo.item_id != ''";   
            }

                if($data['warehouse']!='-1')
            {
                $warehouse=$data['warehouse'];
               $to_wareh=" AND wo.warehouse_id='".$warehouse."'"; 
            }
            else{
             $to_wareh=" AND wo.warehouse_id !=''";   
            }
            if($data['category_id']!=''){
                $search_category = " AND i.category_id = '".$data['category_id']."'";
            }

          $sql = "SELECT wo.warehouse_id ,wo.item_id,i.item_name,w.warehouse_name,wo.reorder_qty,c.name AS category FROM warehouse_reorder wo LEFT JOIN item i ON (i.id=wo.item_id) LEFT JOIN warehouses w ON (w.warehouse_id=wo.warehouse_id) LEFT JOIN category c ON (i.category_id=c.id) WHERE ".$search_product." ".$to_wareh." ".$search_category." ORDER BY wo.warehouse_id ASC";
          // echo $sql;exit;
          $query = $this->db->query($sql);
            return $query->rows;  
        }

        public function getlast_vendor($item_id)
        {
            $sql="SELECT v.vendor_name,sum(poi.inv_item_quantity) AS qty,poi.inv_item_price AS purchase_price FROM po_invoice_detail poi LEFT JOIN po_invoice po ON (po.invoice_id=poi.inv_id) LEFT JOIN vendor v ON (v.vendor_id=po.vendor_id) WHERE poi.inv_item_id='$item_id' ORDER BY poi.inv_item_id DESC LIMIT 1";
             $query = $this->db->query($sql);
            return $query->rows;  
        }

         public function get_reoder_item_qty($item_id,$ware_id)
        {
            $sql="SELECT SUM(`qty`) AS qty FROM `item_warehouse` WHERE item_id='$item_id' AND warehouse_id='$ware_id'";
            // echo $sql;
              $query = $this->db->query($sql);
           return $qty = $query->row['qty']==NULL?0:$query->row['qty'];
        }

        public function get_customer_aging($data)
        {
            // $inv=-1*$data;
            $sql="SELECT inv.invoice_id AS inv_id,cust.cust_name AS customer,inv.invoice_date AS date,pd.inv_item_id AS item,pd.`item_quantity` AS qty,pd.inv_item_subTotal AS sub_total,i.item_name AS item,inv.invoice_total AS total,pd.inv_item_price AS unit_price,inv.invoice_paid AS paid,(pd.inv_item_discount/100) * (pd.item_quantity) *(pd.inv_item_price/pd.item_quantity) AS discount FROM pos_invoice inv left JOIN pos_invoice_detail pd ON (pd.inv_id=inv.invoice_id) LEFT JOIN customer cust ON (inv.cust_id=cust.cust_id) LEFT JOIN item i ON (pd.inv_item_id=i.id) WHERE inv.invoice_id ='$data' ORDER BY inv.invoice_id,inv.cust_id";
                // echo $sql;exit;s
               $query = $this->db->query($sql);
                return $query->rows;  
        }

        public function get_customer_invoicePaid($inv_id)
        {
            $sql="SELECT invoice_paid AS paid FROM pos_invoice WHERE invoice_id='$inv_id' GROUP BY 'invoice_id'";
            // echo $sql;exit;
              $query = $this->db->query($sql);
           return $paid = $query->row['paid']==NULL?0:$query->row['paid'];
        }
        public function get_customer_RegisterPaid($data)
        {
            $get="SELECT * FROM customer WHERE cust_id=".$data['customer_id']." ";

            $query = $this->db->query($get);
            $customer = $query->row['cust_acc_id'];
             $date_range = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = " and aj.entry_date>='". $start_date ."' AND aj.entry_date < '". $end_date ."' + interval 1 day";
                }
            } 

            $sql="SELECT ac.acc_name,aj.*,cus.cust_name,cus.cust_mobile,cus.cust_acc_id FROM account_journal aj LEFT JOIN account_chart ac ON (ac.acc_id = aj.acc_id) LEFT JOIN customer cus ON (cus.cust_acc_id = aj.acc_id) WHERE aj.acc_id='$customer' ".$date_range." ORDER BY aj.entry_date ASC";
            // echo $sql;exit;
           $query = $this->db->query($sql);
            $results = $query->rows;
            $register_accounts = array();            
            foreach ($results as $result) {
                 $sql = "SELECT ac.acc_name,aj.* FROM " . DB_PREFIX . "account_journal aj                 
                    LEFT JOIN " . DB_PREFIX . "account_chart ac ON (ac.acc_id = aj.acc_id)                    
                    WHERE aj.acc_id!=".$result['acc_id']." AND aj.ref_id=".$result['ref_id']." ORDER BY aj.journal_id ASC" ;
                 $query = $this->db->query($sql);
                 // echo $sql;exit;         
                 $aresult = $query->row;
                 
                 $register_accounts[] = array(
                        'journal_id'             => $aresult['journal_id'],
                        'acc_name'             => $aresult['acc_name'],
                        'acc_id'             => $aresult['acc_id'],
                        'description'            => $aresult['journal_details'],
                        'cust_name'             => $result['cust_name'],
                        'cust_mobile'             => $result['cust_mobile'],
                        'ref_id'                  => $result['ref_id'],
                        'journal_type'             => $result['type'],
                        'num'                  => $result['inv_id']*-1,
                        'entry_date'                  => $result['entry_date'],                        
                        'item_id'                  => $result['item_id'],                        
                        'cust_acc_id'                  => $result['cust_acc_id'],                        
                        'journal_amount'                => $result['journal_amount']);
             } 
            return $register_accounts;
        }
        public function getlast_payment($acc_id)
        {
          $sql="SELECT  SUM(journal_amount) journal_amount FROM `account_journal` WHERE `type`='CUST_PAYME' AND acc_id='$acc_id'";
          // echo $sql;exit;
              $query = $this->db->query($sql);
           return $discount = $query->row['journal_amount']==NULL?0:$query->row['journal_amount'];    
        }

         public function get_vendor_RegisterPaid($data)
        {
            $get="SELECT * FROM vendor WHERE vendor_id=".$data['vendor_id']." ";

            $query = $this->db->query($get);
            $vendor = $query->row['vendor_acc_id'];
             $date_range = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = " and aj.entry_date>='". $start_date ."' AND aj.entry_date < '". $end_date ."' + interval 1 day";
                }
            } 

            $sql="SELECT ac.acc_name,aj.*,vend.vendor_name,vend.vendor_mobile FROM account_journal aj LEFT JOIN account_chart ac ON (ac.acc_id = aj.acc_id) LEFT JOIN vendor vend ON (vend.vendor_acc_id = aj.acc_id) WHERE aj.acc_id='$vendor' ".$date_range." ORDER BY aj.journal_id ASC";
            // echo $sql;exit;
           $query = $this->db->query($sql);
            $results = $query->rows;
            $register_accounts = array();            
            foreach ($results as $result) {
                 $sql = "SELECT ac.acc_name,aj.* FROM " . DB_PREFIX . "account_journal aj                 
                    LEFT JOIN " . DB_PREFIX . "account_chart ac ON (ac.acc_id = aj.acc_id)                    
                    WHERE aj.acc_id!=".$result['acc_id']." AND aj.ref_id=".$result['ref_id']." ORDER BY aj.journal_id ASC" ;
                 $query = $this->db->query($sql);
                 // echo $sql;exit;         
                 $aresult = $query->row;
                 
                $amount = $result['journal_amount'];
                 if($result['type']=="P_DIS"){
                     $amount = -1 * $amount;
                 }
                 $register_accounts[] = array(
                        'journal_id'             => $aresult['journal_id'],
                        'acc_name'             => $aresult['acc_name'],
                        'acc_id'             => $aresult['acc_id'],
                        'description'            => $aresult['journal_details'],
                        'vendor_name'             => $result['vendor_name'],
                        'journal_type'             => $result['type'],
                        'ref_id'                  => $result['ref_id'],
                        'num'                  => $result['inv_id'],
                        'entry_date'                  => $result['entry_date'],                        
                        'journal_amount'                => $amount
                    );
             }
            return $register_accounts;
        }

          public function getCustInvNo($id){
            $invoice_no = "";
            $sql = "SELECT invoice_no,invoice_type                
                FROM ". DB_PREFIX . "pos_invoice 
                WHERE  invoice_id='".$id."'";    
            
             $query = $this->db->query($sql);             
             if($query->num_rows > 0){ 
                $inv_type = $query->row['invoice_type'];
                $invoice_no_prefix = "";
                if($inv_type!=NULL){
                    if($inv_type=="2"){
                        $invoice_no_prefix = "Sale-inv #";
                    }
                    else if($inv_type=="1"){
                        $invoice_no_prefix = "POS-Inv #";
                    }
                    else if($inv_type=="3"){
                        $invoice_no_prefix = "POS-Sale-Return #";
                    }
                    else if($inv_type=="4"){
                        $invoice_no_prefix = "Sale-Return-Inv #";
                    }
                }
                $invoice_no = $query->row['invoice_no']==NULL ? "": ($invoice_no_prefix.$query->row['invoice_no']) ;
             }
             return $invoice_no;
        }
        

        public function get_customer_invoiceDiscount($inv_id)
        {
           $sql="SELECT SUM(discount) AS discount FROM pos_invoice WHERE invoice_id='$inv_id' GROUP BY 'invoice_id'";
              $query = $this->db->query($sql);
           return $discount = $query->row['discount']==NULL?0:$query->row['discount'];  
        }
        public function get_item_list($data)
        {
                $search_product='';
                $search_product_keyword='';
                $search_category='';
               if($data['product_id'] !='')
               {
                $search_product = " i.product_id = '".$data['product_id']."'";
               }
               else{
                 $search_product = "";
               }

               if($data['category_id']!=''){
                $search_category = " AND i.category_id = '".$data['category_id']."'";
            }

                if($data['product_search'])
                {
                    $search_product_keyword="i.item_name LIKE '%".$data['product_search']."%'";
                }
                else{
                 $search_product_keyword="1";   
                }
            $sql = "SELECT i.*, c.`name` AS category, 
                GROUP_CONCAT(unit.`sale_price` ORDER BY unit_id ASC) AS item_sale_price, 
                GROUP_CONCAT(unit.`unit_id` ORDER BY unit_id ASC) AS item_unit_id 
                FROM `item` i 
                LEFT JOIN category c ON (i.category_id=c.id) 
                LEFT JOIN unit_mapping unit ON (i.id=unit.item_id) 
                WHERE ".$search_product_keyword." ".$search_product."".$search_category." GROUP BY unit.item_id";
            // echo $sql;
            $query = $this->db->query($sql);
                return $query->rows; 
        }
        public function get_item_units()
        {
            $sel="SELECT u.name AS unit FROM units u LEFT JOIN unit_mapping um ON(um.unit_id=u.id) GROUP BY um.unit_id ORDER BY u.id ASC";
             $query = $this->db->query($sel);
             return array("AllUnitNames"=>$query->rows, "NumUnit"=>$query->num_rows);
  
        }

             public function getPreviousCustBalance($data) {
             $get="SELECT * FROM customer WHERE cust_id=".$data['customer_id']." ";

            $query = $this->db->query($get);
            $customer = $query->row['cust_acc_id'];   
            $date_range = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = " and aj.entry_date <'". $start_date ."'";
                }
            }   
            
            $sql = "SELECT aj.acc_id,ac.acc_name,sum(aj.journal_amount) as pre_total,cus.cust_name FROM " . DB_PREFIX . "account_journal aj                 
                LEFT JOIN " . DB_PREFIX . "account_chart ac ON (ac.acc_id = aj.acc_id)
                LEFT JOIN " . DB_PREFIX . "customer cus ON (cus.cust_acc_id = aj.acc_id)
                WHERE aj.acc_id=".$customer."
                ".$date_range. " Order by aj.journal_id ASC"; 
            // echo $sql;exit;
            $query = $this->db->query($sql);
            return $query->row;        
        }

               public function getPreviousVendorBalance($data) {
             $get="SELECT * FROM vendor WHERE vendor_id=".$data['vendor_id']." ";

            $query = $this->db->query($get);
            $vendor = $query->row['vendor_acc_id'];   
            $date_range = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = " and aj.entry_date <'". $start_date ."'";
                }
            }   
            
            $sql = "SELECT ac.acc_name,sum(aj.journal_amount) as pre_total,ven.vendor_name FROM " . DB_PREFIX . "account_journal aj                 
                LEFT JOIN " . DB_PREFIX . "account_chart ac ON (ac.acc_id = aj.acc_id)
                LEFT JOIN " . DB_PREFIX . "vendor ven ON (ven.vendor_acc_id = aj.acc_id)    
                WHERE aj.acc_id=".$vendor." and aj.type!='PO_RET_A'
                ".$date_range. " Order by aj.journal_id ASC";  
            // echo $sql;exit;
            $query = $this->db->query($sql);
            return $query->row;        
        }

        public function get_accountListRecord($data)
        {
            $date_range='';$acc_id='';
            if(!empty($data['start_date']) && !empty($data['end_date']))
            {
                $start_date=$data['start_date'];
                $end_date=$data['end_date'];
                $date_range = " and aj.entry_date>='". $start_date ."' AND aj.entry_date < '". $end_date ."' + interval 1 day";
            }
             if($data['asset_id'] =='-1')
                {
                    $get="SELECT GROUP_CONCAT(acc_id) AS acc_id FROM account_chart WHERE acc_id != '-1' AND acc_type_id ='3'";

                    $query = $this->db->query($get);
                    $acc_id = $query->row['acc_id']; 
                    // echo $acc_id;exit;
                }
                else{
                    $acc_id = $data['asset_id']; 
                }
            $sql="SELECT j.*,ac.acc_name FROM `account_journal` j LEFT JOIN account_chart ac ON j.acc_id=ac.acc_id WHERE j.acc_id IN  (".$acc_id.") ORDER BY j.acc_id ASC";
            // echo $sql;exit;
                      $query = $this->db->query($sql);
            return $query->rows;     
        }

        public function getPurchaseSummaryRecord($data)
        {
            $date_range='';

                 if(!empty($data['start_date']) && !empty($data['end_date']))
            {
                $start_date=$data['start_date'];
                $end_date=$data['end_date'];
                $date_range = " and p.invoice_date>='". $start_date ."' AND p.invoice_date < '". $end_date ."' + interval 1 day";
            } 

              if(!empty($data['vendor_id']))
            {
                if($data['vendor_id']=="All" || $data['vendor_id']=='-1')
                {
                $vendor=" p.vendor_id !=''";
                }
                else{
                        $vendor_id=$data['vendor_id'];
                $vendor=" p.vendor_id='".$vendor_id."'";
                }
            
            }

              $sql="SELECT v.vendor_name AS vendor_name,p.* FROM po_invoice p LEFT JOIN vendor v ON (p.vendor_id=v.vendor_id) WHERE ".$vendor." ".$date_range."  AND p.invoice_type='1' order by p.invoice_date ASC";
                // echo $sql;exit;
                $query = $this->db->query($sql);
            return $query->rows;
        }

        public function getPurchaseRecord($data)
        {
             $date_range='';$vendor='';$search_product='';
              if(isset($data["product_id"]) && !empty($data["product_id"])){
                $search_product = " AND po.inv_item_id = ".$data["product_id"]."";
            }
            else{
                 $search_product = " AND po.inv_item_id !=''";
            }
            if(!empty($data['start_date']) && !empty($data['end_date']))
            {
                $start_date=$data['start_date'];
                $end_date=$data['end_date'];
                $date_range = " and p.invoice_date>='". $start_date ."' AND p.invoice_date < '". $end_date ."' + interval 1 day";
            }     
            if(!empty($data['vendor_id']))
            {
                if($data['vendor_id']=="All" || $data['vendor_id']=='-1')
                {
                $vendor=" p.vendor_id !=''";
                }
                else{
                        $vendor_id=$data['vendor_id'];
                $vendor=" p.vendor_id='".$vendor_id."'";
                }
            
            }
            $sql="SELECT v.vendor_name AS vendor,i.item_name,c.name AS category, SUM(po.inv_item_quantity) AS qty,i.normal_price AS price,SUM(po.inv_item_subTotal) AS amount FROM po_invoice p LEFT JOIN po_invoice_detail po ON (p.invoice_id=po.inv_id) LEFT JOIN vendor v ON v.vendor_id=p.vendor_id LEFT JOIN item i ON i.id=po.inv_item_id LEFT JOIN category c ON c.id=i.category_id WHERE ".$vendor." ".$date_range." ".$search_product." AND p.invoice_type='1' GROUP BY po.inv_item_id,p.vendor_id order by p.vendor_id ASC";

            // echo $sql;exit;
             $query = $this->db->query($sql);
            return $query->rows;
        }

        public function getPurchaseReturnRecord($data)
        {
             $date_range='';$vendor='';$search_product='';
              if(isset($data["product_id"]) && !empty($data["product_id"])){
                $search_product = " AND po.inv_item_id = ".$data["product_id"]."";
            }
            else{
                 $search_product = " AND po.inv_item_id !=''";
            }
            if(!empty($data['start_date']) && !empty($data['end_date']))
            {
                $start_date=$data['start_date'];
                $end_date=$data['end_date'];
                $date_range = " and p.invoice_date>='". $start_date ."' AND p.invoice_date < '". $end_date ."' + interval 1 day";
            }     
            if(!empty($data['vendor_id']))
            {
                if($data['vendor_id']=="All" || $data['vendor_id']=='-1')
                {
                $vendor=" p.vendor_id !=''";
                }
                else{
                        $vendor_id=$data['vendor_id'];
                $vendor=" p.vendor_id='".$vendor_id."'";
                }
            
            }
            $sql="SELECT v.vendor_name AS vendor,i.item_name,c.name AS category, SUM(po.inv_item_quantity) AS qty,po.inv_item_price AS price FROM po_invoice p LEFT JOIN po_invoice_detail po ON (p.invoice_id=po.inv_id) LEFT JOIN vendor v ON v.vendor_id=p.vendor_id LEFT JOIN item i ON i.id=po.inv_item_id LEFT JOIN category c ON c.id=i.category_id WHERE ".$vendor." ".$date_range." ".$search_product." AND p.invoice_type='2' GROUP BY po.inv_item_id,p.vendor_id order by p.vendor_id ASC";
            // echo $sql;exit;
                 $query = $this->db->query($sql);
            return $query->rows;

        }

        public function getItemSaleDetail($data)
        {
               $date_range = "";
            $search_warehouse = "";
            $search_product = "";
            $search_category = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND p.invoice_date>='". $start_date ."' AND p.invoice_date < '". $end_date ."' + interval 1 day";
                }
            }
            if($data['warehouse']!='-1'){
                $search_warehouse = " AND pos.warehouse_id = '".$data['warehouse']."'";
            }
              if(isset($data['category_id']) && !empty($data['category_id'])){
                $search_category = " AND i.category_id IN (".$data['category_id'].")";
            }
            if(isset($data["item_id"]) && !empty($data["item_id"])){
                $search_product = " pos.inv_item_id = '".$data["item_id"]."'";
            }
            else{
                $search_product=" pos.inv_item_id !=''";
            }
            $sql="SELECT pos.inv_item_id AS item_id,i.item_name AS item_name,p.invoice_no AS invno,cust.cust_name AS customer,SUM(pos.inv_item_quantity) AS qty,p.invoice_date AS date,pos.inv_item_price AS price,pos.inv_item_price*(pos.inv_item_discount/100)*pos.inv_item_quantity AS discount,SUM(pos.inv_item_subTotal) AS subtotal FROM pos_invoice_detail pos LEFT JOIN item i ON pos.inv_item_id=i.id LEFT JOIN pos_invoice p ON pos.inv_id=p.invoice_id LEFT JOIN customer cust ON p.cust_id=cust.cust_id WHERE ".$search_product." ".$search_warehouse." ".$search_category." ".$date_range." GROUP BY p.invoice_id,pos.inv_item_id ORDER by i.item_name,p.invoice_id ASC";
            // echo $sql;exit;
            $query = $this->db->query($sql);
            return $query->rows;
        }

        public function get_VendorWiseSaleReport($data)
        {
                  $date_range = "";
            $search_product = "";
            $search_category = "";
            $search_vendor="";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "AND p.invoice_date>='". $start_date ."' AND p.invoice_date < '". $end_date ."' + interval 1 day";
                }
            }
              if(isset($data["item_id"]) && !empty($data["item_id"])){
                $search_product = " pos.inv_item_id = '".$data["item_id"]."'";
            }
            else{
                $search_product=" pos.inv_item_id !=''";
            }

              if($data['category_id']!=''){
                $search_category = " AND i.category_id = '".$data['category_id']."'";
            } 
            if($data['vendor_id']=="All" || $data['vendor_id']=='-1'){
                $search_vendor = " AND i.vendor > '-1'";
            }
            else{
                $search_vendor = " AND i.vendor = '".$data['vendor_id']."'";
            }

           $sql="SELECT pos.inv_item_id AS item_id,i.item_name AS item_name,p.invoice_no AS invno,SUM(pos.inv_item_quantity) AS qty,p.invoice_date AS date,pos.inv_item_price AS price,pos.inv_item_price*(pos.inv_item_discount/100)*pos.inv_item_quantity AS discount,SUM(pos.inv_item_subTotal) AS subtotal,v.vendor_name AS vendor FROM pos_invoice_detail pos LEFT JOIN item i ON pos.inv_item_id=i.id LEFT JOIN pos_invoice p ON pos.inv_id=p.invoice_id LEFT JOIN vendor v ON v.vendor_id=i.vendor  
                WHERE ".$search_product." ".$search_category."  ".$date_range." ".$search_vendor." GROUP BY p.invoice_id,pos.inv_item_id";
                // echo $sql;exit;
            $query = $this->db->query($sql);
            return $query->rows;
        }

        public function get_lastVendor($item)
        {
            $check="SELECT * FROM po_invoice_detail WHERE inv_item_id='".$item."'";
            $query1 = $this->db->query($check);
             if($query1->num_rows > 0){ 

            $sql="SELECT v.vendor_name FROM po_invoice p left join po_invoice_detail pd ON p.invoice_id=pd.inv_id LEFT JOIN vendor v ON v.vendor_id=p.vendor_id WHERE pd.inv_item_id='".$item."' ORDER BY p.vendor_id DESC LIMIT 1 ";
            // echo $sql;
                 $query = $this->db->query($sql);

           return $vendor = $query->row['vendor_name']==NULL?0:$query->row['vendor_name'];    
       }
       else{
        return $vendor = 'No Vendor';  
       }
        }

      public function getSaleRepCollection($data)
      {
          $date_range = "";
          $rep = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "j.entry_date>='". $start_date ."' AND j.entry_date < '". $end_date ."' + interval 1 day";
                }
            }
            if(isset($data["rep_id"]) && ($data["rep_id"]!='-1')){
                $rep = " AND rep_det.salesrep_id = '".$data["rep_id"]."'";
            }
            $this->db->query("SET SQL_BIG_SELECTS=1");
        $sql="SELECT rep.salesrep_name AS name,cust.cust_name AS customer,(-1*j.journal_amount) AS amount,j.entry_date AS date,j.ref_id FROM salesrep rep LEFT JOIN salesrep_detail rep_det ON (rep_det.salesrep_id=rep.id) LEFT JOIN account_journal j ON (rep_det.ref_id=j.ref_id) LEFT JOIN customer cust ON (cust.cust_acc_id=j.acc_id) WHERE ".$date_range." ".$rep." AND j.acc_id !=-1 AND type='CUST_PAYME' GROUP BY j.acc_id ORDER BY rep_det.salesrep_id";
            // echo $sql;exit;
           $query = $this->db->query($sql);
            return $query->rows;
      }  

      public function total_amount_invoice($invoices)
      {
        $sql="SELECT sum(invoice_total) AS amount FROM pos_invoice WHERE invoice_id IN(".$invoices.")";
        // echo $sql;
        $query = $this->db->query($sql);

          $sql1="SELECT COUNT(invoice_id) AS no FROM pos_invoice WHERE invoice_id IN(".$invoices.")";
        // echo $sql;
        $query1 = $this->db->query($sql1);

               $amount = $query->row['amount']==NULL?0:$query->row['amount'];  
               $no = $query1->row['no']==NULL?0:$query1->row['no'];  
              return array("amount"=>$amount, "no"=>$no);
        }


         public function getDailySaleCashRecieve($data)
         {
             $date_range="";
             $search_customer="";
        if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "inv.invoice_date>='". $start_date ."' AND inv.invoice_date < '". $end_date ."' + interval 1 day";
                }
        if($data['customer_region']!='-1'){                
                $search_customer = " AND cust.cust_group_id = '".$data['customer_region']."'";
            }        
                $this->db->query("SET SQL_BIG_SELECTS=1");
        $sql="SELECT cust.cust_name,cust.cust_acc_id AS account_id,pos.inv_item_name AS item_name,pos.inv_item_quantity AS qty,pos.inv_item_subTotal AS amount,pos.inv_item_price AS sale_price,item_purchase_price AS purchase_price,pos.inv_item_discount AS discount,inv.invoice_no AS InvNo,date(inv.invoice_date) AS date FROM pos_invoice inv LEFT JOIN pos_invoice_detail pos ON (pos.inv_id=inv.invoice_id) LEFT JOIN customer cust ON (cust.cust_id=inv.cust_id) WHERE ".$date_range."".$search_customer." ORDER BY cust.cust_id,inv.invoice_no";
        // echo $sql;exit;
               $query = $this->db->query($sql);
            return $query->rows;
         }   

          public function getDailyExpenses($data)
     {
        $date_range="";
        $salesRep="";
        if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "j.entry_date>='". $start_date ."' AND j.entry_date < '". $end_date ."' + interval 1 day";
                }

           if($data['customer_region']!=-1)
           {
              $allCustomer="SELECT  GROUP_CONCAT(cust_id) AS ids FROM customer WHERE cust_group_id ='".$data['customer_region']."'";
             $query = $this->db->query($allCustomer);
                    $acc_id = $query->row['ids'];          

          $allIDS="SELECT  GROUP_CONCAT(DISTINCT(salesrep_id)) AS salesRep FROM pos_invoice WHERE invoice_date>='". $start_date ."' AND invoice_date < '". $end_date ."' + interval 1 day AND cust_id IN(".$acc_id.")";

             $query1 = $this->db->query($allIDS);
             $salesRep = $query1->row['salesRep'];
             if($salesRep !=NULL)
            {
              $salesRepreset="SELECT  GROUP_CONCAT(ref_id) AS ref_id FROM salesrep_detail WHERE updated_date>='". $start_date ."' AND updated_date < '". $end_date ."' + interval 1 day AND salesrep_id IN(".$salesRep.") AND type_id=4";
             $query2 = $this->db->query($salesRepreset);  
                    $allAccount = $query2->row['ref_id'];          
        $sql="SELECT (-1*j.journal_amount) AS amount,date(j.entry_date) AS date,c.acc_name AS account,salrep.salesrep_name AS saleRep FROM account_journal j LEFT JOIN account_chart c ON (c.acc_id=j.acc_id) LEFT JOIN salesrep_detail saldet ON (saldet.ref_id=j.ref_id) LEFT JOIN salesrep salrep ON (salrep.id=saldet.salesrep_id) WHERE ".$date_range." AND  j.journal_id IN(".$allAccount.")"; 
            }
            else{
             $sql="SELECT j.journal_amount AS amount,date(j.entry_date) AS date,c.acc_name AS account,salrep.salesrep_name AS saleRep FROM account_journal j LEFT JOIN account_chart c ON (c.acc_id=j.acc_id) LEFT JOIN salesrep_detail saldet ON (saldet.ref_id=j.ref_id) LEFT JOIN salesrep salrep ON (salrep.id=saldet.salesrep_id) WHERE ".$date_range." AND j.type='EXPENSE' AND j.acc_id !='-1'";   
            }
             
             // echo allIDS;exit;
             
           }
           else{
             $sql="SELECT j.journal_amount AS amount,date(j.entry_date) AS date,c.acc_name AS account,salrep.salesrep_name AS saleRep FROM account_journal j LEFT JOIN account_chart c ON (c.acc_id=j.acc_id) LEFT JOIN salesrep_detail saldet ON (saldet.ref_id=j.ref_id) LEFT JOIN salesrep salrep ON (salrep.id=saldet.salesrep_id) WHERE ".$date_range." AND j.type='EXPENSE' AND j.acc_id !='-1'";
           }     
        
        // echo $sql;exit;
               $query = $this->db->query($sql);
            return $query->rows;
     }   

     public function getCashRecieve($cust,$data)
     {
        $date_range="";
        if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "j.entry_date>='". $start_date ."' AND j.entry_date < '". $end_date ."' + interval 1 day";
                }
         $sql="SELECT COUNT(j.journal_id), SUM(-1*(j.journal_amount)) AS amount,salerep.salesrep_name AS rep_name FROM account_journal j LEFT JOIN salesrep_detail repdet ON (repdet.ref_id=j.ref_id) LEFT JOIN salesrep salerep ON (salerep.id=repdet.salesrep_id) WHERE ".$date_range." AND type='CUST_PAYME' AND acc_id =".$cust." GROUP BY salerep.salesrep_name";
         // echo $sql;
           $query = $this->db->query($sql);
             return $query->rows;
     }

     public function getcashRecievable($acc_ids,$data)
     {
        $date_range="";
        $search_customer="";
        if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "j.entry_date>='". $start_date ."' AND j.entry_date < '". $end_date ."' + interval 1 day";
                }
         if($data['customer_region']!='-1'){                
                $search_customer = " AND cust.cust_group_id = '".$data['customer_region']."'";
            }       
        $sql="SELECT SUM(-1*(j.journal_amount)) AS amount,cust_group.cust_group_name AS group_name,
                salerep.salesrep_name AS rep_name,cust.cust_name AS customer,date(j.entry_date) AS date, 
                j.acc_id AS acc_id FROM account_journal j 
                LEFT JOIN salesrep_detail repdet ON (repdet.ref_id=j.ref_id) 
                LEFT JOIN salesrep salerep ON (salerep.id=repdet.salesrep_id) 
                LEFT JOIN customer cust ON (cust.cust_acc_id=j.acc_id) 
                LEFT JOIN customer_groups cust_group ON (cust.cust_group_id=cust_group.id) 
                WHERE ".$date_range." ".$search_customer." AND type='CUST_PAYME' AND acc_id NOT IN(".$acc_ids.") AND acc_id !=-1 GROUP BY cust.cust_name order BY cust_group.cust_group_name ASC";
         //echo $sql;exit;
         $query = $this->db->query($sql);
             return $query->rows;
     } 
        public function getAllcashRecievable($data)
     {
        $date_range="";$search_customer="";
        if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "entry_date>='". $start_date ."' AND entry_date < '". $end_date ."' + interval 1 day";
                }
                   if($data['customer_region']!='-1'){                
                $search_customer = " AND c.cust_group_id = '".$data['customer_region']."'";
            }  
        $sql="SELECT SUM(-1*(j.journal_amount)) AS amount FROM account_journal j LEFT JOIN customer c ON(c.cust_acc_id=j.acc_id) WHERE ".$date_range." AND type='CUST_PAYME' AND j.acc_id !=-1 ".$search_customer." ";
            // echo $sql;exit;
         $query = $this->db->query($sql);
             return $vendor = $query->row['amount']==NULL?0:$query->row['amount'];    
     }

     public function getTotalRemainingBalance($data)
     {
               $date_range="";
             $search_customer="";
        if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "inv.invoice_date>='". $start_date ."' AND inv.invoice_date < '". $end_date ."' + interval 1 day";
                }
        if($data['customer_region']!='-1'){                
                $search_customer = "  cust_group_id = '".$data['customer_region']."'";
            }        
            else{
                $search_customer = "  cust_group_id != ''";
            }
             $this->db->query("SET group_concat_max_len=99999999");
             $sql="SELECT GROUP_CONCAT(cust_acc_id) AS acc_id FROM customer WHERE  ".$search_customer."  AND cust_acc_id !=-1";
            // echo $sql;
         $query = $this->db->query($sql);
         $acc_id = $query->row['acc_id'];
         
         $sql1="SELECT SUM(journal_amount) AS amount FROM account_journal WHERE acc_id IN(".$acc_id.") AND entry_date <= '". $end_date ."'";
         // echo $sql1;exit;
         $query = $this->db->query($sql1);
         return $amount = $query->row['amount']==NULL?0:$query->row['amount']; 
     }

     public function getDailyPurchase($data)
     {
          $date_range="";
             $search_customer="";
        if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "inv.invoice_date>='". $start_date ."' AND inv.invoice_date < '". $end_date ."' + interval 1 day";
                }      
                $this->db->query("SET SQL_BIG_SELECTS=1");
        $sql="SELECT vend.vendor_name,vend.vendor_id AS v_account_id,i.item_name AS item_name,po.inv_item_quantity AS qty,po.inv_item_subTotal AS amount,po.inv_item_price AS purchase_price,po.inv_item_sprice AS sale_price,po.inv_item_discount AS discount,inv.invoice_no AS InvNo,date(inv.invoice_date) AS date FROM po_invoice inv LEFT JOIN po_invoice_detail po ON (po.inv_id=inv.invoice_id) LEFT JOIN item i ON(i.id=po.inv_item_id) LEFT JOIN vendor vend ON (vend.vendor_id=inv.vendor_id)WHERE ".$date_range." ORDER BY vend.vendor_id,inv.invoice_no";
        // echo $sql;exit;
               $query = $this->db->query($sql);
            return $query->rows;
     }

     public function getAllInvoicesPayment($data)
     {
        $date_range="";
        $date_range1="";
        $date_range2="";
        if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = "invoice_date>='". $start_date ."' AND invoice_date < '". $end_date ."' + interval 1 day";
                    $date_range1 = "entry_date>='". $start_date ."' AND entry_date < '". $end_date ."' + interval 1 day";
                    $date_range2 = "p.invoice_date>='". $start_date ."' AND p.invoice_date < '". $end_date ."' + interval 1 day";
                } 
        $Ssql="SELECT SUM(invoice_total) AS total,SUM(discount_invoice) AS discount,SUM(invoice_paid) AS paid FROM pos_invoice WHERE ".$date_range." AND sale_return=0";

        $TotalSale="SELECT SUM(pos.inv_item_subTotal) AS sale,SUM(pos.inv_item_quantity*pos.item_purchase_price) AS purchase FROM pos_invoice_detail pos LEFT JOIN pos_invoice p ON (p.invoice_id=pos.inv_id) WHERE ".$date_range2." AND p.sale_return=0";

        $query4 = $this->db->query($TotalSale);

         $TotalSaleRetrun="SELECT SUM(pos.inv_item_subTotal) AS saleReturnSubTotal,SUM(p.invoice_paid) AS SaleReturn,SUM(pos.inv_item_quantity*pos.item_purchase_price) AS SaleReturnPurchase FROM pos_invoice_detail pos LEFT JOIN pos_invoice p ON (p.invoice_id=pos.inv_id) WHERE ".$date_range2." AND p.sale_return=1";
         // echo $TotalSaleRetrun;exit;
         $query5 = $this->db->query($TotalSaleRetrun);
         $TotalDisc="SELECT SUM(discount+discount_invoice) AS TotalDiscount FROM pos_invoice WHERE ".$date_range." AND sale_return=0";

        // echo $TotalDisc;exit;
         $query6 = $this->db->query($TotalDisc);
        $SRetsql="SELECT SUM(invoice_total) AS SRETtotal,SUM(discount_invoice) AS deduction,SUM(invoice_paid) AS paid FROM pos_invoice WHERE ".$date_range." AND sale_return=1";
        // echo $SRetsql;exit;
             $query = $this->db->query($Ssql);
             $query2 = $this->db->query($SRetsql);
        $expense="SELECT SUM(-1*journal_amount) AS expense FROM account_journal WHERE ".$date_range1." AND type='EXPENSE' AND acc_id=-1";     
            // return $query->rows;

        //Vendor Amount
        $vendorAmount="SELECT SUM(journal_amount) AS vendorAmount FROM account_journal WHERE ".$date_range1." AND type='VENDOR_PAY' AND acc_id !=-1";

        // echo $vendorAmount;exit;
         $query3 = $this->db->query($vendorAmount);


             $query1 = $this->db->query($expense);
             $total=$query->row['total']==NULL?0:$query->row['total'];
             $SRETtotal=$query2->row['SRETtotal']==NULL?0:$query2->row['SRETtotal'];
             $discount=$query->row['discount']==NULL?0:$query->row['discount'];
             $deduction=$query2->row['deduction']==NULL?0:$query2->row['deduction'];
             $paid=$query->row['paid']==NULL?0:$query->row['paid'];
             $expense=$query1->row['expense']==NULL?0:$query1->row['expense'];
             $vendorAmount=$query3->row['vendorAmount']==NULL?0:$query3->row['vendorAmount'];

             $TotalSaleAmount=$query4->row['sale']==NULL?0:$query4->row['sale'];
             $TotalPurchaseAmount=$query4->row['purchase']==NULL?0:$query4->row['purchase'];
             $TotalDisc=$query6->row['TotalDiscount']==NULL?0:$query6->row['TotalDiscount'];
             $TotalSaleReturn=$query5->row['SaleReturn']==NULL?0:$query5->row['SaleReturn'];
             $SaleReturnSubTot=$query5->row['saleReturnSubTotal']==NULL?0:$query5->row['saleReturnSubTotal'];
             $TotalSaleReturnAfterDisc=$SaleReturnSubTot-$TotalSaleReturn;
             $NetProfit=$TotalSaleAmount-$TotalPurchaseAmount-$TotalDisc-$TotalSaleReturn+(-1*$TotalSaleReturnAfterDisc);
             // echo $NetProfit;exit;
             return array("total"=>$total, "discount"=>$discount,"SRETtotal"=>$SRETtotal, "deduction"=>$deduction, "paid"=>$paid,"expense"=>$expense,"vendorAmount"=>$vendorAmount,"NetProfit"=>$NetProfit);

     }

      public function getCustBalance($data)
       {
        $customer=$data['customer_id'];
        $exe="SELECT cust_acc_id FROM customer WHERE cust_id='".$customer."'";
         $query = $this->db->query($exe);
         $AccID = $query->row['cust_acc_id'];     
         // echo $AccID;exit;
           $sql = "SELECT sum(journal_amount) as balance FROM ".DB_PREFIX."account_journal
                        WHERE acc_id='".$AccID."'";
                        // echo $sql;exit;
            $query1 = $this->db->query($sql);
            $_balance = $query1->row['balance']==NULL?0:$query1->row['balance'];
            return $_balance;     
       }

     // public function vendor_register_report($data)
     // {

     // } 

     public function get_totalAssetRetailValue()
     {
        $sql="SELECT SUM((w.qty*w.conv_from)*i.sale_price) AS sprice,SUM((w.qty*w.conv_from)*i.avg_cost) AS cost FROM item_warehouse w LEFT JOIN item i ON (i.id=w.item_id)";
        // echo $sql;exit;
             $query = $this->db->query($sql);
             $sprice=$query->row['sprice']==NULL?0:$query->row['sprice'];
             $avg_cost=$query->row['cost']==NULL?0:$query->row['cost'];
         return array("sprice"=>$sprice, "cost"=>$avg_cost);
     }

    public function getAllExpenses($data)
    {
        $date_range='';
        if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = " AND j.entry_date>='". $start_date ."' AND j.entry_date < '". $end_date ."' + interval 1 day";
                } 
        $sql="SELECT j.acc_id,date(j.entry_date) AS date,ac.acc_name, j.journal_details,j.journal_amount,j.entry_date FROM `account_journal` j LEFT JOIN account_chart ac ON(ac.acc_id=j.acc_id) WHERE j.type='EXPENSE' AND j.acc_id !=-1".$date_range;
        // echo $sql;exit;
             $query = $this->db->query($sql);
              return $query->rows;
    }  
}
?>
