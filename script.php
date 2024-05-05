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

use Joomla\CMS\Factory;
use Joomla\CMS\Installer\InstallerScript;

defined('_JEXEC') or die;

class ModBluePrintInstallerScript extends InstallerScript
{
	/**
	 * Method to install the extension
	 *
	 * @param   string  $route  The path to the extension manifest file
	 *
	 * @return  void
	 *
	 * @since   [VERSION]
	 */
	public function install($route)
	{
		// Install the extension
		Factory::getApplication()->enqueueMessage('The [CREATORCOMPANY] BluePrint Module has been installed successfully.');
	}

	/**
	 * Method to uninstall the extension
	 *
	 * @param   array  $data  An array of data returned by the install() method
	 *
	 * @return  void
	 *
	 * @since   [VERSION]
	 */
	public function uninstall($data)
	{
		// Uninstall the extension
		Factory::getApplication()->enqueueMessage('The [CREATORCOMPANY] BluePrint Module has been uninstalled successfully.');
	}

	/**
	 * Method to update the extension
	 *
	 * @param   array  $data  An array of data returned by the install() method
	 *
	 * @return  void
	 *
	 * @since   [VERSION]
	 */
	public function update($data)
	{
		// Update the extension
		Factory::getApplication()->enqueueMessage('The [CREATORCOMPANY] BluePrint Module has been updated successfully.');
	}

	/**
	 * Method to run before an install/update/uninstall method
	 *
	 * @param   string  $type  The type of change (install, update, or uninstall)
	 * @param   array   $data  An array of data returned by the install() method
	 *
	 * @return  void
	 *
	 * @since   [VERSION]
	 */
	public function preflight($type, $data)
	{
		// Preflight the extension
	}

	/**
	 * Method to run after an install/update/uninstall method
	 *
	 * @param   string  $type  The type of change (install, update, or uninstall)
	 * @param   array   $data  An array of data returned by the install() method
	 *
	 * @return  void
	 *
	 * @since   [VERSION]
	 */
	public function postflight($type, $data)
	{
		// Postflight the extension
	}
}