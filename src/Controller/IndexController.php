<?php
/**
 * Phire Social Module
 *
 * @link       https://github.com/phirecms/phire-social
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2016 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.phirecms.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Phire\Social\Controller;

use Phire\Social\Model;
use Phire\Controller\AbstractController;

/**
 * Social Index Controller class
 *
 * @category   Phire\Social
 * @package    Phire\Social
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2016 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.phirecms.org/license     New BSD License
 * @version    1.0.0
 */
class IndexController extends AbstractController
{

    /**
     * Index action method
     *
     * @return void
     */
    public function index()
    {
        $this->prepareView('social/index.phtml');
        $social = new Model\Social();

        if ($this->request->isPost()) {
            $social->save($this->request->getPost());
            $this->sess->setRequestValue('saved', true);
            $this->redirect(BASE_PATH . APP_URI . '/social');
        } else {
            $this->view->title       = 'Social Media';
            $this->view->socialConfig = $social->getConfig();
        }

        $this->send();
    }

    /**
     * Prepare view
     *
     * @param  string $template
     * @return void
     */
    protected function prepareView($template)
    {
        $this->viewPath = __DIR__ . '/../../view';
        parent::prepareView($template);
    }

}
