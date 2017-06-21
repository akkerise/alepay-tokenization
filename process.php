<?php
session_start();
require 'config.php';
require 'Lib/Alepay.php';
require 'Lib/ConnectDB/Database.php';
/**
 * $params = array(
 * 'customerToken' =>  $tokenization,    // put customer's token
 * 'orderCode' =>  'order-123',
 * 'amount' =>  '1000000',
 * 'currency' =>  'VND',
 * 'orderDescription' => 'Mua ai phôn 8',
 * 'returnUrl' =>  $this->callbackUrl,
 * 'cancelUrl' =>  'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/demo-alepay',
 * 'paymentHours' =>  5
 * );
 * return $params;
 */
$alepay = new Alepay($config);
$data = [];
$action = @$_REQUEST['action'];
parse_str(file_get_contents('php://input'), $params);

$db = new Database();
// Checkout with tokenization need $_SESSION equivalent logged in
if (!isset($_SESSION['customerid'])){
    echo "Bạn không có customerid !";
    echo "<pre>";var_dump($_SESSION);echo "</pre>";die();
}
// $dataUser bring token
$dataUser = $db->getDataByCustomerId(DB_TABLENAME,$_SESSION['customerid']);

$data['customerToken'] = $dataUser['token'];
$data['orderCode'] = 'order-' . time();
$data['amount'] = '16000000';
$data['currency'] = 'VND';
$data['orderDescription'] = 'Mua iPorn 88';
$data['returnUrl'] = URL_CALLBACK;
$data['cancelUrl'] = URL_CALLBACK;
$data['paymentHours'] = 48;

foreach ($data as $k => $v) {
    if (empty($v)) {
        $alepay->return_json("NOK", "Bắt buộc phải nhập/chọn tham số [ " . $k . " ]");
        die();
    }
}
switch ($action) {
    case 'sendTokenizationPayment':
        $result = $alepay->sendTokenizationPayment($data);
        break;
    default:
        $result = $alepay->sendTokenizationPayment($data);
}
if (isset($result) && !empty($result->checkoutUrl)) {
    $alepay->return_json('OK', 'Thành công', $result->checkoutUrl);

} else {
    $alepay->return_json($result->errorCode, $result->errorDescription);
}