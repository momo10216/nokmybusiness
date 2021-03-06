<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	NokMyBusiness-Product
* @copyright	Copyright (c) 2021 Norbert Kuemin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

class NokMyBusinessModelProduct extends JModelAdmin {
	protected $text_prefix = 'COM_NOKMYBUSINESS';
	public $typeAlias = 'com_nokmybusiness.product';

	/**
	 * Method to test whether a record can be deleted.
	 *
	 * @param   object    $record    A record object.
	 *
	 * @return  boolean  True if allowed to delete the record. Defaults to the permission set in the component.
	 * @since   1.6
	 */
	protected function canDelete($record) {
		if (!empty($record->id)) {
			$user = JFactory::getUser();
			return $user->authorise('core.delete', $this->typeAlias.'.'.(int) $record->id);
		}
	}

	/**
	 * Method to test whether a record can have its state edited.
	 *
	 * @param   object    $record    A record object.
	 *
	 * @return  boolean  True if allowed to change the state of the record. Defaults to the permission set in the component.
	 * @since   1.6
	 */
	protected function canEditState($record) {
		$user = JFactory::getUser();
		// Check for existing article.
		if (!empty($record->id)) {
			return $user->authorise('core.edit.state', $this->typeAlias.'.'.(int) $record->id);
		} else {
			// Default to component settings if neither article nor category known.
			return parent::canEditState('com_nokmybusiness');
		}
	}

	/**
	 * Returns a Table object, always creating it.
	 *
	 * @param   type      The table type to instantiate
	 * @param   string    A prefix for the table class name. Optional.
	 * @param   array     Configuration array for model. Optional.
	 *
	 * @return  JTable    A database object
	 */
	public function getTable($type = 'Product', $prefix = 'NoKMyBusinessTable', $config = array()) {
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param   array      $data        Data for the form.
	 * @param   boolean    $loadData    True if the form is to load its own data (default case), false if not.
	 *
	 * @return  mixed  A JForm object on success, false on failure
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true) {
		// Get the form.
		$form = $this->loadForm($this->typeAlias, 'product', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) { return false; }
		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 * @since   1.6
	 */
	protected function loadFormData() {
		// Check the session for previously entered form data.
		$app = JFactory::getApplication();
		$data = $app->getUserState('com_nokmybusiness.edit.product.data', array());
		if (empty($data)) {
			$data = $this->getItem();
		}
		$this->preprocessData($this->typeAlias, $data);
		return $data;
	}

	/**
	 * Custom clean the cache of com_content and content modules
	 *
	 * @since   1.6
	 */
	protected function cleanCache($group = null, $client_id = 0) {
		parent::cleanCache('com_nokmybusiness');
	}

}
?>
