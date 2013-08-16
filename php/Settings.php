<?php

/**
 * Global defenitions and settings
 * 
 * @copyright (c) 2013, PHPMatt.com
 * 
 * @author Matt Holmes <iam4423@gmail.com>
 */

/** SITE SETTINGS **/
define('SITE_NAME', 'PHPMatt.com');
define('GLOBAL_KEYWORDS', 'keyword');

/** PATH SETTINGS **/
define('ROOT',     'http://localhost/PHPMatt/');
define('RESOURCE', 'http://localhost/PHPMatt/Public/');

/** DATABASE SETTINGS **/
define('DB_HOST',  '127.0.0.1');
define('DB_NAME',  'phpmatt');
define('DB_USER',  'root');
define('DB_PASS',  '');
define('DB_PREFX', '');

/** ERROR LEVEL SETTINGS **/
define('MODE_LIVE',  1);
define('MODE_BETA',  2);
define('MODE_ALPHA', 3);
define('ERROR_MODE', MODE_ALPHA);