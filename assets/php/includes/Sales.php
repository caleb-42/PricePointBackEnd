<?php
error_reporting(E_ALL ^ E_STRICT);

class Sales extends Db_object{


    function calc_stock_inventory($read, $stk,$arithmetic = "add",$newqty = 0){
        $stkbought = $read[3][0]["stockbought"];
        $stkremain = $read[3][0]["stockremain"];

        if($arithmetic == "add"){
            $stkbought = $stkbought + $stk;
            $stkremain = $stkremain + $stk;
        }elseif($arithmetic == "upd"){
            $stkbought = $stkbought - $stk + $newqty;
            $stkremain = $stkremain - $stk + $newqty;
        }else{
            $stkbought = $stkbought - $stk;
            $stkremain = $stkremain - $stk;
        }
        
        if($stkremain < 0){
            $fail = array("failed","success", "values will cause negative stock");
            return $fail;
        }else{
            $stkarr = [$stkbought,$stkremain];
            return $stkarr;
        }
    }
    
    function final_updatestock($pro, $stkbought,$stkremain,$exp,$entryclosestdate,$numentr){
        $user = parent::update_object("stock", ["stockbought", "stockremain","entry_date","entries"], [$stkbought,$stkremain,$entryclosestdate,$numentr], ["expirydate", "productname"], [$exp, $pro]); 
        return $user;
    }

    function sum_product_stock($pro,$closestdate, $stock_edit = "true"){
        $product_stocks = parent::select_object("stock",["productname"],[$pro]);

        $total_product_stocks = 0;

        foreach($product_stocks[3] as $stock){
            //echo $s["stockremain"];
            $total_product_stocks += intval($stock["stockremain"]);
        }
        
        $user = $stock_edit ? parent::update_object("products", ["stock", "expiry_date"], [$total_product_stocks, $closestdate], ["product_name"], [$pro]) : parent::update_object("products", ["stock"], [$total_product_stocks], ["product_name"], [$pro]);

        return $user;
    }

    function find_closest_expiry_date($pro, $exp = "none"){
        //$expiry_dates = parent::select_object("stockentry",["product","stocktype"],[$pro, "new"]);
        $expiry_dates = parent::select_object("stock",["productname"],[$pro]);
        $expiry_dates  = $expiry_dates[3];
        $con = 0;
        $arr = array();

        foreach($expiry_dates as $date){
            $arr[$con] = intval($date["stockremain"]) > 0 ? $date["expirydate"] : "0000-00-00";
            $con++;
        }
        $exp != "none" ? array_push($arr, $exp) : null;
        

        $todays_date = parent::get_todays_date();
        $closestdate = parent::find_closest_date($arr, $todays_date,"after");
        return $closestdate;
    }

    function find_closest_entry_date($pro, $exp){
        $entry_dates = parent::select_object("stockentry",["product","stocktype"],[$pro, "new"]);
        $entry_dates = $entry_dates[3];
        $con = 0;
        $entryarr = array();
        foreach($entry_dates as $edate){
            $entryarr[$con]=$edate["entry_date"];
            $con++;
        }

        $todays_date = parent::get_todays_date();

        $entryclosestdate = parent::find_closest_date($entryarr, $todays_date,"before");
        return $entryclosestdate;
    }

    
    function get_stockentry_no($exp, $pro){
        $users = parent::select_object("stockentry",["stockexpiry_date","product", "stocktype"],[$exp, $pro, "new"]);
        $number_of_entries = count($users[3]);
        return $number_of_entries;
    }
    
