<?php

namespace App\Controller;


use App\Entity\Parcours;
use App\Entity\Points;
use App\Form\ParcoursType;
use Doctrine\Common\Persistence\ObjectManager;
use ErrorException;
use PhpParser\Node\Expr\Array_;
use stdClass;
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


    const MIN_WAYPOINTS_AMMOUNT = 3;
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
        $form = $this->createForm(ParcoursType::class, $parcours);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()){

            // TODO:
            /* for each waypoint verify it has a name, hint, latlng... + types
             * verify waypoints.length between min and max
             *
             */

            $waypoints = json_decode($_POST['waypointsData']);

            $err = false;
            $distanceTotale = 0;

            foreach ($waypoints as $key => $waypoint){
                try {

                    $waypoint->name;
                    $waypoint->hint;
                    $waypoint->lat;
                    $waypoint->lng;
                    if(isset($last)){
                        $distanceTotale+=self::distance($waypoint->lat,$waypoint->lng,$last->lat,$last->lng);
                    }
                    $last = $waypoint;
                } catch (ErrorException $e) { $err = true; }
            }

            if (!is_array($waypoints)) {

                $err = true;

            } else {

                if (sizeof($waypoints) > $this::MAX_WAYPOINTS_AMMOUNT) {
                    $err = true;
                }

                if (sizeof($waypoints) < $this::MIN_WAYPOINTS_AMMOUNT) {
                    $err = true;
                }
            }

            if ($err) {

                $this->addFlash('error','Une erreur est survenue lors de la mise en ligne de votre parcours.');
                return $this->redirectToRoute('home.parcours');
            }

            $parcours->setDistance(round($distanceTotale, 2));
            $parcours->setDuree(self::calculDuree($distanceTotale,sizeof($waypoints)));
            $this->em->persist($parcours);
            $this->em->flush();

            foreach ($waypoints as $key => $waypoint) {

                $newPoint = new Points();
                $newPoint->setDepart($key==0)
                    ->setArrive($key==sizeof($waypoints)-1)
                    ->setTitrePoint($waypoint->name)
                    ->setLatitude($waypoint->lat)
                    ->setLongitude($waypoint->lng)
                    ->setDecriptionPoint($waypoint->hint)
                    ->setParcoursId($parcours);

                $this->em->persist($newPoint);
            }

            $this->em->flush();
            $this->addFlash('success','Parcours créé avec succès');
            return $this->redirectToRoute('home.parcours');

        }

        return $this->render('pages/AddParcours.html.twig', array(
            'parcours' => $parcours,
            'form' =>$form->createView(),
            'current_menu' => 'parcours',
            'MIN_WAYPOINTS_AMMOUNT' => self::MIN_WAYPOINTS_AMMOUNT,
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

        $idParcours = $parcours->getIdParcours();

        $repository = $this->getDoctrine()->getRepository(Points::class);

        $points = $repository->findBy(['parcours_id' => $parcours]);

        $result = Array();

        foreach ($points as $key => $point) {

            $pointToSend = new stdClass();
            $pointToSend->name = $point->getTitrePoint();
            $pointToSend->hint = $point->getDecriptionPoint();
            $pointToSend->lat = $point->getLatitude();
            $pointToSend->lng = $point->getLongitude();

            array_push($result, $pointToSend);
        }

        $json_points = (json_encode(array_values($result)));



        return $this->render('pages/showParcours.html.twig',[
            'parcours' => $parcours,
            'current_menu' => 'parcours',
            'waypoints' => $json_points
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

            $idParcoursToDelete = $parcours->getIdParcours();
            $repository = $this->getDoctrine()->getRepository(Points::class);
            $points = $repository->findBy(['parcours_id' => $parcours]);

            foreach ($points as $point){
                $this->em->remove($point);
            }

            $this->em->remove($parcours);

            $this->addFlash('success','Parcours supprimé avec succès');
            $this->em->flush();
        }
        return $this->redirectToRoute('home.parcours');
    }


    /**
     * @Route("/api/parcours", name="parcours.getParcours", methods={"GET"}))
     *
     */
    public function getParcours(Request $request) {
        $repository = $this->getDoctrine()->getRepository(Parcours::class);
        $parcours=$repository->findAll();

        $data =  $this->get('serializer')->serialize($parcours, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/api/parcours/depart", name="parcours.getDepart", methods={"GET"}))
     *
     */
    public function getDepart(Request $request) {
        $repository = $this->getDoctrine()->getRepository(Points::class);
        $points= $repository->findBy(
            ['depart' => true]
        );

        $data =  $this->get('serializer')->serialize($points, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/api/parcours/points/{id}", name="parcours.getPoint", methods={"GET"}))
     *
     */
    public function getPoint(Request $request) {
        $repository = $this->getDoctrine()->getRepository(Points::class);
        $repositoryParcours = $this->getDoctrine()->getRepository(Parcours::class);
        $url = $request->getUri();
        $parcours = explode("/",$url);
        $parcours = $repositoryParcours->findBy(['idParcours' => $parcours[sizeof($parcours)-1]]);
        $points = $repository->findBy(['parcours_id' => $parcours]);

        $data =  $this->get('serializer')->serialize($points, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * Retourne la distance en metre ou kilometre (si $unit = 'k') entre deux latitude et longitude fournit
     */
    public static function distance($lat1, $lng1, $lat2, $lng2, $unit = 'k') {
        $earth_radius = 6378137;   // Terre = sphère de 6378km de rayon
        $rlo1 = deg2rad($lng1);
        $rla1 = deg2rad($lat1);
        $rlo2 = deg2rad($lng2);
        $rla2 = deg2rad($lat2);
        $dlo = ($rlo2 - $rlo1) / 2;
        $dla = ($rla2 - $rla1) / 2;
        $a = (sin($dla) * sin($dla)) + cos($rla1) * cos($rla2) * (sin($dlo) * sin($dlo));
        $d = 2 * atan2(sqrt($a), sqrt(1 - $a));
        //
        $meter = ($earth_radius * $d);
        if ($unit == 'k') {
            return $meter / 1000;
        }
        return $meter;
    }

    /**
     * Calcul la durée du parcours en fonction de sa distance total et de la vitesse de marche moyenne + 2min par points
     */
    public static function calculDuree($distance,$nbPoint){
        return round($distance/4*60)+2*$nbPoint;
    }
}


