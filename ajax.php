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
}
