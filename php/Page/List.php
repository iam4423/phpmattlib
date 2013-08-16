<?php

/**
 * Page list object
 * 
 * @copyright (c) 2013, PHPMatt.com
 * 
 * @author Matt Holmes <iam4423@gmail.com>
 */

class Page_List extends DB_Ination
{
  /**
   * @var string 
   */
  protected $_pageStatus = Page_Const::STATUS_ALL;
  
  /**
   * @var string 
   */
  protected $_searchString = '';
  
  /**
   * Setup default settings for list object
   */
  public function __construct()
  {
    $this->_resultType = 'Page';
    $this->_limit      = 20;
  }
  
  /**
   * Set the desired page status
   * 
   * @param string $status
   * 
   * @return \Page_List
   */
  public function setStatus($status)
  {
    if (Page_Const::statusValid($status))
      $this->_pageStatus = $status;
    
    return $this;
  }
  
  /**
   * Set the search string
   * 
   * @param string $sString
   * 
   * @return \Page_List
   */
  public function setSearchString($sString)
  {
    $this->_searchString = (string)$sString;
    
    return $this;
  }
  
  /**
   * Build the select statement
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
   * Build select part of query
   * 
   * @return string
   */
  protected function _getSelectSQL() 
  {
    return "SELECT SQL_CALC_FOUND_ROWS
      " . Page::SELECT_SQL . "
      " . ((!empty($this->_searchString)) ? ",
      MATCH(
        title,
        body
      ) AGAINST(
        " . $this->_db->data($this->_searchString). " IN BOOLEAN MODE
      ) as priority
      ": "") . "
      ";
  }
  
  /**
   * Build from part of query
   * 
   * @return string
   */
  protected function _getFromSql() 
  {
    return "FROM
      [PREFX]page_dynamic
      ";
  }

  /**
   * Build order part of query
   * 
   * @return string
   */
  protected function _getOrderSql() {
    return "ORDER BY
      id DESC";
  }

  /**
   * Build where part of query
   * 
   * @return string
   */
  protected function _getWhereSql() 
  {
    $where = "
      WHERE 
        1
      ";
    
    if ($this->_pageStatus != Page_Const::STATUS_DELETED)
      $where .= "
        AND
          status != " . $this->_db->data(Page_Const::STATUS_DELETED) . "
        ";
    
    if ($this->_pageStatus != Page_Const::STATUS_ALL)
      $where .= "
        AND
          status = " . $this->_db->data($this->_pageStatus) . "
        ";
    
    if (!empty($this->_searchString))
      $where .= "
        AND
          MATCH(
            title,
            body
          ) AGAINST(
            " . $this->_db->data($this->_searchString) . " IN BOOLEAN MODE
          )
        ";
    
    return $where;
  }
}