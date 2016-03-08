<?php

namespace Phire\Social\Event;

use Phire\Social\Model;
use Phire\Controller\AbstractController;
use Pop\Application;

class Social
{

    /**
     * Init social model
     *
     * @param  AbstractController $controller
     * @param  Application        $application
     * @return void
     */
    public static function init(AbstractController $controller, Application $application)
    {
        if ((!$_POST) && ($controller->hasView()) && ($controller instanceof \Phire\Content\Controller\IndexController)) {
            $controller->view()->phire->social = new Model\Social();
        }
    }

    /**
     * Parse social navigation
     *
     * @param  AbstractController $controller
     * @param  Application        $application
     * @return void
     */
    public static function parse(AbstractController $controller, Application $application)
    {
        if (($controller->hasView()) && ($controller instanceof \Phire\Content\Controller\IndexController)) {
            $body = $controller->response()->getBody();
            if (strpos($body, '[{social_nav') !== false) {
                $social = new Model\Social();
                $body   = str_replace(
                    ['[{social_nav}]', '[{social_nav_styles}]'],
                    [$social->buildNav(), $social->getStyles()],
                    $body
                );

                $controller->response()->setBody($body);
            }
        }
    }

}
