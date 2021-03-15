<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	NokMyBusiness-Main
* @copyright	Copyright (c) 2021 Norbert Kuemin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

JLoader::register('NoKMyBusinessHelper', __DIR__.'/helpers/nokmybusiness.php', true);

// Get an instance of the controller prefixed by ClubManagement
$controller = JControllerLegacy::getInstance('NoKMyBusiness');
 
// Perform the Request task
$input = JFactory::getApplication()->input;
$controller->execute($input->get('task'));
 
// Redirect if set by the controller
$controller->redirect();
?>
