<?php

require_once('Vending.php');
require_once('VendingMachine.php');

//$vm = new Vending();
//$vm->setCoinTypes([10, 50, 100]);
//$vm->depositMoney(160);
//echo implode('、', $vm->changeMoney()) . '<br>'; // [100, 50, 10]
//
//$vm = new Vending();
//$vm->setCoinTypes([10, 100]);
//$vm->depositMoney(160);
//echo implode('、', $vm->changeMoney()) . '<br>'; // [100, 10, 10, 10, 10, 10]
//
//$vm = new Vending();
//$vm->setCoinTypes([10, 50, 100]);
//echo implode('、', $vm->changeMoney()) . '<br>'; // []

$vm = new Vending();
$vm->setCoinTypes([100]);
$vm->depositMoney(160);
echo implode('、', $vm->changeMoney()) . '<br>';
$vm->setCoinTypes([100, 50, 10]);
echo implode('、', $vm->changeMoney()) . '<br>';

//$vm = new VendingMachine();
//$vm->setCoinTypes([10, 100]);
//$vm->depositMoney(160);
//echo implode('、', $vm->changeMoney()) . '<br>';
//
//$vm = new VendingMachine();
//$vm->setCoinTypes([10, 50, 100]);
//echo implode('、', $vm->changeMoney()) . '<br>';
