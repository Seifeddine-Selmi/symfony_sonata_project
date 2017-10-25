<?php

namespace Selmi\JobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SelmiJobBundle:Default:index.html.twig');
    }
}
