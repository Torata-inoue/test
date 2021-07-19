<?php


interface Rationaler
{
    public function display(): string;
    public function number(int $round): float;
    public function add($attr): Rationaler;
    public function sub($attr): Rationaler;
}
