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
 
/**
 * General Controller of NoK-MyBusiness component
 */
class NoKMyBusinessController extends JControllerLegacy
{
	/**
	 * @var		string	The default view.
	 * @since   1.6
	 */
	protected $default_view = 'customers';

        /**
         * display task
         *
         * @return void
         */
        function display($cachable = false, $urlparams = false) 
        {
                // set default view if not set
                $input = JFactory::getApplication()->input;
                $input->set('view', $input->get('view', 'customers'));
 
                // call parent behavior
                parent::display($cachable, $urlparams);
                return $this;
        }
}
?>
