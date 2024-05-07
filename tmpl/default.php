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
// Load the required assets
$wa->useStyle('mod_blueprint.css.main');
$wa->useScript('mod_blueprint.js.main');
$wa->useScript('mod_blueprint.js.es6');

// Add an inline script (module) to the document
// Get the path to the module assets
$assetsPath = '/media/mod_blueprint/';
// Use an Inline Script to call the ES6 Module
$javascript = <<<JS
	import { ES6Module } from "{$assetsPath} + js/es6_module.js";
	const example = new ES6Module();
	example.init();
JS;
$wa->addInlineScript($javascript, ['type' => 'module']);

echo 'Hello World from tmpl/default.php!';