    function correct_stock($stockarr, $prod, $qty, $stk){
        $iniqty = $qty;
        
        $expdateaffected = [];
        for($i = 0; $i < count($stockarr); $i++){
            if(intval($stockarr[$i]['stockremain']) > $qty){

                $stockarr[$i]['stocksold'] = $qty + intval($stockarr[$i]['stocksold']);
                $stockarr[$i]['stockremain'] = intval($stockarr[$i]['stockremain']) - $qty;
                $expdateaffected[$i]['qty'] = $qty;
                $expdateaffected[$i]['date'] = $stockarr[$i]['expirydate'];
                $qty = 0;
                //array_push($expdateaffected, $stockarr[$i]['expirydate']);
                break;

            }else{
                $stockarr[$i]['stocksold'] = intval($stockarr[$i]['stockremain']) + intval($stockarr[$i]['stocksold']);
                $qty = $qty - intval($stockarr[$i]['stockremain']);
                $expdateaffected[$i]['qty'] = intval($stockarr[$i]['stockremain']);
                $expdateaffected[$i]['date'] = $stockarr[$i]['expirydate'];
                $stockarr[$i]['stockremain'] = 0;
                //array_push($expdateaffected, $stockarr[$i]['expirydate']);
            }
        }
        
        if($qty != 0){
            $error = 'you cant sell above ' . ($iniqty - $qty) . ' because ' . ($stk - ($iniqty - $qty)) . ' of ' . $prod .  ' stocks have expired';
            
            return ['failed', $error, []];
        }else{
            foreach($stockarr as $obj){
                parent::update_object("stock", ['stocksold', 'stockremain'], [$obj['stocksold'], $obj['stockremain']], ['id'], [$obj['id']]);
            }
            $closest_expiry_date = $this->find_closest_expiry_date($prod);
            $update = $this->sum_product_stock($prod,$closest_expiry_date);
            return ['success', 'inserted', $expdateaffected];
        }
    }
    
    function correct_sales($salesarr,$prod, $qty, $totalcost = 0, $paidamt, $priceSystem, $unitPrice = 0, $invno, $stk_result = null){

        $totalamt = intval($salesarr[0]['totalamt']);
        $totalamt = $totalamt + $totalcost;
        //echo $paidamt;
        if($paidamt === 'default'){
            $paidamt = intval($salesarr[0]['paidamt']);
        }

        $outbal = intval($salesarr[0]['outbal']) + intval($salesarr[0]['paidamt']) - intval($salesarr[0]['totalamt']);
        $newoutbal = $outbal + $totalamt - $paidamt;

        if($stk_result != null){
            $expdateaffected = $stk_result[count($stk_result) - 1];
            //print_r($expdateaffected);
            foreach($stk_result as $sale){
                parent::insert_object("sales", ['invoiceno', 'customer_name', 'product', 'quantity', 'expirydate', 'unitprice','totalprice', 'totalamt', 'paidamt', 'outbal', 'pricetype', 'saleref', 'salesdate', 'paymethod'], [$invno,$salesarr[0]['customer_name'], $prod, $sale['qty'], $sale['date'],$unitPrice, (intval($sale['qty']) * $unitPrice), $totalamt, $paidamt, $newoutbal, $priceSystem, $salesarr[0]['saleref'], $salesarr[0]['salesdate'], $salesarr[0]['paymethod']]);
            }
        }

        foreach($salesarr as $sale){
            parent::update_object("sales", ['totalamt', 'paidamt', 'outbal'], [$totalamt, $paidamt, ($totalamt - $paidamt)], ['id'], [$sale['id']]);
            $result = parent::update_object("customerinvoice", ['outbalance','totalamt', 'totalpaid'], [$newoutbal, $totalamt, $paidamt], ['invno'], [$sale['invoiceno']]);
            //return $result;
        } 
 
        $inv = parent::select_object("customerinvoice", ['invno'],[$salesarr[0]['invoiceno']]);
        $json = parent::select_object("customerinvoice", ['customer'],[$salesarr[0]['customer_name']]);
        
        $diff = $newoutbal-intval($salesarr[0]['outbal']);

        foreach($json[3] as $sale){
            
            if((intval($sale['id']) > intval($inv[3][0]['id'])) && ($sale['invno'] != $inv[3][0]['invno'])){
                //parent::update_object("sales", ['outbal'], [(intval($sale['outbal']) + $diff)], ['id'], [$sale['id']]);

               // print("[" . $sale['outbal'] . " , " . $diff . "]");
 
                parent::update_object("customerinvoice", ['outbalance'], [(intval($sale['outbalance']) + $diff)], ['invno'], [$sale['invno']]);
                
            }
        }
        $json = parent::select_object("customers", ['customer_name'],[$salesarr[0]['customer_name']]);

        $result = parent::update_object("customers", ['outstanding_balance'], [(intval($json[3][0]['outstanding_balance']) + $newoutbal-intval($salesarr[0]['outbal']))], ['customer_name'], [$salesarr[0]['customer_name']]);

        return $result;
        
    }

