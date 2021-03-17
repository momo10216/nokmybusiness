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

$listDirn	= $this->escape($this->state->get('list.direction'));
$listOrder	= $this->escape($this->state->get('list.ordering'));
?>
<tr>
	<th width="1%" class="hidden-phone">
		<?php echo JHtml::_('grid.checkall'); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_NOKMYBUSINESS_PRODUCTS_FIELD_NAME_LABEL', 'c.name', $listDirn, $listOrder); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_NOKMYBUSINESS_PRODUCTS_FIELD_PRICE_LABEL', 'c.price', $listDirn, $listOrder); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_NOKMYBUSINESS_PRODUCTS_FIELD_STOCK_LABEL', 'c.stock', $listDirn, $listOrder); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_NOKMYBUSINESS_PRODUCTS_FIELD_PUBLISHED_LABEL', 'c.published', $listDirn, $listOrder); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_NOKMYBUSINESS_PRODUCTS_FIELD_STATUS_LABEL', 'c.status', $listDirn, $listOrder); ?>
	</th>
</tr>

