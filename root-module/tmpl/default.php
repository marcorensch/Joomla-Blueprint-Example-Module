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
$wa->useScript('mod_blueprint.js.controller_ajax');

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

$javascriptAjax = <<<JS
	document.addEventListener("DOMContentLoaded", () => {
        const btn = document.querySelector('#ajax_button_{$module->id}');
        if(!btn){
            console.error("Could not find button")
        }
        btn.addEventListener('click', ()=>{
            callModuleAjax('getData', { id: {$module->id} })
            .then(data => {
                console.log('Success:', data);
            })
            .catch(error => {
                console.error('Failed:', error);
            });
        })
	})
JS;
$wa->addInlineScript($javascriptAjax, [], []);

echo 'Hello World from tmpl/default.php!';

?>

<div>
    <h4>AJAX Call via Controller example</h4>
    <p>
        Click on the button below to send an AJAX call to the module’s backend; this call is sent to the DisplayController via
        a method in the Dispatcher. Check the browser console for the response from the backend.
    </p>
    <button id="ajax_button_<?php echo $module->id;?>">Do AJAX Call</button>
</div>
