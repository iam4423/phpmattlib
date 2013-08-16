<?php

/**
 * Autoloader class and magic function combo
 * 
 * @copyright (c) 2013, PHPMatt.com
 * 
 * @author Matt Holmes <iam4423@gmail.com>
 */

$AutoLoad = new AutoLoad();

class AutoLoad
{
  /**
   * @var string 
   */
  protected $_rootPath = __DIR__;
  
  /**
   * @var array 
   */
  protected $_extraPaths = array();
  
  /**
   * @var boolean
   */
  protected $_searchAllPaths = false;
  
  /**
   * Add a path to the auto load directories
   * 
   * @param string $path
   * @param boolean $searchAll
   * 
   * @return \AutoLoad
   */
  public function addPath($path, $searchAll = true)
  {
    if (validPath($path))
      $this->_extraPaths[] = $path;
    
    $this->_searchAllPaths = (boolean)$searchAll;
    
    return $this;
  }
  
  /**
   * Enable/Disable searching all paths
   * 
   * @param boolean $enable
   * 
   * @return \AutoLoad
   */
  public function enableSearchAll($enable = true)
  {
    $this->_searchAllPaths = (boolean)$enable;
    
    return $this;
  }
  
  /**
   * Check if the file exists in paths
   * 
   * @param string $pathPart
   * 
   * @return boolean
   */
  public function checkPath($pathPart)
  {
    if (file_exists($this->_rootPath . '/' . (string)$pathPart))
      return $this->_rootPath . '/' . (string)$pathPart;
    
    if ($this->_searchAllPaths && !empty($this->_extraPaths)) {
      
      for ($i = 0, $max = count($this->_extraPaths); $i < $max; $i++) {
        
        if (file_exists($this->_extraPaths[$i] . '/' . (string)$pathPart))
          return $this->_extraPaths[$i] . '/' . (string)$pathPart;
      }
    }
    
    return false;
  }
}

/**
 * Auto load class file
 * 
 * @global AutoLoad $AutoLoad
 * 
 * @param string $className
 * 
 * @return boolean
 */
function __autoLoad($className)
{
  global $AutoLoad;
  
  if (empty($AutoLoad) || !($AutoLoad instanceof AutoLoad)) 
    $AutoLoad = new AutoLoad();
  
  if (strpos($className, '_')) {
    
    $parts = explode('_', $className);
    $file = '';
    
    for ($i = 0, $max = count($parts); $i < $max; $i++) {
      $file .= '/' . $parts[$i];
    }
    
    if ($AutoLoad->checkPath($file . '.php') != false) {
    
      require $AutoLoad->checkPath ($file . '.php');
      return true;
    }


    if ($AutoLoad->checkPath($file . '/' . $parts[$i - 1] .  '.php') != false) {

      require $AutoLoad->checkPath ($file . '/' . $parts[$i - 1] .  '.php');
      return true;
    }
  }
  
  if ($AutoLoad->checkPath($className . '.php') != false) {
    
    require $AutoLoad->checkPath ($className . '.php');
    return true;
  }
    
  
  if ($AutoLoad->checkPath($className . '/' . $className .  '.php') != false) {
    
    require $AutoLoad->checkPath ($className . '/' . $className .  '.php');
    return true;
  }
  
  return false;
}