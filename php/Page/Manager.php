<?php

/**
 * Description
 * 
 * @copyright (c) 2013, PHPMatt.com
 * 
 * @author Matt Holmes <iam4423@gmail.com>
 */

class Page_Manager
{
  /**
   * Load a page object
   * 
   * @param DB $db
   * @param string $link
   * @param string $status
   * 
   * @return \Page
   */
  public static function loadObject(DB $db, $link, $status = Page_Const::STATUS_ALL)
  {
    return $db->queryFetchObject("
      SELECT
        " . Page::SELECT_SQL . "
      FROM
        page_dynamic
      WHERE 
        link = " . $db->data($link) . "
      " . (($status != Page_Const::STATUS_DELETED) ? "
      AND 
        status != " . $db->data(Page_Const::STATUS_DELETED) . "
      " : "") . "
      " . (($status != Page_Const::STATUS_ALL) ? "
      AND
        status = " . $db->data($status) . "
      " : "") . "
      ", "Page");
  }
  
  /**
   * Check if the link is already taken
   * 
   * @param DB $db
   * @param string $link
   * 
   * @return boolean
   */
  public static function linkTaken(DB $db, $link)
  {
    $count = $db->firstResult("
      SELECT
        COUNT(id)
      FROM
        [PREFX]page_dynamic
      WHERE
        link = " . $db->data($link) . "
      ");
    
    return (boolean)($count > 0);
  }
  
  /**
   * Add a new page
   * 
   * @param DB $db
   * @param string $title
   * @param string $link
   * @param string $status
   * @param string $keywords
   * @param string $description
   * @param string $body
   * 
   * @return void
   */
  public static function addPage(
    DB $db,
    $title,
    $link,
    $status,
    $keywords,
    $description,
    $body
    ) 
  {
    $db->query("
      INSERT INTO
        [PREFX]page_dynamic
      (
        title,
        link,
        body,
        keywords,
        description,
        status
      ) VALUES (
        " . $db->data($title) . ",
        " . $db->data($link) . ",
        " . $db->data($body) . ",
        " . $db->data($keywords) . ",
        " . $db->data($description) . ",
        " . $db->data($status) . "
      )", "Insert New Page");
  }
}