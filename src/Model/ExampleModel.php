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

namespace NXD\Module\BluePrint\Site\Model;

defined('_JEXEC') or die;

class ExampleModel
{
	public function __construct()
	{
	}

	/**
	 * Method to get the items
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function getItems()
	{
		$items = [
			(object) [
				'title' => 'Item 1',
				'link'  => 'https://www.nx-designs.ch'
			],
			(object) [
				'title' => 'Item 2',
				'link'  => 'https://www.nx-designs.ch'
			],
			(object) [
				'title' => 'Item 3',
				'link'  => 'https://www.nx-designs.ch'
			]
		];

		return $items;
	}
}