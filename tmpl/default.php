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
 * @var     $module     \Joomla\CMS\Module\Module   The module object
 * @var     $params     \Joomla\Registry\Registry   The module params
 * @var     $assetsPath string                      The path to the module assets
 *
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;

// Get the WebAsset Manager
$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
// Load the required assets
$wa->useStyle('mod_blueprint.css.main');
$wa->useScript('mod_blueprint.js.main');
$wa->useScript('mod_blueprint.js.es6');

// Use an Inline Script to call the ES6 Module
$javascript = <<<JS
	import { ES6Module } from "{$assetsPath}/js/es6_module.js"
	const example = new ES6Module('Foo');
	example.init();
JS;
$wa->addInlineScript($javascript, [], ['type' => 'module']);

$javascript2 = <<<JS
	import { ES6Module } from "{$assetsPath}/js/es6_module.js";
	const example = new ES6Module({$module->id});
	example.init();
JS;

// Add an inline content that will be placed after "mod_renegade.js.main" asset
$wa->addInlineScript($javascript2, [], ['type' => 'module']);

echo 'Hello World from tmpl/default.php!';