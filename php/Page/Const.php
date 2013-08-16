<?php

/**
 * Constant class and validation checkers for pages
 * 
 * @copyright (c) 2013, PHPMatt.com
 * 
 * @author Matt Holmes <iam4423@gmail.com>
 */

class Page_Const
{
  const STATUS_ALL     = 'A';
  const STATUS_LIVE    = 'L';
  const STATUS_PENDING = 'P';
  const STATUS_SANDBOX = 'S';
  const STATUS_DELETED = 'D';
  
  /**
   * Check if given status is valid
   * 
   * @param string $status
   * 
   * @return boolean
   */
  public static function statusValid($status)
  {
    $statuses = array(
      self::STATUS_ALL,
      self::STATUS_DELETED,
      self::STATUS_LIVE,
      self::STATUS_PENDING,
      self::STATUS_SANDBOX,
    );
    
    return (boolean)in_array($status, $statuses);
  }
}