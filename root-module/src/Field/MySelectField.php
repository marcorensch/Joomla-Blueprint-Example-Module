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

namespace NXD\Module\BluePrint\Site\Field;

defined('_JEXEC') or die;

use Joomla\CMS\Form\Field\ListField;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use stdClass;

class MySelectField extends ListField
{
	protected $type = 'MySelect';

	protected function getOptions(): array
	{
		// Merge any additional options from the XML definition.
		$options = parent::getOptions();

		$options[] = $this->createOption('articles', Text::_('JGLOBAL_ARTICLES'));
		$options[] = $this->createOption('2', 'Option 2');
		$options[] = $this->createOption('3', 'Option 3');

		return $options;
	}

	private function createOption(string $value, string $label): stdClass
	{
		return HTMLHelper::_('select.option', $value, $label);
	}
}