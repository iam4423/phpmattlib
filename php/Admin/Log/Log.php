<?php
/**
 * Admin Log data class
 * 
 * @copyright (c) 2013, PHPMatt.com
 * 
 * @author Matt Holmes <iam4423@gmail.com>
 */

class Admin_Log extends DB_Updater
{

  const SELECT_SQL = "
    `id` as _id,
    `adminId` as _adminId,
    `url` as _url,
    `message` as _message,
    `flagged` as _flagged,
    `date` as _date
    ";

  /**
   * @var int $_id
   */
  protected $_id = 0;
  
  /**
   * @var int $_adminId
   */
  protected $_adminId = 0;
  
  /**
   * @var string $_url
   */
  protected $_url = '';
  
  /**
   * @var string $_message
   */
  protected $_message = '';
  
  /**
   * @var boolean $_flagged
   */
  protected $_flagged = false;
  
  /**
   * @var int
   */
  protected $_date = 0;
  

  /**
   * getter for id attribute
   *
   * @return int
   */
  public function getId()
  {
    return $this->_id;
  }
  
  /**
   * getter for adminId attribute
   *
   * @return int
   */
  public function getAdminId()
  {
    return $this->_adminId;
  }
  
  /**
   * getter for url attribute
   *
   * @return string
   */
  public function getUrl()
  {
    return $this->_url;
  }
  
  /**
   * getter for message attribute
   *
   * @return string
   */
  public function getMessage()
  {
    return $this->_message;
  }
  
  /**
   * getter for flagged attribute
   *
   * @return boolean
   */
  public function getFlagged()
  {
    return $this->_flagged;
  }
  
  /**
   * Get Date attribute
   * 
   * @param boolean $format
   * 
   * @return int/string
   */
  public function getDate($format = false)
  {
    if ($format)
      return date('r', $this->_date);
    
    return $this->_date;
  }
  
  /**
   * Return array of object data
   * 
   * (return) array
   */
  public function toArray()
  {
    return array(
      'id'      => $this->getId(),
      'adminId' => $this->getAdminId(),
      'url'     => $this->getUrl(),
      'message' => $this->getMessage(),
      'flagged' => $this->getFlagged(),
      'date'    => $this->getDate(true),
      );
  }
}