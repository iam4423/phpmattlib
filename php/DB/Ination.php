<?php

/**
 * Page ination class
 * 
 * @copyright (c) 2013, Matt Holmes
 * 
 * @author Matt Holmes <iam4423@gmail.com>
 */

abstract class DB_Ination
{
  /**
   * @var DB object
   */
  protected $_db;
  
  /**
   * @var array
   */
  protected $_results = array();
  
  /**
   * @var string
   */
  protected $_resultType = 'array';
  
  /**
   * @var int
   */
  protected $_resultCurEntry = 0;
  
  /**
   * @var int
   */
  protected $_limit = 10;
  
  /**
   * @var int 
   */
  protected $_offset = 0;
  
  /**
   * @var int
   */
  protected $_pageNumber = 1;
  
   /////////////////////////////////////////////////
  //            SETUP AND SETTINGS               //
 /////////////////////////////////////////////////
  
  /**
   * Set the database object to be used
   * 
   * @param DB $db
   * 
   * @return \Ination
   */
  public function setDB(DB $db)
  {
    $this->_db = $db;
    
    return $this;
  }
  
  /**
   * Set the current page number (1 as default)
   * 
   * @param int $pageNumber
   * 
   * @return \Ination
   */
  public function setPage($pageNumber)
  {
    $this->_pageNumber = (int)$pageNumber;
    
    if ($this->_pageNumber < 1)
      $this->_pageNumber = 1;
    
    return $this;
  }
  
  /**
   * Set the number of results per page (default of 10)
   * 
   * @param int $limit
   * 
   * @return \Ination
   */
  public function setLimit($limit)
  {
    $this->_limit = (int)$limit;
    
    return $this;
  }
  
   /////////////////////////////////////////////////
  //            BUILD QUERY AND RUN              //
 /////////////////////////////////////////////////
  
  /**
   * Run the query
   * 
   * @return \Ination
   */
  public function run()
  {
    $this->_calcOffset();
    
    $query = $this->_buildQuery() . '
      LIMIT ' . $this->_limit . '
      OFFSET ' . $this->_offset;
    
    if ($this->_resultType == 'array') {
      
      $this->_results = 
        $this->_db->queryFetchAll($query, 'Page Ination Query');
    } else {
      
      $this->_results = 
        $this->_db->queryFetchObjects($query, $this->_resultType);
    }
    
    return $this;
  }
  
  /**
   * Calculate the result offset for the current page
   */
  protected function _calcOffset()
  {
    $this->_offset = $this->_limit * ($this->_pageNumber - 1);
  }
  
  /**
   * Build and return the query for the current page
   * 
   * @return string
   */
  protected abstract function _buildQuery();
  
  /**
   * 
   */
  protected abstract function _getSelectSQL();
  
  protected abstract function _getFromSql();
  
  protected abstract function _getWhereSql();
  
  protected abstract function _getOrderSql();

   /////////////////////////////////////////////////
  //            RETURN RESULTS AND DATA          //
 /////////////////////////////////////////////////
  
  /**
   * Return result in given position
   * 
   * @param int $i
   * 
   * @return boolean|array|Objext
   */
  public function getResult($i)
  {
    if (key_exists($i, $this->_results)) {
      
      return $this->_results[$i];
    }
    
    return false;
  }
  
  /**
   * Return the next result
   * 
   * @return boolean|array|Object
   */
  public function getCurResult()
  {
    if (!empty($this->_results[$this->_resultCurEntry])) {
      
      return $this->_results[$this->_resultCurEntry];
    }
    
    return false;
  }
  
  /**
   * Return the previous result
   * 
   * @return boolean|array|Object
   */
  public function getPreviousResult()
  {
    if (!empty($this->_results[($this->_resultCurEntry - 1)])) {
      
      return $this->_results[($this->_resultCurEntry - 1)];
    }
    
    return false;
  }
  
  /**
   * Get the tolal number of results returned by the query
   * 
   * @return int
   */
  public function getTotalCount()
  {
    return $this->_db->firstResult("SELECT FOUND_ROWS()");
  }
  
  /**
   * Coutn results in this page
   * 
   * @return type
   */
  public function getReturnedCount()
  {
    return count($this->_results);
  }
  
  /**
   * Increment the entry possition
   * 
   * @return \Ination
   */
  public function stepForward()
  {
    ++$this->_resultCurEntry;
    
    return $this;
  }
  
  /**
   * Go back to the last entry
   * 
   * @return \Ination
   */
  public function stepBack()
  {
    --$this->_resultCurEntry;
    
    return $this;
  }
  
  /**
   * Check that the current step exists
   * 
   * @return booleaan
   */
  public function stepCheck()
  {
    if ($this->_resultCurEntry < count($this->_results)) {
      
      return true;
    }
    
    return false;
  }
  
   /////////////////////////////////////////////////
  //            PAGE INATION STUFF               //
 /////////////////////////////////////////////////
  
  /**
   * Count tolal number of available pages
   * 
   * @return int
   */
  public function countPages()
  {
    return ceil($this->getTotalCount() / $this->_limit);
  }
  
}