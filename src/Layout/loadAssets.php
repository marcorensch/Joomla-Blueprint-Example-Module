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

use Joomla\CMS\Factory;

defined('_JEXEC') or die;

// Get the WebAsset Manager
$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
// Load the assets
$wa->useStyle('mod_blueprint.css.main');
$wa->useScript('mod_blueprint.js.main');
