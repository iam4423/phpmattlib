<?php

/**
 * Admin Log List
 * 
 * @copyright (c) 2013, PHPMatt.com
 * 
 * @author Matt Holmes <iam4423@gmail.com>
 */

class Admin_Log_List extends DB_Ination
{  
  /**
   * Construct class
   */
  public function __construct()
  {
    $this->_limit      = 50;
    $this->_resultType = "Admin_Log";
  }
  
  /**
   * Build SQL select statement
   * 
   * @return string
   */
  protected function _buildQuery() 
  {
    return $this->_getSelectSQL()
      . $this->_getFromSql()
      . $this->_getWhereSql()
      . $this->_getOrderSql();
  }

  /**
   * Build select part of SQL statement
   * 
   * @return string
   */
  protected function _getSelectSQL() 
  {
    return "
      SELECT SQL_CALC_FOUND_ROWS
        " . Admin_Log::SELECT_SQL . "
      ";
  }
  
  /**
   * Build from part of SQL statement
   * 
   * @return string
   */
  protected function _getFromSql() 
  {
    return "
      FROM
        admin_log
      ";
  }  

  /**
   * Build where part of SQL statement
   * 
   * @return string
   */
  protected function _getWhereSql() 
  {
    return "
      WHERE
        1
      ";
  }
  
  /**
   * Build order part of SQL statement
   * 
   * @return string
   */
  protected function _getOrderSql() 
  {
    return "
      ORDER BY
        id DESC
      ";
  }
}