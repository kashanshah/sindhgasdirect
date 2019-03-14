<?php
include_once("common.php");
if(isset($_REQUEST["action"])){
    if($_REQUEST["action"] == "checkavailabilityphone"){
        $phone = '';
        $ret = array("code"=>-1, "msg"=>"");
        foreach ($_REQUEST as $key=>$val)
            $$key=$val;
        if($phone == ''){
            $ret = array(
                "code" => -1,
                "msg" => "Please enter phone number"
            );
        }
        else{
            $ret = checkavailability('users', 'Number', $phone);
            if($ret > 0){
                $ret = array(
                    "code" => -2,
                    "msg" => "A user with this phone number already exists: " . getValue('users', 'name', 'Number', $phone)
                );
            }
            else{
                $ret = array(
                    "code" => 0,
                    "msg" => "success"
                );
            }
        }
        echo json_encode($ret);
    }
    else if($_REQUEST["action"] == "markasread"){
        $phone = '';
        $ret = array("code"=>-1, "msg"=>"");
        foreach ($_REQUEST as $key=>$val)
            $$key=$val;
        if(!is_numeric($ID) && $ID == 0){
            $ret = array(
                "code" => -1,
                "msg" => "Please provide a correct notification ID"
            );
        }
        else{
            $ret = mysql_query("UPDATE notifications SET Status=1 WHERE ID=".$ID);
            $ret = array(
                "code" => 0,
                "msg" => "success"
            );
        }
        echo json_encode($ret);
    }
}
