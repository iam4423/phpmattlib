<?php
/**
 * Description
 * 
 * @copyright (c) 2013, PHPMatt.com
 * 
 * @author Matt Holmes <iam4423@gmail.com>
 */

require 'Settings.php';
require 'FunctionLib.php';
require 'AutoLoad.php';

Session::start();

$boot = new BootStrap();

$mdb = new DB_PDO(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$ldb =& $mdb;

$PageData = array(
  'title' => '',
  'description' => 'Default Description',
  'keyWords' => 'Default Keywords',
);