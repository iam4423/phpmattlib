<?php
/**
 * Manager class for admin log
 * 
 * @copyright (c) 2013, PHPMatt.com
 * 
 * @author Matt Holmes <iam4423@gmail.com>
 */

class Admin_Log_Manager
{
  /**
   * Add an admin log entry
   * 
   * @param DB $db
   * @param int $adminId
   * @param string $url
   * @param string $message
   * @param boolean $flagged
   */
  public static function add(
    DB $db,
    $adminId,
    $url,
    $message,
    $flagged = false
    )
  {
    $db->query("
      INSERT INTO
        [PREFX]admin_log
      (
        adminId,
        url,
        message,
        flagged,
        date
      ) VALUES (
        " . $db->data($adminId) . ",
        " . $db->data($url) . ",
        " . $db->data($message) . ",
        " . $db->data($flagged) . ",
        " . $db->data(time()) . "
      )
      ", "Insert Admin Log Entry");
  }
}