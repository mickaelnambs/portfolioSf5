<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController.
 * 
 * @author Mickael Nambinintsoa <mickael.nambinintsoa07081999@gmail.com>
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home", methods={"POST","GET"})
     */
    public function index()
    {
        return $this->render('front/home/index.html.twig');
    }
}