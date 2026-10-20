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

namespace NXD\Module\BluePrint\Site\Helper;

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use NXD\Module\BluePrint\Site\Model\ExampleModel;


class BluePrintHelper
{
	/**
	 * Method to get the items the helper calls the model to get the items
	 *
	 * @param   array  $params  The module parameters
	 * @param   object $app     The application object
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function getItems($params, $app)
	{
		// Get the model
		$model = new ExampleModel($app);

		// Get the items from the model
		$items = $model->getItems();

		// Process the items
		foreach ($items as $item)
		{
			$item->title = Text::_($item->title);
		}

		return $items;
	}

}