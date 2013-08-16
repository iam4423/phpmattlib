<?php

/**
 * Description
 * 
 * @copyright (c) 2012, Matt Holmes
 * 
 * @author Matt Holmes <iam4423@gmail.com>
 */

class DB_Updater
{
  /**
   * @var array $_toUdate
   */
  protected $_toUpdate = array();
  
  /**
   * Add to the rosta
   * 
   * @param string $function
   * @param string $value
   */
  protected function _add($function, $value)
  {
    $this->_toUpdate[$function] = $value;
  }
  
  /**
   * Check if the database needs updating
   * 
   * @return boolean
   */
  protected function _updateRequired()
  {
    return (count($this->_toUpdate) > 0) ? true : false;
  }
  
  /**
   * Return the sql data neededd for the update
   * 
   * @param DB_PDO $db
   * @return string
   */
  protected function _returnSQL(DB_PDO $db)
  {
    $out = '';
    
    foreach ($this->_toUpdate as $key => $val) {
      $out .= '
        ' . $key . ' = ' . $db->data($this->$val()) . ',';
    }
    return substr($out, 0, -1);
  }
}