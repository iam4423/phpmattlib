<?php

/**
 * Debug timer that can be used to check how long scripts and database queries 
 * take to execute
 * 
 * @copyright (c) 2012, Matt Holmes
 * 
 * @author Matt Holmes <iam4423@gmail.com>
 */

class Debug_Timer
{
  
  /**
   * @var int $_time
   */
  protected $_totalTime = 0;
  
  /**
   * @var int $_startTime
   */
  protected $_startTime = 0;
  
  /**
   * @var int $_endtime
   */
  protected $_endTime = 0;
  
  
  
  /**
   * 
   * @param type $start
   */
  public function __construct($start = false)
  {
    if ($start) {
      $this->start();
    }
  }
  
  /**
   * 
   */
  public function start()
  {
    $this->_startTime = microtime(true);
  }
  
  /**
   * 
   */
  public function pause()
  {
    $this->_endTime = microtime(true);
    
    //save time to total
    $this->_totalTime += ($this->_endTime - $this->_startTime);
    
    //reset timer
    $this->_startTime = 0;
    $this->_endTime   = 0;
  }
  
  /**
   * 
   */
  public function reset()
  {
    //reset all timers
    $this->_totalTime = 0;
    $this->_startTime = 0;
    $this->_endTime   = 0;
  }
  
  public function getTime()
  {
    if ($this->_startTime != 0) {
      $currentTime = microtime(true);
      
      $this->_totalTime += ($currentTime - $this->_startTime);
      
      $this->_startTime = $currentTime;
    }
    
    return $this->_totalTime;
  }
}