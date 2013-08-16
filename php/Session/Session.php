<?php
/**
 * Session handler class
 * 
 * @copyright (c) 2013, PHPMatt.com
 * 
 * @author Matt Holmes <iam4423@gmail.com>
 */

class Session
{
  /**
   * Start a session
   */
  public static function start()
  {
    @session_start();
  }
  
  /**
   * Return a session value
   * 
   * @param string $key
   * 
   * @return boolean|string
   */
  public static function get($key)
  {
    self::start();
    
    if (!empty($_SESSION[$key]))
      return $_SESSION[$key];
    
    return false;
  }
  
  /**
   * Set a session 
   * 
   * @param string $key
   * @param mixed $value
   */
  public static function set($key, $value)
  {
    self::start();
    
    $_SESSION[$key] = $value;
  }
  
  /**
   * Check if a session is set
   * 
   * @param string $key
   * 
   * @return boolean
   */
  public static function check($key)
  {
    self::start();
    
    return !empty($_SESSION[$key]);
  }
  
  /**
   * Clear/remove a session entry
   * 
   * @param string $key
   */
  public static function clear($key)
  {
    unset($_SESSION[$key]);
  }
  
  /**
   * unset all sessions and destroy
   */
  public static function destroy()
  {
    @session_destroy();
  }
}