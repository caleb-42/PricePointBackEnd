<?php
$arr = $_GET;
//print_r($arr);
$newarr = array();

require_once "myphp-backup-master/myphp-backup.php";

function __autoload($class_name){
    include "includes/" . $class_name . ".php";
}

if(is_ajax_request()){
    call_user_func($_GET["act"], array($_GET["arg"]));
}

function select_operation($arg){
    $dbobj = new Db_object();
    $args = explode(",",$arg[0]);
    if(count($args) == 1){
        $users = Db_object::select_object($args[0]);
    }else{
        $tb = array_shift($args);
        $sign = count($args) % 2 != 0 ? array_pop($args) : "=";
        $sign = explode("^",$sign);
        $num = count($args)/2;
        $args = array_chunk($args,$num); 
        $col = $args[0];
        $val = $args[1];
        //print_r($args);
        $users = Db_object::select_object($tb,$col,$val,$sign);
        //print_r($users[3]);
    }
    !empty($users[3]) ? print json_encode($users[3]) : null;
}

function add_operation($arg){
    $arg = str_replace("^", "&", $arg[0]);
    $arr = array();
    parse_str($arg, $arr);
    //print_r($arr);
    $class_name = array_pop($arr);
    //print_r($class_name);
    $dbObj = new $class_name();
    echo $dbObj->insert_object($arr);
    backdata();
}

function update_operation($arg){
    $arg = str_replace("^", "&", $arg[0]);
    $arr = array();
    parse_str($arg, $arr);
    /*print_r($arr);*/
    $class_name = array_pop($arr);
    //print_r($class_name);
    $dbObj = new $class_name();
    echo $dbObj->update_object($arr);
    backdata();
}

function delete_operation($arg){
    $arg = str_replace("^", "&", $arg[0]);
    $arr = array();
    parse_str($arg, $arr);
    print_r($arr);
    $class_name = array_pop($arr);
    print_r($class_name);
    $dbObj = new $class_name();
    $dbObj->delete_object($arr);
    backdata();
}

function backdata(){
    date_default_timezone_set('Africa/Lagos');
    $date = date("Y/m/d h:i:s:a", time());
    $name = $_GET["sess"] . $date;
    backup($name);
}

function is_ajax_request(){
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}

?>
