<?php
/**
 * @package                                     NXD BluePrint Module
 *
 * @author                                      NXD | Marco Rensch <support@nx-designs.ch>
 * @copyright                                   Copyright(R) 2024 by NXD nx-designs
 * @license                                     GNU General Public License version 2 or later; see LICENSE.txt
 * @link                                        https://www.nx-designs.ch
 *
 * @var $container  Joomla\DI\Container         The DI container
 */

defined('_JEXEC') or die;

use Joomla\CMS\Extension\Service\Provider\HelperFactory;
use Joomla\CMS\Extension\Service\Provider\Module;
use Joomla\CMS\Extension\Service\Provider\ModuleDispatcherFactory;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

return new class() implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container->registerServiceProvider( new ModuleDispatcherFactory('\\NXD\\Module\\BluePrint'));
        $container->registerServiceProvider( new HelperFactory('\\NXD\\Module\\BluePrint\\Site\\Helper'));
        $container->registerServiceProvider( new Module());
    }
};