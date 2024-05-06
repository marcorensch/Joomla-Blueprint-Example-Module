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

namespace NXD\Module\BluePrint\Site\Dispatcher;

defined('_JEXEC') or die;

use Joomla\CMS\Dispatcher\AbstractModuleDispatcher;
use Joomla\CMS\Helper\HelperFactoryAwareInterface;
use Joomla\CMS\Helper\HelperFactoryAwareTrait;
use Joomla\Registry\Registry;
use NXD\Module\BluePrint\Site\Helper\BluePrintHelper;

class Dispatcher extends AbstractModuleDispatcher implements HelperFactoryAwareInterface
{
	use HelperFactoryAwareTrait;

	protected function getLayoutData()
	{
		$params = new Registry($this->module->params);

		$data          = parent::getLayoutData();
		$helperName    = ucfirst($params->get('context', 'articles')) . 'Helper';
		// this example will only work with the BluePrintHelper and ArticlesHelper:
		if(in_array($helperName, ['BluePrintHelper', 'ArticlesHelper'])) {
			$data['items'] = $this->getHelperFactory()->getHelper($helperName)->getItems($data['params'], $this->getApplication());
		}else{
			// Return an empty array if we have selected a helper that does not exist only for the purpose of this example
			$data['items'] = [];
		}

		return $data;
	}
}