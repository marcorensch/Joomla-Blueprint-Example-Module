<?php
/**
 * @package                                     [CREATORCOMPANY] BluePrint Module
 *
 * @author                                      [CREATORCOMPANY] | [CREATORNAME] <[CREATOREMAIL]>
 * @copyright                                   Copyright(R) [CREATEDYEAR] by [CREATORCOMPANY] | [CREATORNAME]
 * @license                                     GNU General Public License version 2 or later; see LICENSE.txt
 * @link                                        [CREATORURL]
 * @since                                       [VERSION]
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
		$data['items'] = $this->getHelperFactory()->getHelper($helperName)->getItems($data['params'], $this->getApplication());

		return $data;
	}
}