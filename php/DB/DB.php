<?php

/**
 * Database object abstract class
 * 
 * @copyright (c) 2012, Matt Holmes
 * 
 * @author Matt Holmes <iam4423@gmail.com>
 */

abstract class DB
{
  
  /**
   * @var \PDO $_db
   */
  protected $_db;
  
  /**
   * @var \Debug_Timer $_timer
   */
  protected $_timer;
  
  /**
   * @var array $_conInfo
   */
  protected $_conInfo = array();
  
  /**
   * @var int $_queryCount
   */
  protected $_queryCount = 0;
  
  /**
   * @var array $_queries
   */
  protected $_queries = array();
  /**
   * Setup the connection details instantiation of the class
   * 
   * @param string $dbHost
   * @param string $dbName
   * @param string $dbUser
   * @param string $dbPass
   */
  abstract public function __construct($dbHost, $dbName, $dbUser, $dbPass);
  
  /**
   * connect to the database
   * 
   * @return boolean
   */
  abstract protected function _connect();
  
  /**
   * Set the error mode
   * 
   * @param int $mode
   */
  abstract protected function _errorHandler($mode);
  
  /**
   * Sanitize input
   * 
   * @param string $input
   * @return string
   */
  abstract public function data($input);
  
  /**
   * Get id of last inserted row
   * 
   * @return int
   */
  abstract public function getInsertId();
  
  /**
   * Sanitize input to be used as a link
   * 
   * @param string $input
   * @return string
   */
  abstract public function hrefData($input);
  
  /**
   * 
   */
  abstract public function firstResult($query, $qName = 'unNamedQuery');
  
  /**
   * Perform a query (INSERT, UPDATE ETC)
   * 
   * @param string $statement
   * @return PDO
   */
  abstract public function query($statement, $qName = 'unNamedQuery');
  
  /**
   * Fetch single result
   * 
   * @param PDOStatement $query
   * @return array
   */
  abstract protected function _fetch(PDOStatement $query);
  
  /**
   * Fetch all results
   * 
   * @param PDOStatement $query
   * @return array
   */
  abstract protected function _fetchAll(PDOStatement $query);
  
  /**
   * return a single result for your sql statement
   * 
   * @param string $statement
   * @return array
   */
  abstract public function queryFetch($statement, $qName = 'unNamedQuery');
  
  /**
   * Retuen all results for your sql statement ina nested array
   * 
   * @param string $statement
   * @return array
   */
  abstract public function queryFetchAll($statement, $qName = 'unNamedQuery');
  
  /**
   * Count the number of rows returned from a statement
   * 
   * @param string $statement
   * @return int
   */
  abstract public function rowCount($statement);
  
  /**
   * 
   */
  abstract public function queryCount();
  
  /**
   * $return the total time take for queries
   * 
   * @return int
   */
  abstract public function getTimer();
  
  /**
   * return array of queries
   * 
   * @return array
   */
  abstract public function listQueries();
  
  /*------------------------ OBJECTS ------------------------*/
  
  /**
   * Instantiate an object from the database
   * 
   * @param PDOStatement $query
   * @param string $class
   * @return boolean|Object
   */
  abstract public function fetchObject(PDOStatement $query, $class, $construct = null);
  
  /**
   * fetch multiple objects from the database
   * 
   * @param PDOStatement $query
   * @param string $class
   * @param array $construct
   * 
   * @return array
   */
  abstract public function fetchObjects(PDOStatement $query, $class, $construct = null);
    
  /**
   * Return an instance of an object from the database
   * 
   * @param string $statement
   * @param string $class
   * @return boolean|Object
   */
  abstract public function queryFetchObject($statement, $class, $construct = null);
  
  /**
   * Return multiple object instances from the database
   * 
   * @param string $statement
   * @param string $class
   * @param array $construct
   * 
   * @return array
   */
  abstract public function queryFetchObjects($statement, $class, $construct = null);
}