    function insert_object($arr){
        //print_r($arr);
        $qty = isset($arr["quantity"]) ? intval($arr["quantity"]) : null;
        $invno = $arr['invoiceno'];
        $prod = $arr['product_name'];
        $paidamt = strlen($arr['paidamt']) == 0 ? 'default' : intval($arr['paidamt']) ;
        $stock = intval($arr['stock']);
        $priceSystem = $arr['pricesystem'];

        $retailPrice = $arr['rprice'] != '' ?intval($arr['rprice']) : null;
        $wholesalePrice = $arr['wprice'] != '' ? intval($arr['wprice']) : null;
        $unitPrice = 0;

        $totalcost = $priceSystem == 'wholesale' ? ($qty * $wholesalePrice) : ($qty * $retailPrice);

        $unitPrice = $priceSystem == 'wholesale' ? $wholesalePrice : $retailPrice;
        
        $prodstocks = parent::select_object("stock", ['productname'],[$prod]);
        $prodsales = parent::select_object("sales", ['invoiceno'],[$invno]);
        //print_r($prodstocks[3]);
        $splicearr = [];
        for($i = 0; $i < count($prodstocks[3]); $i++){
            if(strtotime($prodstocks[3][$i]['expirydate']) > strtotime(parent::get_todays_date()) && intval($prodstocks[3][$i]['stockremain']) > 0){
                array_push($splicearr, $prodstocks[3][$i]);
            }
        }
        usort($splicearr, function($a, $b)
        {
            return strcmp($a['expirydate'], $b['expirydate']);
        });
        
        //print_r($splicearr);

        if($qty != null){
            $stk_result = $this->correct_stock($splicearr,$prod, $qty, $stock);
            //print_r($stk_result);
            if($stk_result[0] == "success"){
                $sales_result = $this->correct_sales($prodsales[3],$prod, $qty, $totalcost, $paidamt, $priceSystem, $unitPrice,$invno, $stk_result[2]);
                return $sales_result[2];
            }
        }else{
            $sales_result = $this->correct_sales($prodsales[3],$prod, $qty, $totalcost, $paidamt, $priceSystem, $unitPrice,$invno);
            //print_r($sales_result);
            if($sales_result[1] == "success"){
                return $sales_result[2];
            }
        }
        //print_r($stk_result);
    }


    function update_object($arr){
        print_r($arr);
        $newqty = isset($arr["quantity"]) ? intval($arr["quantity"]) : 0;
        $col = array_keys($arr);
        array_pop($col);
        $wcol = 'id';
        $val = array_values($arr);
        $wval = array_pop($val);
        $dbsales = parent::select_object("sales", ["id"],[$wval])[3][0];
        $frmqty = $dbsales['quantity'];
        $product = $dbsales['product'];
        $expdate = $dbsales['expirydate']; 
        $newqty = $newqty == 0 ? $frmqty : $newqty;

        $stk_result = $this->correct_stock($product, $expdate, $frmqty, $newqty);
        
        
    }
    
    function delete_object($arr){
        print_r($arr);
        $sales = parent::select_object("sales",["id"],[$arr['id']]);
        $prod = $sales[3][0]['product'];
        $qty = intval($sales[3][0]['quantity']);
        $exp = $sales[3][0]['expirydate'];

        $totalAmt = intval($sales[3][0]['totalamt']);
        $totalCost = intval($sales[3][0]['totalprice']);
        $outbal = intval($sales[3][0]['outbal']);
        $inv = $sales[3][0]['invoiceno'];

        $salesno = parent::select_object("sales",["invoiceno"],[$inv]);

        if(count($salesno[3]) < 2){
            return "cannot delete last sale";
        }

        $stk_result = $this->delete_stock($prod, $qty, $exp);
        if($stk_result[0] == "success"){
            $this->delete_inventory($totalAmt, $totalCost, $outbal, $inv, $arr['id']);
            
        }
        
        
    }
    
