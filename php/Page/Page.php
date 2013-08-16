<?php

/**
 * Description
 * 
 * @copyright (c) 2013, PHPMatt.com
 * 
 * @author Matt Holmes <iam4423@gmail.com>
 */


class Page extends DB_Updater
{

  const SELECT_SQL = "
    `id` as _id,
    `title` as _title,
    `link` as _link,
    `body` as _body,
    `keywords` as _keywords,
    `description` as _description,
    `status` as _status
    ";

  /**
   * @var int $_id
   */
  protected $_id = 0;
  
  /**
   * @var string $_title
   */
  protected $_title = '';
  
  /**
   * @var string $_link
   */
  protected $_link = '';
  
  /**
   * @var string $_body
   */
  protected $_body = '';
  
  /**
   * @var string $_keywords
   */
  protected $_keywords = '';
  
  /**
   * @var string $_description
   */
  protected $_description = '';
  
  /**
   * @var string
   */
  protected $_status = Page_Const::STATUS_LIVE;
  
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
   * getter for title attribute
   *
   * @return string
   */
  public function getTitle()
  {
    return $this->_title;
  }
  
  /**
   * getter for link attribute
   *
   * @return string
   */
  public function getLink()
  {
    return $this->_link;
  }
  
  /**
   * getter for body attribute
   *
   * @return string
   */
  public function getBody()
  {
    return $this->_body;
  }
  
  /**
   * getter for keywords attribute
   *
   * @return string
   */
  public function getKeywords()
  {
    return $this->_keywords;
  }
  
  /**
   * getter for description attribute
   *
   * @return string
   */
  public function getDescription()
  {
    return $this->_description;
  }
  
  /**
   * Get the page status
   * 
   * @return string
   */
  public function getStatus()
  {
    return $this->_status;
  }

  /**
   * setter for title attribute
   *
   * @param string $value
   */
  public function setTitle($value)
  {
    if ($value != $this->_title) {
      $this->_title = (string)$value;
      $this->_add('`title`', 'getTitle');
    }
    return $this;
  }

  /**
   * setter for link attribute
   *
   * @param string $value
   */
  public function setLink($value)
  {
    if ($value != $this->_link) {
      $this->_link = (string)$value;
      $this->_add('`link`', 'getLink');
    }
    return $this;
  }

  /**
   * setter for body attribute
   *
   * @param string $value
   */
  public function setBody($value)
  {
    if ($value != $this->_body) {
      $this->_body = (string)$value;
      $this->_add('`body`', 'getBody');
    }
    return $this;
  }

  /**
   * setter for keywords attribute
   *
   * @param string $value
   */
  public function setKeywords($value)
  {
    if ($value != $this->_keywords) {
      $this->_keywords = (string)$value;
      $this->_add('`keywords`', 'getKeywords');
    }
    return $this;
  }

  /**
   * setter for description attribute
   *
   * @param string $value
   */
  public function setDescription($value)
  {
    if ($value != $this->_description) {
      $this->_description = (string)$value;
      $this->_add('`description`', 'getDescription');
    }
    return $this;
  }

  /**
   * Set the status attribute
   * 
   * @param string $value
   * 
   * @return \Page
   */
  public function setStatus($value)
  {
    if ($value != $this->_status && Page_Const::statusValid($value)) {
      $this->_status = (string)$value;
      $this->_add('`status`', 'getStatus');
    }
    
    return $this;
  }
  /**
   * Return array of object data
   * 
   * (return) array
   */
  public function toArray()
  {
    return array(
      'id'          => $this->getId(),
      'title'       => $this->getTitle(),
      'link'        => $this->getLink(),
      'body'        => $this->getBody(),
      'keywords'    => $this->getKeywords(),
      'description' => $this->getDescription(),
      'status'      => $this->getStatus(),
      );
  }
  
  public function save(DB $db)
  {
    if ($this->_updateRequired()) {
      
      $db->query("
      UPDATE 
        [PREFX]page_dynamic
      SET  
        " . $this->_returnSQL($db) . "
      WHERE 
        `id` = " . $db->data($this->getId()) . "
      ", "Save Page Object");
    }
  }

}