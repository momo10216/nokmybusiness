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

?>
<?php foreach($this->items as $i => $item): ?>
        <tr class="row<?php echo $i % 2; ?>">
                <td>
                        <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                </td>
                <td>
                        <?php echo $item->name; ?>
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
                <td>
                        <?php echo $item->published; ?>
                </td>
                <td>
                        <?php echo $item->status; ?>
                </td>
        </tr>
<?php endforeach; ?>

