<?php

namespace App\Controller;


use App\Entity\Parcours;
use App\Form\ParcoursType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Created by PhpStorm.
 * User: coren
 * Date: 03/12/2018
 * Time: 20:45
 */

class ParcoursController extends AbstractController{

    /**
     * @var ObjectManager
     */
    private $em;


    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * @Route ("/AddParcours", name="parcours.add")
     * @param Request $req
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function new(Request $req){
        $parcours = new Parcours();
        $form = $this->createForm(ParcoursType::class,$parcours);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()){
            $this->em->persist($parcours);
            $this->em->flush();
            $this->addFlash('success','Parcours créé avec succès');
            return $this->redirectToRoute('home.parcours');
        }

        return $this->render('pages/AddParcours.html.twig',[
            'parcours'=>$parcours,
            'form'=>$form->createView()
        ]);
    }

}


