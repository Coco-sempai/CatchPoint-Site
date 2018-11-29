<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Created by PhpStorm.
 * User: coren
 * Date: 27/11/2018
 * Time: 19:10
 */

class InscriptionController extends AbstractController{

    /**
     * @var ObjectManager
     */
    private $em;


    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/inscription",name="inscription")
     * @param Request $req
     * @return Response
     */
    public function index(Request $req):Response{
        $user = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class,$user);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()){
            $this->em->persist($user);
            $this->em->flush();
            return $this->redirectToRoute("home",[
                'user'=>$user
            ]);
        }

        return $this->render('pages/inscription.html.twig',[
            'form'=>$form->createView()
        ]);
    }

}