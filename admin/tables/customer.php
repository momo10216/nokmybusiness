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
 
// import Joomla table library
jimport('joomla.database.table');
 
/**
 * Hello Table class
 */
class NoKMyBusinessTableCustomer extends JTable {
        /**
         * Constructor
         *
         * @param object Database connector object
         */
        function __construct(&$db)  {
                parent::__construct('#__nok_mybusiness_customers', 'id', $db);
        }

	/**
	 * Stores a contact
	 *
	 * @param   boolean  True to update fields even if they are null.
	 *
	 * @return  boolean  True on success, false on failure.
	 *
	 * @since   1.6
	 */
	public function store($updateNulls = false) {
		// Transform the params field
		if (is_array($this->params)) {
			$registry = new JRegistry;
			$registry->loadArray($this->params);
			$this->params = (string) $registry;
		}
		JLoader::register('TableHelper', __DIR__.'/../helpers/table.php', true);
		TableHelper::updateCommonFieldsOnSave($this);
		// Store utf8 email as punycode
		$this->email = JStringPunycode::emailToPunycode($this->email);
		// Convert IDN urls to punycode
		$this->url = JStringPunycode::urlToPunycode($this->url);
		return parent::store($updateNulls);
	}
}
?>
