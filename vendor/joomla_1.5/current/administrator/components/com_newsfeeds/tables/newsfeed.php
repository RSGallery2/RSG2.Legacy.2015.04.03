<?php
/**
* @version		$Id: newsfeed.php 7122 2007-04-10 08:27:39Z jinx $
* @package		Joomla
* @subpackage	Newsfeeds
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

/**
* @package		Joomla
* @subpackage	Newsfeeds
*/
class TableNewsFeed extends JTable
{
	/** @var int Primary key */
	var $id					= null;
	/** @var int */
	var $catid				= null;
	/** @var string */
	var $name				= null;
	/** @var string */
	var $alias				= null;
	/** @var string */
	var $link				= null;
	/** @var string */
	var $filename			= null;
	/** @var int */
	var $published			= null;
	/** @var int */
	var $numarticles			= null;
	/** @var int */
	var $cache_time			= null;
	/** @var int */
	var $checked_out			= 0;
	/** @var time */
	var $checked_out_time		= 0;
	/** @var int */
	var $ordering			= null;
	/** @var int */
	var $rtl					= 0;

	/**
	 * @param database A database connector object
	 */
	function __construct( &$db ) {
		parent::__construct( '#__newsfeeds', 'id', $db );
	}

	/**
	 * Overloaded check function
	 *
	 * @access public
	 * @return boolean
	 * @see JTable::check
	 * @since 1.5
	 */
	function check()
	{
		jimport('joomla.filter.output');
		$alias = JOutputFilter::stringURLSafe($this->name);

		if(empty($this->alias) || $this->alias === $alias ) {
			$this->alias = $alias;
		}

		return true;
	}
}
?>
