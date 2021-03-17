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

$app = JFactory::getApplication();
$function	= $app->input->getCmd('function', 'jSelectProduct');
?>
<?php foreach($this->items as $i => $item): ?>
        <tr class="row<?php echo $i % 2; ?>">
                <td>
<a href="javascript:void(0)" onclick="if (window.parent) window.parent.<?php echo $this->escape($function);?>('<?php echo $item->id; ?>', '<?php echo $this->escape(addslashes($item->name)); ?>', '<?php echo $this->escape($item->price); ?>', '<?php echo $this->escape($item->stock); ?>');">
                        <?php echo $item->name; ?></a>
                </td>
                <td>
                        <?php echo $item->number; ?>
                </td>
                <td>
                        <?php echo $item->price; ?>
                </td>
                <td>
                        <?php echo $item->stock; ?>
                </td>
        </tr>
<?php endforeach; ?>

