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

class RulesController extends AbstractController {

    /**
     * @Route("/rules",name="rules")
     * @return Response
     */
    public function index():Response{
        return $this->render('pages/rules.html.twig',[
            'current_menu' => 'rules'
        ]);
    }
}