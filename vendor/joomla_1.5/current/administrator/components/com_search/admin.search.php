<?php
/**
* @version		$Id: admin.search.php 7692 2007-06-08 20:41:29Z tcp $
* @package		Joomla
* @subpackage	Search
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once( JPATH_COMPONENT.DS.'controller.php' );

$controller = new SearchController();
$controller->execute( JRequest::getVar( 'task' ) );
$controller->redirect();
?>