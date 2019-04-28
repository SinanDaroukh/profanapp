<?php
/**
 * Created by PhpStorm.
 * User: arwoon_shlaka
 * Date: 06/04/19
 * Time: 12:39
 */

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="app_portalpage")
     */
    public function portalpage()
    {
        return $this->render('base.html.twig', [
            'last_username'     => null,
            'error'         =>  null
        ]);
    }


    /**
     * @Route("/home", name="app_homepage")
     */
    public function homepage(){

        return $this->render('home.html.twig');

    }
}