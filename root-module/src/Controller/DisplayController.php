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

namespace NXD\Module\SomeModule\Site\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;

class DisplayController extends BaseController
{
    /**
     * Default Task example
     * @since [EXTENSION-VERSION]
     */

    public function display($cachable = false, $urlparams = array())
    {
        // Get some data or validate

        // Render default template
        parent::display($cachable, $urlparams);
    }

    /**
     * Example AJAX Task
     * @since [EXTENSION-VERSION]
     */

    public function getAjaxData()
    {
        // Check Session Token
        $this->checkToken('post');      // default is post

        $app = $this->app;
        $data = ['status' => 'success', 'html' => 'Content to return'];

        // Return the JSON and close the App call
        $app->setHeader('Content-Type', 'application/json', true);
        $app->sendHeaders();
        echo json_encode($data, JSON_THROW_ON_ERROR);
        $app->close();
    }
}