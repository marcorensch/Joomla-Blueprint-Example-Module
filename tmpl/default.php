<?php
/**
 * @package                                     NXD BluePrint Module
 *
 * @author                                      [CREATOR-COMPANY] | [CREATOR-FULLNAME] <[CREATOR-EMAIL]>
 * @copyright                                   Copyright(R) [CREATED-YEAR] by [CREATOR-COMPANY] | [CREATOR-FULLNAME]
 * @license                                     GNU General Public License version 2 or later; see LICENSE.txt
 * @link                                        [CREATOR-URL]
 * @since                                       [EXTENSION-VERSION]
 *
 */

use Joomla\CMS\Layout\LayoutHelper;

defined('_JEXEC') or die;

// Load the Assets Layout that includes the WebAssets calls
LayoutHelper::render('NXD\Module\BluePrint\Layout\loadAssets');

echo 'Hello World from tmpl/default.php!';