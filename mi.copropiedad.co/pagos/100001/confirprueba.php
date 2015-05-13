<?php
$data = array("response_code_pol"=>"1", "phone"=>"", "additional_value"=>"0.00", "test"=>"1", "transaction_date"=>"2015-05-07 12:49:30", "cc_number"=>"************1111", "cc_holder"=>"APPROVED", "error_code_bank"=>"", "billing_country"=>"CO", "bank_referenced_name"=>"", "description"=>"Pago administracion del mes de mayo", "administrative_fee_tax"=>"0.00", "value"=>"52000.00", "administrative_fee"=>"0.00", "payment_method_type"=>"2", "office_phone"=>"", "email_buyer"=>"gvelasquez@teleinte.com", "response_message_pol"=>"APPROVED", "error_message_bank"=>"", "shipping_city"=>"", "transaction_id"=>"b8f381bf-fde2-4612-a73a-e24cad300f3c", "sign"=>"012d8d873857970abaa3999b2f719526", "tax"=>"0.00", "transaction_bank_id"=>"00000000", "payment_method"=>"250", "billing_address"=>"0011223344abc", "payment_method_name"=>"VISA", "pse_bank"=>"", "state_pol"=>"4", "date"=>"2015.05.07 12:49:30", "nickname_buyer"=>"", "reference_pol"=>"6982780", "currency"=>"COP", "risk"=>"0.0", "shipping_address"=>"", "bank_id"=>"250", "payment_request_state"=>"A", "customer_number"=>"", "administrative_fee_base"=>"0.00", "attempts"=>"1", "merchant_id"=>"500238", "exchange_rate"=>"1.00", "shipping_country"=>"", "installments_number"=>"1", "franchise"=>"VISA", "payment_method_id"=>"2", "extra1"=>"", "extra2"=>"", "antifraudMerchantId"=>"", "extra3"=>"", "commision_pol_currency"=>"", "nickname_seller"=>"", "ip"=>"201.245.115.46", "commision_pol"=>"0.00", "airline_code"=>"", "billing_city"=>"B", "pse_reference1"=>"", "cus"=>"00000000", "reference_sale"=>"4c5babbfefec37f93efceb259ec1fafe", "authorization_code"=>"00000000", "pse_reference3"=>"", "pse_reference2"=>""); 
$url = 'https://app.copropiedad.co/api/payu/pagarpol/';



function httpPost($url,$params)
{
  $postData = '';
   //create name value pairs seperated by &
   foreach($params as $k => $v) 
   { 
      $postData .= $k . '='.$v.'&'; 
   }
   rtrim($postData, '&');
 
    $ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, false); 
    curl_setopt($ch, CURLOPT_POST, count($postData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    
 
    $output=curl_exec($ch);
 
    curl_close($ch);
    return $output;
 
}
var_dump(httpPost($url, $data));
?>