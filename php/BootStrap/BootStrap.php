<?php

/**
 * Description
 * 
 * @copyright (c) 2013, PHPMatt.com
 * 
 * @author Matt Holmes <iam4423@gmail.com>
 */

class BootStrap
{
  /**
   * @var string 
   */
  protected $_tplFolder = 'display/';
  
  /**
   * @var string 
   */
  protected $_incFolder = 'includes/';
  
  /**
   * @var string
   */
  protected $_headerFile = 'header';
  
  /**
   * @var string
   */
  protected $_footerFile = 'footer';
  
  /**
   * @var string
   */
  protected $_tpl = '.tpl.php';
  
  /**
   * @var string 
   */
  protected $_inc = '.inc.php';
  
  /**
   * @var string
   */
  protected $_path = '';
  
  /**
   * @var array
   */
  protected $_cssFiles = array();
  
  /**
   * @var string 
   */
  protected $_404 = '404';
  
  /**
   * Set the default template folder
   * 
   * @param string $value
   * 
   * @return \BootStrap
   */
  public function setDisplay($value)
  {
    $this->_tplFolder = (string)$value;
    
    return $this;
  }
  /**
   * Set the default includes folder
   * 
   * @param string $value
   * 
   * @return \BootStrap
   */
  public function setIncludes($value)
  {
    $this->_incFolder = (string)$value;
    
    return $this;
  }
  /**
   * Set the path
   * 
   * @param string $path
   * 
   * @return \BootStrap
   */
  public function setPath($path)
  {
    //if (validPath($path)) {
      
      $this->_path = $path;
    //}
    
    return $this;
  }
  
  /**
   * Set the path to the 404 folder 
   * (within display folder)
   * 
   * @param string $path
   * 
   * @return \BootStrap
   */
  public function set404($path)
  {
    if (validPath($path)) {
      
      $this->_404 = $path;
    }
    
    return $this;
  }
  
  /**
   * Run the file finder and return array of includes
   * 
   * @return array
   */
  public function boot()
  {
    if ($this->_checkFiles()) {
      
      return $this->_buildArray($this->_path);
    } else {
      
      return $this->_buildArray($this->_404);
    }
  }
  
  /**
   * Generate css include html
   * 
   * @return string
   */
  public function getCssHtml()
  {
    if (!empty($this->_cssFiles)) {
      
      $output = '';
      
      for ($i = 0, $max = count($this->_cssFiles); $i < $max; $i++) {
        
        $output .= '
          <link href="' . ROOT . $this->_cssFiles[$i] . '" rel="stylesheet" />';
      }
      
      return $output;
    }
    
    return '';
  }
  
  /**
   * Check that the files exist
   * 
   * @return boolean
   */
  protected function _checkFiles()
  {
    if (strpos($this->_path, '/')) {
      
      $parts = explode('/', $this->_path);
      
      $file = '/' . ($parts[(count($parts) - 1)]);
    } else {
      $file = '/' . $this->_path;
    }
    
    return file_exists(__DIR__ . '/../../../' . $this->_tplFolder 
      . $this->_path . $file . $this->_tpl);

  }
  
  /**
   * Build up an array of includes
   * 
   * @param string $path
   * 
   * @return array
   */
  protected function _buildArray($path)
  {
    $array = array_merge(
      $this->_getIncludes($path), 
      $this->_getTemplates($path)
      );
    
    return (array)$array;
  }
  
  /**
   * build array of all include files
   * 
   * @param string $path
   * 
   * @return array
   */
  protected function _getIncludes($path)
  {
    return glob(__DIR__ . '/../../../' . $this->_incFolder . $path . '/*' . $this->_inc);
  }
  
  /**
   * Build template array
   * 
   * @param type $path
   * 
   * @return array
   */
  protected function _getTemplates($path)
  {
    $files = glob(__DIR__ . '/../../../' . $this->_tplFolder . $path . '/*' . $this->_tpl);
    $header = $footer = false;
    for ($i = 0, $max = count($files); $i < $max; $i++) {
      
      if (is_numeric(strpos($files[$i], $this->_headerFile . $this->_tpl))) {
        unset($files[$i]);
        $header = true;
        continue;
      }
      
      if (is_numeric(strpos($files[$i], $this->_footerFile . $this->_tpl))) {
        unset($files[$i]);
        $footer = true;
        continue;
      }
    }
    
    if ($header) {
      $array[] = __DIR__ . '/../../../' . $this->_tplFolder . $path . '/' 
        . $this->_headerFile . $this->_tpl;
    } else {
      $array[] = __DIR__ . '/../../../' . $this->_tplFolder 
        . $this->_headerFile . $this->_tpl;
    }
    
    $array = array_merge($array, $files);
    
    if ($footer) {
      $array[] = 
        __DIR__ . '/../../../' . $this->_tplFolder . $path . '/' . $this->_footerFile . $this->_tpl;
    } else {
      $array[] = __DIR__ . '/../../../' . $this->_tplFolder . $this->_footerFile . $this->_tpl;
    }
    
    $this->_findCSS($path);
    
    return $array;
  }
  
  /**
   * Find css files
   * 
   * @param string $path
   */
  protected function _findCSS($path)
  {
    $files = glob(__DIR__ . '/../../../' . $this->_tplFolder . $path . '/*.css');
    if (!empty($files)) {
      
      for ($i = 0, $max = count($files); $i < $max; $i++) {

        $files[$i] = $this->_tplFolder . $path . '/' . substr($files[$i], (strrpos($files[$i], '/') +1));
      }
    }
    
    $this->_cssFiles = $files;
  }
}