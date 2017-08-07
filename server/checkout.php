<?php

use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;

require '../server/start.php';


$price = 0;
$product = 'Dotacja';

if(isset($_POST['price'])){
    $price = $_POST['price'];
}else {
    $price = $_POST['price_oth'];
}

if($price == 0){
    die();
}

$shipping = 0.00;
$total = $price+$shipping;

$payer = new Payer();
$payer->setPaymentMethod('paypal');

$item = new Item();
$item->setName($product);
$item->setCurrency('PLN');
$item->setQuantity(1);
$item->setPrice($price);

$itemList = new ItemList();
$itemList->setItems([$item]);


$details = new Details();
$details->setShipping($shipping);
$details->setSubtotal($price);


$amount = new Amount();
$amount->setCurrency('PLN');
$amount->setTotal($total);
$amount->setDetails($details);


$transaction = new Transaction();
$transaction->setAmount($amount);
$transaction->setItemList($itemList);
$transaction->setDescription('PayForSth');
$transaction->setInvoiceNumber(uniqid());

$redirect = new RedirectUrls();
$redirect->setReturnUrl(START_URL.'/?success=true');
$redirect->setCancelUrl(START_URL.'/?success=false');


$payment = new Payment();
$payment->setIntent('sale');
$payment->setPayer($payer);
$payment->setRedirectUrls($redirect);
$payment->setTransactions([$transaction]);


try {
    $payment->create($paypal);
} catch (Exception $e) {
    die($e);
}


$approvalUrl = $payment->getApprovalLink();
header("Location: {$approvalUrl}");

?>
