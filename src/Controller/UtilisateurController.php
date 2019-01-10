<?php

namespace App\Controller;

use App\Entity\Utilisateur;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Symfony\Component\HttpFoundation\JsonResponse;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/utilisateur", name="utilisateur.login", methods={"POST"})
     */
    public function login(Request $request) {
        $login= $request->request->get('login', 'empty'); // $_POST
        $mdp= $request->request->get('mdp', 'empty'); // $_POST

        $repository = $this->getDoctrine()->getRepository(Utilisateur::class);
        $utilisateur = $repository->findOneBy([
            'login' => $login,
            'mdp' => $mdp
        ]);
        if ($utilisateur==""){
            $response = new JsonResponse(array('erreur' => 'Login/Mot de passe erroné(s)'));
            return $response;
        }else{
            $data =  $this->get('serializer')->serialize($utilisateur, 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }


    }

}