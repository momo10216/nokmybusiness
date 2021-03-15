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

$listDirn	= $this->escape($this->state->get('list.direction'));
$listOrder	= $this->escape($this->state->get('list.ordering'));
?>
<tr>
	<th width="1%" class="hidden-phone">
		<?php echo JHtml::_('grid.checkall'); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_NOKMYBUSINESS_CUSTOMERS_FIELD_NAME_LABEL', 'c.name', $listDirn, $listOrder); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_NOKMYBUSINESS_CUSTOMERS_FIELD_FIRSTNAME_LABEL', 'c.firstname', $listDirn, $listOrder); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_NOKMYBUSINESS_CUSTOMERS_FIELD_ADDRESS_LABEL', 'c.address', $listDirn, $listOrder); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_NOKMYBUSINESS_CUSTOMERS_FIELD_ZIP_LABEL', 'c.zip', $listDirn, $listOrder); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_NOKMYBUSINESS_CUSTOMERS_FIELD_CITY_LABEL', 'c.city', $listDirn, $listOrder); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_NOKMYBUSINESS_CUSTOMERS_FIELD_STATE_LABEL', 'c.state', $listDirn, $listOrder); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_NOKMYBUSINESS_CUSTOMERS_FIELD_COUNTRY_LABEL', 'c.country', $listDirn, $listOrder); ?>
	</th>
</tr>

