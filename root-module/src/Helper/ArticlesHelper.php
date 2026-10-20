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

use Joomla\CMS\Access\Access;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\Component\Content\Site\Helper\RouteHelper;
use Joomla\CMS\Router\Route;
use Joomla\Database\DatabaseInterface;
use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;

class ArticlesHelper
{

	/**
	 * Method to get the items
	 *
	 * @param   array   $params  The module parameters
	 * @param   object  $app     The application object
	 *
	 * @return  array
	 *
	 * @since   [VERSION]
	 */
	public function getItems(Registry $moduleParams, $app): array
	{
		$user = $app->getIdentity();

		// Access filter
		$access     = !ComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = Access::getAuthorisedViewLevels($user->get('id'));

		// Get the items
		// Get the Dbo and User object
		$db    = Factory::getContainer()->get(DatabaseInterface::class);
		$query = $db->getQuery(true);
		$query->select(array('c.id', 'c.title', 'c.alias', 'c.catid', 'c.language', 'c.access', 'c.created_by', 'c.images'))
			->from($db->quoteName('#__content', 'c'));

		/*
		 * #########################
		 * Some Filters as example currently no Params are defined
		 * #########################
		 */

		// Filter by category
		if ($moduleParams->get('catid')) {
			$db->where('a.catid = ' . (int) $moduleParams->get('catid'));
		}

		// Filter by language
		if ($moduleParams->get('language')) {
			$db->where('a.language = ' . $db->quote($moduleParams->get('language')));
		}

		// Filter by tags
		if ($moduleParams->get('tags')) {
			$tags = ArrayHelper::toInteger(explode(',', $moduleParams->get('tags')));
			$db->join('#__contentitem_tag_map AS m ON m.content_item_id = a.id')
				->where('m.tag_id IN (' . implode(',', $tags) . ')');
		}

		// Filter by author
		if ($moduleParams->get('author')) {
			$db->where('a.created_by = ' . (int) $moduleParams->get('author'));
		}

		// Filter by featured
		if ($moduleParams->get('featured')) {
			$db->where('a.featured = 1');
		}

		// Filter by access
		if ($moduleParams->get('access')) {
			$db->where('a.access = ' . (int) $moduleParams->get('access'));
		}

		/*
		 * #########################
		 * end of Example Filters
		 * #########################
		 */

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		// Get the items
		$items = $db->loadObjectList();

		// Process the items
		foreach ($items as &$item) {
			$item->slug    = $item->id . ':' . $item->alias;

			if ($access || \in_array($item->access, $authorised)) {
				// We know that user has the privilege to view the article
				$item->link = Route::_(RouteHelper::getArticleRoute($item->slug, $item->catid, $item->language));
			} else {
				$item->link = Route::_('index.php?option=com_users&view=login');
			}
		}

		return $items;
	}
}