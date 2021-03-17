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

class NoKMyBusinessControllerCustomers extends JControllerAdmin {
	public function getModel($name = 'Product', $prefix = 'NoKMyBusinessModel', $config = array('ignore_request' => true)) {
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}

	protected function postDeleteHook(JModelLegacy $model, $ids = null) {
	}

	public function export() {
		$model = $this->getModel('Products');
 		$data = $model->getExportData();
		$encoding = 'UTF-8';
		$filename = 'products.csv';
		JLoader::register('CvsHelper', __DIR__.'/../helpers/cvs.php', true);
		CvsHelper::saveCVS($data, $encoding, $filename);
        }

	public function import() {
		$view = $this->getView('Products', 'html');
		$view->setLayout('import');
		$view->display();
	}

	public function import_do() {
		// Get the input
		$input = JFactory::getApplication()->input;
		$file = $input->files->get('importfile');
		$content = '';
		if (isset($file['tmp_name'])) {
			$content = file_get_contents($file['tmp_name']);
			unlink($file['tmp_name']);
		}
		$encoding = $input->get('encoding');
		JLoader::register('CvsHelper', __DIR__.'/../helpers/cvs.php', true);
		$data  = CvsHelper::loadCVS($content, $encoding);
		$model = $this->getModel('Products');
 		$model->saveImportData($data);
		$this->setRedirect(JRoute::_('index.php?option='.$this->option, false));
	}

	public function import_cancel() {
		$this->setRedirect(JRoute::_('index.php?option='.$this->option, false));
	}

	public function delete() {
		$cid = JFactory::getApplication()->input->get('cid', array(), 'array');
		$model = $this->getModel('Product');
		foreach ($cid as $id) {
			$model->delete($id);
		}
		$this->setRedirect(JRoute::_('index.php?option='.$this->option, false));
	}
}
?>
