<?php

function __autoload($class_name){
include "includes/" . $class_name . ".php";
}
getstock();
function getstock(){
    $stockentry = DbHandler::select_cmd([
        "table" => 'stockentry',
        "qcol" => ["stocktype"],
        "qval" =>["new"],
        "cond" => ["="]
    ]);
    //print_r($stock[3]);
    $prodbystockno = [];
    
    foreach( $stockentry[3] as $pro){
        $prodn = $pro["product"] . "&" .$pro["stockexpiry_date"];
        $prod = [$pro["stockno"]];
        if(array_key_exists($prodn, $prodbystockno)) { 
            array_push($prodbystockno[$prodn], $pro["stockno"]);
        }else{
            $prodbystockno += [$prodn => $prod];
        }
    }
    
    $prodstockdiff = [];
    
    foreach( $prodbystockno as $key => $num){
        $prodbystockno[$key] = array_sum($num);
    }
        
    $stock = DbHandler::select_cmd([
        "table" => 'stock'
    ]);
    
    foreach( $prodbystockno as $key => $num){
        $stkvar = explode("&", $key);
        foreach($stock[3] as $stk){
            $diff = intval($num) - intval($stk["stockbought"]);
            $rleft = $diff + intval($stk["stockremain"]);
            if($stk["productname"] == $stkvar[0] && $stk["expirydate"] == $stkvar[1]){
                $prodstockdiff += [$key => ["wstkbght" => $stk["stockbought"], "rstkbght" => $num,"wstkleft" => $stk["stockremain"], "rstkleft" => $rleft, "diff" => $diff]];
            }
        }
        
    }
    $prodstkleft = [];
    
    foreach($prodstockdiff as $key => $num){
        $stkvar = explode("&", $key);
        $user = DbHandler::update_cmd([
            "table" => "stock",
            "col" => ["stockbought","stockremain"],
            "val" => [$num["rstkbght"], $num["rstkleft"]],
            "cond" => ["="],
            "qcol" => ["productname", "expirydate"],
            "qval" => [$stkvar[0],$stkvar[1]],
            "conj" => ["AND"]
        ]);
        if(array_key_exists($stkvar[0], $prodstkleft)){
            array_push($prodstkleft[$stkvar[0]], $num["rstkleft"]);
        }else{
            $prodstkleft += [$stkvar[0] => [$num["rstkleft"]]];
        }
    }
    
    foreach($prodstkleft as $key => $num){
        $user = DbHandler::update_cmd([
            "table" => "products",
            "col" => ["stock"],
            "val" => [array_sum($num)],
            "cond" => ["="],
            "qcol" => ["product_name"],
            "qval" => [$key]
        ]);
    }
    //print_r($prodbystockno);
    //print_r($prodstockdiff);
    print_r($prodstkleft);
}
/*get all stock bought; add all stock bought; replace stock bought by minusing the diff from both bought and remain replace what is left in product*/
?>

