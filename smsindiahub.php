<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

define("URL", "http://cloud.smsindiahub.in/vendorsms/pushsms.aspx");
define("USERNAME", "superValuePharma");
define("PASSWORD", "Oditek123@");
//define("SENDERID", "SMSHUB");
//define("SENDERID", "WEBSMS");
define("SENDERID", "SVPHAR");

class SMSService {

    // constructor
    function __construct() {
        
    }

    // destructor
    function __destruct() {
        // $this->close();
    }

    public function curl_get($url, array $get = NULL, array $options = array()) {
        $defaults = array(
            CURLOPT_URL => $url . (strpos($url, '?') === FALSE ? '?' : '') . http_build_query($get),
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 4
        );
        $ch = curl_init();
        curl_setopt_array($ch, ($options + $defaults));
        if (!$result = curl_exec($ch)) {
            trigger_error(curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

    public function executeSMS($url, $mobile, $str) {
        $fields = array(
            'user' => USERNAME,
            'password' => PASSWORD,
            'msisdn' => $mobile,
            'sid' => SENDERID,
            'msg' => $str,
            'fl' => "0",
            'gwid' => "2",
        );
        $ret = $this->curl_get($url, $fields);
        $result = json_decode($ret, true);
        return $result['ErrorMessage'];
    }

    public function registrationSuccess($mobile, $name, $authid) {
        $str = "\"Dear " . $name . ", You have successfully registered with supervaluepharma.com. Your username is " . $mobile . " and password/auth id is " . $authid . ". Please login supervaluepharma.com\"";
        $ret = $this->executeSMS(URL, $mobile, $str);
        return $ret;
    }

    public function mobUpdateSuccess($mobile, $name) {
        $str = "\"Dear " . $name . ", Your profile has updated successfully. Your new username is " . $mobile . ".\"";
        $ret = $this->executeSMS(URL, $mobile, $str);
        return $ret;
    }

    public function orderStatus($mobile, $name, $orderid, $statusid) {
        switch ($statusid) {
            case 1:
//                $status = 'New';
                break;
            case 2:
                $status = 'Approved';
                break;
            case 3:
                $status = 'Dispatched';
                break;
            case 4:
                $status = 'Delivered';
                break;
            case 5:
                $status = 'Cancelled';
                break;
            case 6:
                $status = 'Returned';
                break;
        }
        if ($statusid == 1) {
            $str = "\"Dear " . $name . ", Your order " . $orderid . " has confirmed. The order will be delivered soon. Thank you for shopping at supervaluepharma.com\"";
        } else if ($statusid == 5 || $statusid == 6) {
            $str = "\"Dear " . $name . ", Your order " . $orderid . " has " . $status . ". Please contact supervaluepharma.com\"";
        } else {
            $str = "\"Dear " . $name . ", Your order " . $orderid . " has " . $status . ". Thank you for shopping at supervaluepharma.com\"";
        }
        $ret = $this->executeSMS(URL, $mobile, $str);
        return $ret;
    }

    public function promotion($mobile, $name, $message) {
        $str = "\"Dear " . $name . ", " . $message . ". Thank you for shopping at supervaluepharma.com \"";
        $ret = $this->executeSMS(URL, $mobile, $str);
        return $ret;
    }

}

?>