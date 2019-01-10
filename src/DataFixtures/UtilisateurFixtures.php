<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UtilisateurFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->addUtilisateurs($manager);
    }

    private function addUtilisateurs(ObjectManager $manager)
    {
        $utilisateurs = [
            ['idUtilisateur' => 1,'login' => 'admin1', 'mdp' => 'mdp1', 'nomUtilisateur' => 'Admin', 'prenomUtilisateur' => '1', 'droitAdmin' => true],
            ['idUtilisateur' => 2,'login' => 'admin2', 'mdp' => 'mdp2', 'nomUtilisateur' => 'Admin', 'prenomUtilisateur' => '2', 'droitAdmin' => true],
            ['idUtilisateur' => 3,'login' => 'user1', 'mdp' => 'mdp1', 'nomUtilisateur' => 'User', 'prenomUtilisateur' => '3', 'droitAdmin' => false],
            ['idUtilisateur' => 4,'login' => 'user2', 'mdp' => 'mdp2', 'nomUtilisateur' => 'User', 'prenomUtilisateur' => '4', 'droitAdmin' => false],
            ['idUtilisateur' => 5,'login' => 'user3', 'mdp' => 'mdp3', 'nomUtilisateur' => 'User', 'prenomUtilisateur' => '5', 'droitAdmin' => false]
        ];
        foreach ($utilisateurs as $utilisateur)
        {
            $new_utilisateur = new Utilisateur();
            $new_utilisateur->setLogin($utilisateur['login']);
            $new_utilisateur->setMdp($utilisateur['mdp']);
            $new_utilisateur->setNomUtilisateur($utilisateur['nomUtilisateur']);
            $new_utilisateur->setPrenomUtilisateur($utilisateur['prenomUtilisateur']);
            $new_utilisateur->setDroitAdmin($utilisateur['droitAdmin']);
            echo $utilisateur['login']." - ".$utilisateur['mdp']." - ".$utilisateur['droitAdmin']."\n";   // à remplacer

            $manager->persist($new_utilisateur);
            $manager->flush();
        }
    }
}
