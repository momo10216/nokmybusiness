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
 
/**
 * Persons View
 */
class NoKMyBusinessViewProducts extends JViewLegacy {
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Persons view display method
	 * @return void
	 */
	function display($tpl = null)  {
		NoKMyBusinessHelper::addSubmenu('products');
		// Get data from the model
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		// Check for errors.
		$errors = $this->get('Errors');
		if (is_array($errors) && count($errors)) {
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		switch($this->getLayout()) {
			case "import":
				$this->addToolbarImport();
				break;
			default:
				$this->addToolbarList();
				break;
		}
		$this->sidebar = JHtmlSidebar::render();
		// Display the template
		parent::display($tpl);
	}

	protected function addToolbarList() {
		$canDo = JHelperContent::getActions('com_nokmybusiness', 'category', $this->state->get('filter.category_id'));
		$user  = JFactory::getUser();
		// Get the toolbar object instance
		$bar = JToolBar::getInstance('toolbar');
		JToolbarHelper::title(JText::_('COM_NOKMYBUSINESS_PRODUCTS_TITLE'), 'stack product');
		if ($canDo->get('core.create') || (count($user->getAuthorisedCategories('com_nokmybusiness', 'core.create'))) > 0 ) {
			JToolbarHelper::addNew('product.add');
		}
		if (($canDo->get('core.edit')) || ($canDo->get('core.edit.own'))) {
			JToolbarHelper::editList('product.edit');
		}
		if ($canDo->get('core.delete')) {
			JToolbarHelper::trash('products.delete');
		}
		// Add a export button
		JToolBarHelper::custom('products.export', 'download', 'download', JText::_('JTOOLBAR_EXPORT'), false);
		// Add a import button
		if ($user->authorise('core.create', 'com_nokmybusiness')) {
			JToolBarHelper::custom('products.import', 'upload', 'upload', JText::_('JTOOLBAR_IMPORT'), false);
		}
		if ($user->authorise('core.admin', 'com_nokmybusiness')) {
			JToolbarHelper::preferences('com_nokmybusiness');
		}
		//JToolbarHelper::help('JHELP_CONTENT_ARTICLE_MANAGER');
	}

	protected function addToolbarImport() {
		// Get the toolbar object instance
		$bar = JToolBar::getInstance('toolbar');
		JToolbarHelper::title(JText::_('COM_NOKMYBUSINESS_PRODUCTS_TITLE'), 'stack product');
		JToolBarHelper::custom('products.import_cancel', 'cancel.png', 'cancel_f2.png', JText::_('JTOOLBAR_CLOSE'), false);
	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 *
	 * @since   3.0
	 */
	protected function getSortFields() {
		return array (
			'p.name' => JText::_('COM_NOKMYBUSINESS_CUSTOMERS_FIELD_NAME_LABEL'),
			'p.stock' => JText::_('COM_NOKMYBUSINESS_CUSTOMERS_FIELD_STOCK_LABEL'),
			'p.price' => JText::_('COM_NOKMYBUSINESS_CUSTOMERS_FIELD_PRICE_LABEL')
		);
	}
}
?>
