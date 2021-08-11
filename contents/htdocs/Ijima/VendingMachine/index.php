<?php

require_once('VendingMachine3.php');

$vendingMachine3 = new VendingMachine3();

$vendingMachine3->setCoinTypes([10, 50, 100, 1000]);
echo $vendingMachine3->useVendingMachine([1000, 50 ,10], 100000);
