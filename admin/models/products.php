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

// import the Joomla modellist library
jimport('joomla.application.component.modellist');

/**
 * NokMyBusinessCustomerList Model
 */
class NokMyBusinessModelProducts extends JModelList {
	public function __construct($config = array()) {
		if (!isset($config['filter_fields']) || empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'p.id',
				'name', 'p.name',
				'number', 'p.number',
				'status', 'p.status',
				'stock', 'p.stock',
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
		parent::populateState('p.name', 'asc');
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
                    ->select($db->quoteName(array('p.id', 'p.name', 'p.number', 'p.status', 'p.published', 'p.price', 'p.stock')))
                    ->from($db->quoteName('#__nok_mybusiness_products','p'));
		// special filtering (houshold, excludeid).
		$whereExtList = array();
		$app = JFactory::getApplication();
		if ($excludeId = $app->input->get('excludeid')) {
			array_push($whereExtList,"NOT ".$db->quoteName("p.id")." = ".$excludeId);
		}
		$whereExt = implode(" AND ",$whereExtList);
		// Filter by search in name.
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (!empty($whereExt)) $whereExt = " AND ".$whereExt;
			if (stripos($search, 'id:') === 0) {
				$query->where('p.id = ' . (int) substr($search, 3).$whereExt);
			} else {
				$search = $db->quote('%' . $db->escape($search, true) . '%');
				$query->where('(c.name LIKE '.$search.' OR c.number LIKE '.$search.')'.$whereExt);
			}
		} else {
			if (!empty($whereExt)) {
				$query->where($whereExt);
			}
		}
		// Add the list ordering clause.
		$orderColText = $this->state->get('list.ordering', 'c.name');
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
			'catid'=>'p.catid',
			'name'=>'p.name',
			'number'=>'p.number',
			'shorttext'=>'p.shorttext',
			'description'=>'p.description',
			'picture'=>'p.picture',
			'power'=>'p.power',
			'dimensions'=>'p.dimensions',
			'protection'=>'p.protection',
			'price'=>'p.price',
			'vat'=>'p.vat',
			'stock'=>'p.stock',
			'published'=>'p.published',
			'status'=>'p.status',
			'createdby'=>'p.createdby',
			'createddate'=>'p.createddate',
			'modifiedby'=>'p.modifiedby',
			'modifieddate'=>'p.modifieddate'
		);
	}

        public function getExportColumns() {
		return array (
			'catid', 'name', 'number', 'shorttext', 'description', 'picture',
			'power', 'dimensions', 'protection', 'price', 'vat', 'stock', 'published', 'status', 
			'createdby', 'createddate', 'modifiedby', 'modifieddate');
	}

        public function getImportPrimaryFields() {
		return array (
			'number'=>'number'
		);
	}

        public function getForeignKeys() {
		return array ();
	}

        public function getTableName() {
		return "#__nok_mybusiness_products";
	}

        public function getIdFieldName() {
		return "id";
	}

        public function getExportQuery($export_fields) {
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                $query
                	->select($db->quoteName(array_values($export_fields)))
                	->from($db->quoteName($this->getTableName(),'p'));
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
