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

class HistoryController extends AbstractController {

    /**
     * @Route("/history",name="history")
     * @return Response
     */
    public function index():Response{
        return $this->render('pages/history.html.twig',[
            'current_menu' => 'history'
        ]);
    }
}