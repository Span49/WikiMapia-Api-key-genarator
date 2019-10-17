<?php
/* Database settings */
$db = [
  'settings' => [
    'host' => "localhost",
    'user' => "Логин",
    'pass' => "Пароль",
    'base' => "База",
    'char' => "utf8"
  ]
];

$dsn = "mysql:host=".$db['settings']['host'].";dbname=".$db['settings']['base'].";charset=UTF8";
$opt = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES   => false,
];
$go = new PDO($dsn, $db['settings']['user'], $db['settings']['pass'], $opt);
$go->exec("SET NAMES utf8");
if($go -> connect_errno) die('ERROR -> '.$go -> connect_error);
?>