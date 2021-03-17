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

class NoKMyBusinessViewProduct extends JViewLegacy {
	protected $form;
	protected $item;
	protected $state;
	protected $canDo;

	/**
	 * Display the view
	 */
	public function display($tpl = null) {
		$this->form	= $this->get('Form');
		$this->item	= $this->get('Item');
		$this->state	= $this->get('State');
		$this->canDo	= NoKMyBusinessHelper::getActions('com_nokmybusiness', 'product', $this->item->id);
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since   1.6
	 */
	protected function addToolbar() {
		JFactory::getApplication()->input->set('hidemainmenu', true);
		$user = JFactory::getUser();
		$username = $user->get('name');
		$isNew = ($this->item->id == 0);
		// Built the actions for new and existing records.
		$canDo		= $this->canDo;
		JToolbarHelper::title(($isNew ? JText::_('COM_NOKMYBUSINESS_PRODUCTS_PAGE_ADD') : JText::_('COM_NOKMYBUSINESS_PRODUCTS_PAGE_EDIT')), 'pencil-2 article-add');

		// For new records, check the create permission.
		if ($isNew && $canDo->get('core.create')) {
			JToolbarHelper::apply('product.apply');
			JToolbarHelper::save('product.save');
			JToolbarHelper::save2new('product.save2new');
			JToolbarHelper::cancel('product.cancel');
		} else {
			// Since it's an existing record, check the edit permission, or fall back to edit own if the owner.
			if ($canDo->get('core.edit') || ($canDo->get('core.edit.own') && $this->item->created_by == $username)) {
				JToolbarHelper::apply('product.apply');
				JToolbarHelper::save('product.save');
				// We can save this record, but check the create permission to see if we can return to make a new one.
				if ($canDo->get('core.create')) {
					JToolbarHelper::save2new('product.save2new');
				}
			}
			// If checked out, we can still save
			if ($canDo->get('core.create')) {
				JToolbarHelper::save2copy('product.save2copy');
			}
			JToolbarHelper::cancel('product.cancel', 'JTOOLBAR_CLOSE');
		}
		JToolbarHelper::divider();
		JToolbarHelper::help('JHELP_COM_NOKMYBUSINESS_PRODUCT_MANAGER_EDIT');
	}
}
?>
