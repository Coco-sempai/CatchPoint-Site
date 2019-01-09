<?php

namespace App\Controller;


use App\Entity\Parcours;
use App\Form\ParcoursType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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


    const MAX_WAYPOINTS_AMMOUNT = 10;


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

        return $this->render('pages/AddParcours.html.twig', array(
            'parcours' => $parcours,
            'form' =>$form->createView(),
            'current_menu' => 'parcours',
            'MAX_WAYPOINTS_AMMOUNT' => self::MAX_WAYPOINTS_AMMOUNT
        ));
    }

    /**
     * @Route("/{slug}-{id}", name="parcours.show", requirements={"slug": "[a-zA-Z0-9\-]*"})
     * @param Parcours $parcours
     * @param string $slug
     * @return Response
     */
    public function show(Parcours $parcours, string $slug): Response{
        if ($parcours->getSlug() !== $slug){
            return $this->redirectToRoute('home.parcours', [
                'id'=> $parcours->getIdParcours(),
                'slug'=>$parcours->getSlug()
            ], 301);
        }
        return $this->render('pages/showParcours.html.twig',[
            'parcours' => $parcours,
            'current_menu' => 'parcours'
        ]);
    }

    /**
     * @Route("parcours/{id}", name = "parcours.delete", methods="DELETE")
     * @param Parcours $parcours
     * @param Request $req
     * @return RedirectResponse
     */
    public function delete(Parcours $parcours, Request $req){
        if($this->isCsrfTokenValid('delete' . $parcours->getIdParcours(),$req->get('_token'))){
            $this->em->remove($parcours);
            $this->addFlash('success','Parcours supprimé avec succès');
            $this->em->flush();
        }
        return $this->redirectToRoute('home.parcours');
    }
}


