<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	NoKMyBusiness-Product
* @copyright	Copyright (c) 2021 Norbert Kuemin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_nokmybusiness&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="adminForm">
	<div class="row-fluid">
		<div class="span9">
			<div class="row-fluid form-horizontal-desktop">
				<div class="span6">
					<?php echo $this->form->renderField('name'); ?>
				</div>
				<div class="span6">
					<?php echo $this->form->renderField('id'); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_NOKMYBUSINESS_CUSTOMERS_TAB_COMMON', true)); ?>
		<div class="row-fluid">
			<div class="span9">
				<div class="row-fluid form-horizontal-desktop">
					<div class="span6">
						<?php echo $this->form->renderField('picture'); ?>
						<?php echo $this->form->renderField('catid'); ?>
						<?php echo $this->form->renderField('published'); ?>
						<?php echo $this->form->renderField('status'); ?>
						<?php echo $this->form->renderField('stock'); ?>
						<?php echo $this->form->renderField('price'); ?>
						<?php echo $this->form->renderField('vat'); ?>
					</div>
					<div class="span6">
						<?php echo $this->form->renderField('description'); ?>
					</div>
				</div>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'custom', JText::_('COM_NOKMYBUSINESS_CUSTOMERS_TAB_CUSTOM_AND_RECORDINFO', true)); ?>
		<div class="row-fluid">
			<div class="span9">
				<div class="row-fluid form-horizontal-desktop">
					<div class="span6">
						<?php echo $this->form->renderField('createdby'); ?>
						<?php echo $this->form->renderField('createddate'); ?>
					</div>
					<div class="span6">
						<?php echo $this->form->renderField('modifiedby'); ?>
						<?php echo $this->form->renderField('modifieddate'); ?>
					</div>
				</div>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>
	</div>
	<input type="hidden" name="task" value="product.edit" />
	<?php echo JHtml::_('form.token'); ?>
</form>
