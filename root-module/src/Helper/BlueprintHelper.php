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

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Session\Session;
use Joomla\Database\DatabaseInterface;
use Joomla\Registry\Registry;
use NXD\Module\BluePrint\Site\Model\ExampleModel;


class BlueprintHelper
{
	/**
	 * Method to get the items the helper calls the model to get the items
	 *
	 * @param   array  $params  The module parameters
	 * @param   object $app     The application object
	 *
	 * @return  array
	 *
	 * @since   [EXTENSION-VERSION]
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

	/**
	 * Demo Ajax Call to Module backend
	 * method name must be the used function name from js with Ajax suffix getData => getDataAjax
	 * @return array
	 *
	 * @throws \Exception
	 * @since [EXTENSION-VERSION]
	 */
    public function getDataAjax(): array
    {

	    // Check for CSRF (header OR POST field)
	    if (!Session::checkToken()) {
		    throw new \RuntimeException(Text::_('JINVALID_TOKEN'), 403);
	    }

        $user = Factory::getApplication()->getIdentity();

		// Optional -> throw exception if not logged in
        if ($user->id == 0) {
            // not logged on
           return ['message' => 'All fine try now to login first to get the params in return.'];
        }

	    $app   = Factory::getApplication();
	    $input = $app->getInput();

		// Optional
	    // Check authorisation (CSRF does NOT replace authorisation checks!)
	    if (!$app->getIdentity()->authorise('core.edit', 'com_content')) {
		    throw new \RuntimeException(Text::_('JERROR_ALERTNOAUTHOR'), 403);
	    }

	    // Recommended: Validate input (for JSON body)
	    $data = json_decode(file_get_contents('php://input'), true) ?? [];
	    $id   = (int) ($data['id'] ?? $input->getInt('id'));

		$moduleParameters = $this->getModuleParameters($id);

		if(!$moduleParameters){
			throw new \RuntimeException(Text::_("MOD_BLUEPRINT_AJAX_NO_PARAMS_ERROR"), 500);
		}

	    return $moduleParameters->toArray();
    }

	private function getModuleParameters(int $id): false | Registry
	{
		if(!$id){
			return false;
		}

		$db    = Factory::getContainer()->get(DatabaseInterface::class);
		$query = $db->createQuery()
			->select('*')
			->from('#__modules AS m')
			->where('m.id = ' . $id);

		$db->setQuery($query);

		$res = $db->loadObject();
		error_log(print_r($res,1));
		return new Registry($res);
	}

}