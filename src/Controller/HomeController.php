<?php
/**
 * Created by PhpStorm.
 * User: coren
 * Date: 25/11/2018
 * Time: 17:44
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class HomeController{

    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function index():Response{
        return new Response($this->twig->render('pages/home.html.twig'));
    }
}