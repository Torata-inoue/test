<?php

require_once('Vending.php');
require_once('VendingMachine.php');
require_once('V2.php');

//$vm = new V2();
//$vm->setCoinTypes([10, 100]);
//$vm->depositMoney([10, 100, 100]);  // [50]

//$vm = new V2();
//$vm->setCoinTypes([10, 100]);
//$vm->depositMoney([10, 50, 100]);
//$vm->changeMoney(); // [100, 50, 10] or [100, 10]?

$vm = new V2();
$vm->setCoinTypes([10, 50, 100]);
$vm->putMoney([50]); // []
$vm->depositMoney([10, 10, 10, 10, 10, 100, 10]);  // []
var_dump($vm->changeMoney()); // [100, 50, 10]

