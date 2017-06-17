<?php
  // echo "sleep for 5s \n";
  // sleep(5);
  // echo "wake up";
  // die("x");
  function average($arr){
    return ($arr) ? array_sum($arr)/count($arr) : 0;
  }
  require_once('Poloniex.php');
  // die("C");
  $json = file_get_contents('config.json');
  $configObject = json_decode($json);
  $loanLimits = (array)$configObject->loanLimits;
  $loanMax = (array)$configObject->loanMax;
  $lent = false;
  $polo = new Poloniex();
  $openLoans = $polo->get_open_loan_offers();
  if (!empty($openLoans)) {
    foreach ($openLoans as $key => $cur) {
      $message[] = "Clearing open $key loans.";
      // print_r($cur);
      foreach ($cur as $key => $loan) {
        $polo->cancel_loan_offer($loan['id']);
      }
    }
  }
  $messages = array();
  date_default_timezone_set("CST6CDT");
  $messages[] = "Updated: " . date('Y-m-d h:i a');
  foreach ($loanLimits as $currency => $limit) {

    $rates = array();
    $offers = $polo->get_loan_orders($currency)['offers'];
    for ($i=0; $i < 20; $i++) {
      $offer = $offers[$i];
      $rate = $offer['rate']*100;
      $rates[] = $rate;
    }
    $average = round(average($rates),4);
    $messages[] = "Average rate of $currency: $average%";
    $rate = $average;
    $balances = $polo->get_balances();
    $currentLendingBalance = 0;
    if (isset($balances['lending'][$currency])) {
      $currentLendingBalance = $balances['lending'][$currency];
    }
    if ($currentLendingBalance >= $limit) {
      $loanAmount = $currentLendingBalance;
      if ($currentLendingBalance > $loanMax[$currency]) {
        $loanAmount = $loanMax[$currency];
      }
      $messages[] = "Loan $loanAmount $currency at $average%";
      $days = 2;
      if ($average > 0.25 && $currency == 'BTC') {
        $days = 7;
      }
      $success = $polo->create_loan_offer($loanAmount, $rate, $currency, $days);
      if ($success['success']) {
        $messages[] = $success['message'];
      }else{
        $messages[] = "Error: ".$success['error'];
      }
      $lent = true;
    }
  }
  $activeLoans = $polo->get_active_loans();
  $data = array(
    'lent' => $lent,
    'messages' => $messages,
    'activeLoans' => $activeLoans['provided']
  );
  if(is_array($data)){
    extract($data);
  }

  if (isset($_GET['min'])) {
    require 'min_view.php';
  }else{
    require 'view.php';
  }
  $file = 'log.txt';
  $content = "";
  foreach ($messages as $key => $m) {
    $content .= "$m\n\n";
  }
  // Open the file to get existing content
  $current = file_put_contents($file,$content);
?>