    function delete_stock($prod, $qty, $exp){

        $stock = parent::select_object("stock",["productname","expirydate"],[$prod, $exp]);
        $stksold = $stock[3] ? intval($stock[3][0]['stocksold']) : 0;
        $stkbgt = $stock[3] ? intval($stock[3][0]['stockbought']) : 0;
        $stkrem = $stock[3] ? intval($stock[3][0]['stockremain']) : 0;

        print_r($stock);
        echo $stksold . " vs " . $qty;
        
        if($stksold > $qty){
            $stksold -= $qty;
            $stkrem += $qty;
            parent::update_object("stock", ["stocksold","stockremain"], [$stksold, $stkrem], ["productname","expirydate"], [$prod, $exp]); 
            $closest_expiry_date = $this->find_closest_expiry_date($prod);
            $this->sum_product_stock($prod,$closest_expiry_date);
            return ['success', 'inserted'];
        }else{
            $stkarr = parent::select_object("stockentry",["product","stockexpiry_date","stocktype"],[$prod, $exp, "old"]);

            usort($stkarr[3], function($a, $b)
            {
                return strcmp($b['entry_date'], $a['entry_date']);
            });

            print_r($stkarr[3]);
            foreach($stkarr[3] as $stk){
                $stkbgt += $stk['stockno'];
                $stksold += $stk['stockno'];
                $stk['stocktype'] = 'new';
                parent::update_object("stockentry", ["stocktype"], ["new"], ["id"], [$stk['id']]); 
                if($stksold > $qty){
                    if($stock[3]){
                        $stksold -= $qty;
                        $stkrem += $qty;
                        
                        parent::update_object("stock", ["stockbought","stocksold","stockremain", "entry_date", "entries"], [$stkbgt, $stksold, $stkrem, $this->find_closest_entry_date($prod, $exp), $this->get_stockentry_no($exp, $prod)], ["productname","expirydate"], [$prod, $exp]);

                        $closest_expiry_date = $this->find_closest_expiry_date($prod);
                        $this->sum_product_stock($prod,$closest_expiry_date);
                    }else{
                        $stksold -= $qty;
                        $stkrem += $qty;
                        parent::insert_object("stock", ["productname","expirydate","stockbought","stocksold","stockremain", "entry_date", "entries"], [$prod, $exp, $stkbgt, $stksold, $stkrem,$this->find_closest_entry_date($prod, $exp), $this->get_stockentry_no($exp, $prod)]); 
                       
                        $closest_expiry_date = $this->find_closest_expiry_date($prod, $exp);

                        echo $closest_expiry_date;

                        $this->sum_product_stock($prod,$closest_expiry_date);
                    }
                    return ['success', 'inserted'];
                }
            }
        } 
    }

    function delete_inventory($totalamt, $totalcost, $outbal, $inv, $id){
        $prodsales = parent::select_object("sales", ['invoiceno'],[$inv]);
        $users = parent::delete_object("sales", ["id"], [$id]);
        $salesarr = $prodsales[3];
        $totalamt -= $totalcost;

        $outbal -=  $totalcost;

        foreach($salesarr as $sale){
            parent::update_object("sales", ['totalamt', 'outbal'], [$totalamt, $outbal], ['id'], [$sale['id']]);
            $result = parent::update_object("customerinvoice", ['outbalance','totalamt'], [$outbal, $totalamt], ['invno'], [$sale['invoiceno']]);
            //return $result;
        } 
 
        $inv = parent::select_object("customerinvoice", ['invno'],[$salesarr[0]['invoiceno']]);
        $json = parent::select_object("customerinvoice", ['customer'],[$salesarr[0]['customer_name']]);
        
        foreach($json[3] as $sale){
            
            if((intval($sale['id']) > intval($inv[3][0]['id'])) && ($sale['invno'] != $inv[3][0]['invno'])){

                parent::update_object("customerinvoice", ['outbalance'], [(intval($sale['outbalance']) - $totalcost)], ['invno'], [$sale['invno']]);
                
            }
        }
        $json = parent::select_object("customers", ['customer_name'],[$salesarr[0]['customer_name']]);

        $result = parent::update_object("customers", ['outstanding_balance'], [(intval($json[3][0]['outstanding_balance']) - $totalcost)], ['customer_name'], [$salesarr[0]['customer_name']]);
        
    }
    
}

?>
