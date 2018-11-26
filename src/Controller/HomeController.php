<?php
/**
 * Created by PhpStorm.
 * User: coren
 * Date: 25/11/2018
 * Time: 17:44
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController extends AbstractController {

    /**
     * @Route("/",name="home")
     * @return Response
     */
    public function index():Response{
        return $this->render('pages/home.html.twig',[
            'current_menu' => 'home'
        ]);
    }
}