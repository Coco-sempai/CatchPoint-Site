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

    /**
     * @Route("/rules",name="home.rules")
     * @return Response
     */
    public function rules():Response{
        return $this->render('pages/rules.html.twig',[
            'current_menu' => 'rules'
        ]);
    }

    /**
     * @Route("/history",name="home.history")
     * @return Response
     */
    public function history():Response{
        return $this->render('pages/history.html.twig',[
            'current_menu' => 'history'
        ]);
    }

}