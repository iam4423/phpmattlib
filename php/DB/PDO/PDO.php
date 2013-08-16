<?php

/**
 * Handler class to aid in the use of PDO database management
 * Geared up to work with MySQL
 * 
 * @copyright (c) 2012, Matt Holmes
 * 
 * @author Matt Holmes <iam4423@gmail.com>
 * 
 * INSTRUCTIONS AT BOTTOM OF FILE
 */

class DB_PDO extends DB
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
  public function __construct($dbHost, $dbName, $dbUser, $dbPass)
  {
    $this->_conInfo = array(
      'name' => $dbName,
      'host' => $dbHost,
      'user' => $dbUser,
      'pass' => $dbPass,
      );
    
    $this->_timer = new Debug_Timer();
  }
  
  /**
   * connect to the database
   * 
   * @return boolean
   */
  protected function _connect()
  {
    $this->_timer->start();
    
    if (!empty($this->_conInfo)) {
      $this->_db = new PDO('mysql:host=' . $this->_conInfo['host'] . ';
                           dbname=' . $this->_conInfo['name'],
                           $this->_conInfo['user'],
                           $this->_conInfo['pass']
                           );
      /*
       * 1 = show errors (production mode)
       * 0 = dont show errors (live enviroment)
       */
      $this->_errorHandler(1);
    }
    
    $this->_timer->pause();
    return true;
  }
  
  /**
   * Set the error mode
   * 
   * @param int $mode
   */
  protected function _errorHandler($mode)
  {
    if ($mode == 1) {
      $this->_db->setAttribute(PDO::ATTR_ERRMODE, 1);
    }
  }
  
  /**
   * Sanitize input
   * 
   * @param string $input
   * @return string
   */
  public function data($input)
  {
    if (empty($this->_db)) {
      $this->_connect();
    }
    
    return $this->_db->quote($input);
  }
  
  /**
   * Return id of last inserted row
   * 
   * @return int
   */
  public function getInsertId()
  {
    return $this->_db->lastInsertId();
  }
    
  /**
   * Sanitize input to be used as a link
   * 
   * @param string $input
   * @return string
   */
  public function hrefData($input)
  {
    $input = Secure_Sanitize::link($input);
    if (empty($this->_db)) {
      $this->_connect();
    }
    return $this->_db->quote($input);
  }
  
  /**
   * Return the first collumn of the first row
   * @param string $query
   * @param string $qName
   * 
   * @return mixed
   */
  public function firstResult($query, $qName = 'unNamedQuery') 
  {
    $statement = $this->query($query, $qName);
    
    return $statement->fetchColumn(0);
  }
  
  /**
   * Perform a query (INSERT, UPDATE ETC)
   * 
   * @param string $statement
   * @return PDO
   */
  public function query($statement, $qName = 'unNamedQuery')
  {
    //connect where needed
    if (empty($this->_db)) {
      $this->_connect();
    }
    
    //add to query rosta
    $this->_queries[] = array(
      'name'  => $qName,
      'query' => $statement,
    );
    
    $this->_queryCount++;
    
    //replace prefix's
    $statement = str_replace('[PREFX]', DB_PREFX, $statement);
   
    $this->_timer->start();
    $statement = $this->_db->query($statement);
    $this->_timer->pause();
    
    return $statement;
  }
  
  /**
   * Fetch single result
   * 
   * @param PDOStatement $query
   * @return array
   */
  protected function _fetch(PDOStatement $query)
  {
    return $query->fetch(PDO::FETCH_ASSOC);
  }
  
  /**
   * Fetch all results
   * 
   * @param PDOStatement $query
   * @return array
   */
  protected function _fetchAll(PDOStatement $query)
  {
    return $query->fetchAll(PDO::FETCH_ASSOC);
  }
  
  /**
   * return a single result for your sql statement
   * 
   * @param string $statement
   * @return array
   */
  public function queryFetch($statement, $qName = 'unNamedQuery')
  {
    return $this->_fetch($this->query($statement, $qName));
  }
  
  /**
   * Retuen all results for your sql statement ina nested array
   * 
   * @param string $statement
   * @return array
   */
  public function queryFetchAll($statement, $qName = 'unNamedQuery')
  {
    return $this->_fetchAll($this->query($statement, $qName));
  }
  
  /**
   * Count the number of rows returned from a statement
   * 
   * @param string $statement
   * @return int
   */
  public function rowCount($statement)
  {
    $query = $this->query($statement);
    return $query->rowCount();
  }
  
  /**
   * 
   */
  public function queryCount()
  {
    return $this->_queryCount;
  }
  
  /**
   * $return the total time take for queries
   * 
   * @return int
   */
  public function getTimer()
  {
    return $this->_timer->getTime();
  }
  
  /**
   * return array of queries
   * 
   * @return array
   */
  public function listQueries()
  {
    return $this->_queries;
  }
  
  /*------------------------ PREPARED STATEMENTS ------------------------*/
  
  /**
   * Use a prepared statement to perform a query
   * 
   * @param string $statement
   * @param array $parameters
   * @return /PDO
   */
  public function prepQuery($statement, array $parameters)
  {
    $query = $this->_db->prepare($statement);
    
    return $query->execute($perameters);
            
  }
  
  /**
   * Use a prepared statement to perform a query and retun all results in a 
   * nested array
   * 
   * @param string $statement
   * @param array $parameters
   * @return array
   */
  public function prepQueryFetchAll($statement, array $parameters)
  {
    $query = $this->prepQuery($statement, $parameters);
    
    return $query->fetchAll(PDO::FETCH_ASSOC);
  }
  
  /*------------------------ OBJECTS ------------------------*/
  
  /**
   * Instantiate an object from the database
   * 
   * @param PDOStatement $query
   * @param string $class
   * @return boolean|Object
   */
  public function fetchObject(PDOStatement $query, $class, $construct = null)
  {
    if (!empty($construct)) {
      $object = $query->fetchObject($class, $construct);
    } else {
      $object = $query->fetchObject($class);
    }
        
    if ($object instanceof $class) {
      return $object;
    }
    
    return false;
  }
  
  /**
   * fetch multiple objects from the database
   * 
   * @param PDOStatement $query
   * @param string $class
   * @param array $construct
   * 
   * @return array
   */
  public function fetchObjects(PDOStatement $query, $class, $construct = null)
  {
    //output array
    $objs = array();
    
    do {
      
      //load object
      if (!empty($construct)) {
        $object = $query->fetchObject($class, $construct);
      } else {
        $object = $query->fetchObject($class);
      }
      
      $continue = false;
      
      //add to output array
      if (!empty($object)) {
        
        $objs[] = $object;
        
        $continue = true;
      }
    } while ($continue);
    
    return $objs;
  }
    
  /**
   * Return an instance of an object from the database
   * 
   * @param string $statement
   * @param string $class
   * @return boolean|Object
   */
  public function queryFetchObject($statement, $class, $construct = null)
  {    
    return $this->fetchObject($this->query($statement, 
                                           'Load ' . $class . ' Object'), 
                              $class, 
                              $construct);
  }
  
  /**
   * Return multiple object instances from the database
   * 
   * @param string $statement
   * @param string $class
   * @param array $construct
   * 
   * @return array
   */
  public function queryFetchObjects($statement, $class, $construct = null)
  {    
    return $this->fetchObjects($this->query($statement, 
                                           'Load ' . $class . ' Object'), 
                              $class, 
                              $construct);
  }
}
