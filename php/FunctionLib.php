<?php

/**
 * Lib of global functions
 * 
 * @copyright (c) 2013, PHPMatt.com
 * 
 * @author Matt Holmes <iam4423@gmail.com>
 */

/**
 * Check if the path is a valid format
 * 
 * @param string $path
 * 
 * @return boolean
 */
function validPath($path)
{
  return preg_match('#[^a-zA-Z0-9-_/]#', $path);
}

/**
 * Return a url safe string
 * 
 * @param string $input
 * 
 * @return string
 */
function urlSafe($input)
{
  return (string)preg_replace('#[^a-z0-9-_]#', '', strtolower($input));
}

/**
 * Return value if set
 * 
 * @param mixed $ifSet
 * @param mixed $or
 * 
 * @return mixed
 */
function issetOr(&$ifSet, $or = '')
{
  return (isset($ifSet)) ? $ifSet: $or;
}