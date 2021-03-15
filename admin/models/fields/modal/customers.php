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
//defined('JPATH_BASE') or die;

/**
 * Supports a modal customer picker.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_nokmybusiness
 * @since       3.0
 */
class JFormFieldModal_Persons extends JFormField {
	protected $type = 'Modal_Customers';

	protected function getInput() {
		// Load the modal behavior script.
		JHtml::_('behavior.modal', 'a.modal');
		// Build the script.
		$script = array();
		// Select button script
		$script[] = '	function jSelectCustomer_'.$this->id.'(id, name, firstname, address, city) {';
		$script[] = '		document.getElementById("'.$this->id.'_id").value = id;';
		$script[] = '		document.getElementById("'.$this->id.'_name").value = name+", "+firstname+", "+address+", "+city;';
		$script[] = '		SqueezeBox.close();';
		$script[] = '	}';
		// Add the script to the document head.
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
		// Setup variables for display.
		$html	= array();
		$link	= 'index.php?option=com_nokmybusiness&amp;view=customers&amp;layout=modal&amp;tmpl=component&amp;function=jSelectCustomer_'.$this->id;
		if (isset($this->element["excludeCurrentId"]) && ($this->element["excludeCurrentId"] == "true")) {
			$app = JFactory::getApplication();
			if ($id = $app->input->get('id')) {
				$link .= "&amp;excludeid=".$id;
			}
		}
		if ((int) $this->value > 0) {
			$db	= JFactory::getDbo();
			$query = $db->getQuery(true)
				->select("CONCAT(IFNULL(name,''),' ',IFNULL(firstname,''),',',',',IFNULL(address,''),',',IFNULL(city,''))")
				->from($db->quoteName('#__nok_mybusiness_customers'))
				->where($db->quoteName('id') . ' = ' . (int) $this->value);
			$db->setQuery($query);
			try {
				$fullname = $db->loadResult();
			} catch (RuntimeException $e) {
				JError::raiseWarning(500, $e->getMessage());
			}
		}

		if (empty($fullname)) {
			$fullname = JText::_('COM_NOKMYBUSINESS_SELECT_A_CUSTOMER');
		}
		$title = htmlspecialchars($fullname, ENT_QUOTES, 'UTF-8');
		// The active article id field.
		if (0 == (int) $this->value) { $value = ''; } else { $value = (int) $this->value;}
		// The current article display field.
		$html[] = '<span class="input-append">';
		$html[] = '<input type="text" class="input-medium" id="'.$this->id.'_name" value="'.$fullname.'" disabled="disabled" size="35" />';
		$html[] = '<a class="modal btn hasTooltip" title="'.JHtml::tooltipText('COM_NOKMYBUSINESS_CHANGE_CUSTOMER').'"  href="'.$link.'&amp;'.JSession::getFormToken().'=1" rel="{handler: \'iframe\', size: {x: 800, y: 450}}"><i class="icon-file"></i> '.JText::_('JSELECT').'</a>';
		$html[] = '</span>';
		// class='required' for client side validation
		$class = '';
		if ($this->required) {
			$class = ' class="required modal-value"';
		}
		$html[] = '<input type="hidden" id="'.$this->id.'_id"'.$class.' name="'.$this->name.'" value="'.$value.'" />';
		return implode("\n", $html);
	}
}
?>
