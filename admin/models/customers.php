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

// import the Joomla modellist library
jimport('joomla.application.component.modellist');

/**
 * NokMyBusinessCustomerList Model
 */
class NokMyBusinessModelCustomers extends JModelList {
	public function __construct($config = array()) {
		if (!isset($config['filter_fields']) || empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'c.id',
				'name', 'c.name',
				'firstname', 'p.firstname',
				'address', 'c.address',
				'zip', 'c.zip',
				'city', 'c.city',
				'state', 'c.sate',
				'country', 'c.country',
				'createddate', 'c.createddate',
				'createdby', 'c.createdby'
			);
			$app = JFactory::getApplication();
		}
		parent::__construct($config);
	}

	protected function populateState($ordering = null, $direction = null) {
		$app = JFactory::getApplication();
		// Adjust the context to support modal layouts.
		if ($layout = $app->input->get('layout')) {
			$this->context .= '.' . $layout;
		}
		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);
		// List state information.
		parent::populateState('c.name', 'asc');
	}

        /**
         * Method to build an SQL query to load the list data.
         *
         * @return      string  An SQL query
         */
        protected function getListQuery() {
                // Create a new query object.           
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                // Select some fields from the hello table
                $query
                    ->select($db->quoteName(array('c.id', 'c.name', 'c.firstname', 'c.address', 'c.zip', 'c.city', 'c.state', 'c.country', 'c.birthday')))
                    ->from($db->quoteName('#__nok_mybusiness_customers','c'));
		// special filtering (houshold, excludeid).
		$whereExtList = array();
		$app = JFactory::getApplication();
		if ($excludeId = $app->input->get('excludeid')) {
			array_push($whereExtList,"NOT ".$db->quoteName("c.id")." = ".$excludeId);
		}
		$whereExt = implode(" AND ",$whereExtList);
		// Filter by search in name.
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (!empty($whereExt)) $whereExt = " AND ".$whereExt;
			if (stripos($search, 'id:') === 0) {
				$query->where('c.id = ' . (int) substr($search, 3).$whereExt);
			} else {
				$search = $db->quote('%' . $db->escape($search, true) . '%');
				$query->where('(c.name LIKE '.$search.' OR c.firstname LIKE '.$search.' OR c.number LIKE '.$search.')'.$whereExt);
			}
		} else {
			if (!empty($whereExt)) {
				$query->where($whereExt);
			}
		}
		// Add the list ordering clause.
		$orderColText = $this->state->get('list.ordering', 'c.name, c.firstname');
		$orderDirn = $this->state->get('list.direction', 'asc');
		$orderCols = explode(",",$orderColText);
		$orderEntry = array();
		foreach ($orderCols as $orderCol) {
			array_push($orderEntry,$db->escape($orderCol . ' ' . $orderDirn));
		}
		$query->order(implode(", ",$orderEntry));
                return $query;
        }

        /**
         * Method to build an SQL query to load the list data.
         *' 
         * @return      string  An SQL query
         */
        public function getFieldMapping() {
		return array (
			'title'=>'c.title',
			'number'=>'c.number',
			'name'=>'c.name',
			'birthname'=>'c.birthname',
			'firstname'=>'c.firstname',
			'address'=>'c.address',
			'zip'=>'c.zip',
			'city'=>'c.city',
			'state'=>'c.state',
			'country'=>'c.country',
			'birthday'=>'c.birthday',
			'telephone'=>'c.telephone',
			'mobile'=>'c.mobile',
			'email'=>'c.email',
			'url'=>'c.url',
			'user_id'=>'c.user_id',
			'user_username'=>'u.username', 
			'status'=>'c.status', 
			'custom1'=>'c.custom1',
			'custom2'=>'c.custom2',
			'custom3'=>'c.custom3',
			'custom4'=>'c.custom4',
			'custom5'=>'c.custom5',
			'description'=>'c.description',
			'createdby'=>'c.createdby',
			'createddate'=>'c.createddate',
			'modifiedby'=>'c.modifiedby',
			'modifieddate'=>'c.modifieddate'
		);
	}

        public function getExportColumns() {
		return array (
			'title', 'name', 'birthname', 'firstname', 'address', 'zip', 'city', 'state', 'country',
			'number', 'birthday', 'telephone', 'mobile', 'email', 'url', 'user_username', 'status',
			'custom1', 'custom2', 'custom3', 'custom4', 'custom5',
			'description', 'createdby', 'createddate', 'modifiedby', 'modifieddate');
	}

        public function getImportPrimaryFields() {
		return array (
			'name'=>'name',
			'firstname'=>'firstname',
			'address'=>'address',
			'city'=>'city',
			'birthday'=>'birthday'
		);
	}

        public function getForeignKeys() {
		return array (
			'u' => array (
				'localKeyField' => 'user_id',
				'remoteTable' => '#__users',
				'remoteKeyField' => 'id',
				'remoteUniqueKey' => array('username')
			)
		);
	}

        public function getTableName() {
		return "#__nok_mybusiness_customers";
	}

        public function getIdFieldName() {
		return "id";
	}

        public function getExportQuery($export_fields) {
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                $query
                	->select($db->quoteName(array_values($export_fields)))
                	->from($db->quoteName($this->getTableName(),'c'))
			->join('LEFT', $db->quoteName('#__users', 'u').' ON ('.$db->quoteName('c.user_id').'='.$db->quoteName('u.id').')');
		return $query;
	}

        /**
         * Method to build an SQL query to load the list data.
         *
         * @return      string  An SQL query
         */
        public function getExportData() {
		return NokMyBusinessHelper::exportData($this);
	}

        /**
         * Method to build an SQL query to load the list data.
         *
         * @return      string  An SQL query
         */
        public function saveImportData($data) {
		$header = array_shift($data);
		$data_stage1 = array();
		foreach ($data as $entry) {
			$row = NokMyBusinessHelper::getNamedArray($header, $entry);
			array_push($data_stage1, $entry);
		}
		$this->saveImportData_stage($header, $data_stage1);
	}

        private function saveImportData_stage($header, $data) {
		NokMyBusinessHelper::importData($this, $header, $data);
	}

}
?>
