<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	NokMyBusiness-Customer
* @copyright	Copyright (c) 2014 Norbert Kuemin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

class NoKMyBusinessViewCustomer extends JViewLegacy {
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
		if (is_object($this->item)) {
			$this->canDo	= NoKMyBusinessHelper::getActions('com_nokmybusiness', 'customer', $this->item->id);
		} else {
			$this->canDo	= NoKMyBusinessHelper::getActions('com_nokmybusiness', 'customer');
		}
		// Check for errors.
		$errors = $this->get('Errors');
		if ($errors && is_array($errors) && (count($errors) > 0)) {
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
		$user		= JFactory::getUser();
		$userId		= $user->get('id');
		if (is_object($this->item)) {
			$isNew = ($this->item->id == 0);
		} else {
			$isNew = true;
		}
		// Built the actions for new and existing records.
		$canDo		= $this->canDo;
		JToolbarHelper::title(($isNew ? JText::_('COM_NOKMYBUSINESS_PERSONS_PAGE_ADD') : JText::_('COM_NOKMYBUSINESS_PERSONS_PAGE_EDIT')), 'pencil-2 article-add');

		// For new records, check the create permission.
		if ($isNew && $canDo->get('core.create')) {
			JToolbarHelper::apply('customer.apply');
			JToolbarHelper::save('customer.save');
			JToolbarHelper::save2new('customer.save2new');
			JToolbarHelper::cancel('customer.cancel');
		} else {
			// Since it's an existing record, check the edit permission, or fall back to edit own if the owner.
			if ($canDo->get('core.edit') || ($canDo->get('core.edit.own') && $this->item->created_by == $userId)) {
				JToolbarHelper::apply('customer.apply');
				JToolbarHelper::save('customer.save');
				// We can save this record, but check the create permission to see if we can return to make a new one.
				if ($canDo->get('core.create')) {
					JToolbarHelper::save2new('customer.save2new');
				}
			}
			// If checked out, we can still save
			if ($canDo->get('core.create')) {
				JToolbarHelper::save2copy('customer.save2copy');
			}
			JToolbarHelper::cancel('customer.cancel', 'JTOOLBAR_CLOSE');
		}
		JToolbarHelper::divider();
		JToolbarHelper::help('JHELP_COM_NOKMYBUSINESS_PERSON_MANAGER_EDIT');
	}
}
?>
