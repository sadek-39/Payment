<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Api\Amount;
use PayPal\Api\Details;

class PaymentController extends Controller
{
    public function execute(){
        // After Step 1
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'ARDHUwgDXQb870kZ6HtvT-8CPdQqXqf3fnf3xofE1zZQ_PnuG8OnxJxfgXVm-b5jHlHpN5gRVPXwRP7L',     // ClientID
                'EGPvnIkyKtuL1vZmRKhmx6BtexWBJJpTnJu9MFNS5_ScmhkFhjQ7An-YwbS87MZh6Bw59Qzis74Ynzh0'      // ClientSecret
            )
        );
        $paymentId = request('paymentId');
        $payment = Payment::get($paymentId, $apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId(request('PayerID'));

        $transaction = new Transaction();
        $amount = new Amount();
        $details = new Details();

        $details->setShipping(2.2)
                ->setTax(1.3)
                ->setSubtotal(17.50);
        
        $amount->setCurrency('USD');
        $amount->setTotal(21);
        $amount->setDetails($details);
        $transaction->setAmount($amount);

        $result = $payment->execute($execution, $apiContext);

        return $result;
    }
}

