<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	NokMyBusiness-Customer
* @copyright	Copyright (c) 2021 Norbert Kuemin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

class NoKMyBusinessControllerCustomer extends JControllerForm {
	public $typeAlias = 'com_nokmybusiness.customer';

	/**
	 * Method override to check if you can edit an existing record.
	 *
	 * @param   array   $data  An array of input data.
	 * @param   string  $key   The name of the key for the primary key.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	protected function allowEdit($data = array(), $key = 'id') {
		$recordId = (int) isset($data[$key]) ? $data[$key] : 0;
		$user = JFactory::getUser();
		$userId = $user->get('id');
		// Check general edit permission first.
		if ($user->authorise('core.edit', $this->typeAlias.'.'.$recordId)) { return true; }
		// Fallback on edit.own.
		// First test if the permission is available.
		if ($user->authorise('core.edit.own', $this->typeAlias.'.'.$recordId)) {
			// Now test the owner is the user.
			$ownerId = (int) isset($data['user_id']) ? $data['user_id'] : 0;
			if (empty($ownerId) && $recordId) {
				// Need to do a lookup from the model.
				$record = $this->getModel()->getItem($recordId);
				if (empty($record)) { return false; }
				$ownerId = $record->user_id;
			}
			// If the owner matches 'me' then do the test.
			if ($ownerId == $userId) { return true; }
		}
		// Since there is no asset tracking, revert to the component permissions.
		return parent::allowEdit($data, $key);
	}
}
?>
