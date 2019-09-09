<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class FrontController
 * @package App\Controller
 */
class FrontController extends AbstractController
{
    /**
     * @Route("/", name="page_home")
     */
    public function showPageHome()
    {
        return $this->render('pages/home.html.twig');
    }

    /**
     * @Route("/page/1", name="page_one")
     */
    public function showPageOne()
    {

        return $this->render('pages/one.html.twig');
    }

    /**
     * @Route("/page/2", name="page_two")
     */
    public function showPageTwo()
    {
        return $this->render('pages/two.html.twig');
    }
}
