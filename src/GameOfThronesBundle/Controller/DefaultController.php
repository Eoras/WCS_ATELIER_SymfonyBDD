<?php

namespace GameOfThronesBundle\Controller;

use GameOfThronesBundle\Entity\Personnage;
use Proxies\__CG__\GameOfThronesBundle\Entity\Royaume;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('GameOfThronesBundle:Default:index.html.twig');
    }

    /**
     * @Route("/Personnages")
     */
    public function showAllPersonnageAction()
    {
        $em = $this->getDoctrine()->getManager();
        $personnages = $em->getRepository('GameOfThronesBundle:Personnage')
            ->findAll();
        return $this->render('GameOfThronesBundle:Default:personnages.html.twig', [
            'personnages' => $personnages,
        ]);
    }

    /**
     * @Route("/Personnages/{id}")
     */
    public function showPersonnageAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $personnage = $em->getRepository('GameOfThronesBundle:Personnage')
            ->find($id);
        return $this->render('GameOfThronesBundle:Default:personnages.html.twig', [
            'personnage' => $personnage,
        ]);
    }

    /**
     * @Route("/Sexe/{sexe}")
     */
    public function listPersonnageAction($sexe)
    {
        $em = $this->getDoctrine()->getManager();
        $personnages = $em->getRepository('GameOfThronesBundle:Personnage')
            ->findBy(['sexe' => $sexe]);
        return $this->render('GameOfThronesBundle:Default:personnages.html.twig', [
            'personnages' => $personnages,
        ]);
    }

    /**
     * @Route("/addPersonnage")
     */
    public function addPersoAction()
    {
        $personnage = new Personnage();
        $errors = [];

        if (!empty($_POST)) {

            $personnage->setNom($_POST['nom']);
            $personnage->setPrenom($_POST['prenom']);
            $personnage->setSexe($_POST['sexe']);
            $personnage->setBio($_POST['bio']);

            if (empty($_POST['nom'])) {
                $errors[] = 'Le nom est obligatoire !';
            }
            if (empty($_POST['prenom'])) {
                $errors[] = 'Le prénom est obligatoire !';
            }

            if (empty($_POST['sexe'])) {
                $errors[] = 'Vous devez définir un sexe !';
            }

            if (empty($_POST['bio'])) {
                $errors[] = 'Ajoutez une description !';
            }

            if (empty($errors)) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($personnage);
                $successMsg = true;
                $em->flush();
                return $this->render('GameOfThronesBundle:Default:personnages.html.twig', [
                    'successMsg' => $successMsg,
                    'personnage' => $personnage,
                ]);
            }

            return $this->render('GameOfThronesBundle:Default:addPersonnage.html.twig', [
                'personnage' => $personnage,
                'errors' => $errors,
            ]);
        }
        return $this->render('GameOfThronesBundle:Default:addPersonnage.html.twig', [
            'personnage' => $personnage,
            'errors' => $errors,
        ]);
    }

    /**
     * @Route("/DelPersonnage")
     */
    public function delPersonageAction()
    {
        if (!empty($_POST['id'])) {

            $em = $this->getDoctrine()->getManager();
            $personnage = $em->getRepository('GameOfThronesBundle:Personnage')
                ->find($_POST['id']);
            $em->remove($personnage);
            $em->flush();
            $succesMsgDel = "Personnage supprimé";
            return $this->render('GameOfThronesBundle:Default:personnages.html.twig', [
                'succesMsgDel' => $succesMsgDel,
                'personnage' => $personnage,
            ]);

        }
    }

    /**
     * @Route("/Royaumes")
     */
    public function showAllRoyaumeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $royaumes = $em->getRepository('GameOfThronesBundle:Royaume')
            ->findAll();
        return $this->render('GameOfThronesBundle:Default:royaumes.html.twig', [
            'royaumes' => $royaumes,
        ]);
    }

    /**
     * @Route("/Royaumes/{id}")
     */
    public function showOneRoyaumeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $royaume = $em->getRepository('GameOfThronesBundle:Royaume')
            ->find($id);
        return $this->render('GameOfThronesBundle:Default:royaumes.html.twig', [
            'royaume' => $royaume,
        ]);
    }


    /**
     * @Route("/addRoyaume")
     */
    public function addRoayumeAction()
    {
        $royaume = new Royaume();
        $errors = [];

        if (!empty($_POST)) {

            $royaume->setNom($_POST['nom']);
            $royaume->setCapitale($_POST['capitale']);
            $royaume->setNbHabitant($_POST['nbHabitant']);


            if (empty($_POST['nom'])) {
                $errors[] = 'Le nom est obligatoire !';
            }

            if (empty($_POST['capitale'])) {
                $errors[] = 'Précisez la capitale !';
            }

            if (empty($_POST['nbHabitant'])) {
                $errors[] = 'Ajouter un nombre d\'habitants';
            }

            if (empty($errors)) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($royaume);
                $successMsg = true;
                $em->flush();
                return $this->render('GameOfThronesBundle:Default:royaumes.html.twig', [
                    'successMsg' => $successMsg,
                    'royaume' => $royaume,
                ]);
            }

            return $this->render('GameOfThronesBundle:Default:addRoyaume.html.twig', [
                'royaume' => $royaume,
                'errors' => $errors,
            ]);
        }
        return $this->render('GameOfThronesBundle:Default:addRoyaume.html.twig', [
            'royaume' => $royaume,
            'errors' => $errors,
        ]);
    }

    /**
     * @Route("/ChangeRoyaume")
     */
    public function showChangeRoyaumeAction()
    {

        if (!empty($_GET['id'])) {

            $em = $this->getDoctrine()->getManager();
            $personnage = $em->getRepository('GameOfThronesBundle:Personnage')
                ->find($_GET['id']);
            $royaumes = $em->getRepository('GameOfThronesBundle:Royaume')
                ->findAll();
            return $this->render('GameOfThronesBundle:Default:changeRoyaume.html.twig', [
                'personnage' => $personnage,
                'royaumes' => $royaumes,

            ]);
        }

        return $this->render('GameOfThronesBundle:Default:index.html.twig');

    }

    /**
     * @Route("/SetNewRoyaume")
     */
    public function setNewRoyaumeAction()
    {
        if (!empty($_POST['id'])) {

            $em = $this->getDoctrine()->getManager();
            $personnage = $em->getRepository('GameOfThronesBundle:Personnage')
                ->find($_POST['id']);
            $royaume = $em->getRepository('GameOfThronesBundle:Royaume')
                ->find($_POST['royaume']);
            $personnage->setRoyaume($royaume);
            $em->flush();
            $successMsgChangeRoyaume = "Royaume modifié";
            return $this->render('GameOfThronesBundle:Default:personnages.html.twig', [
                'personnage' => $personnage,
                'royaume' => $royaume,
                'successMsgChangeRoyaume' => $successMsgChangeRoyaume,
            ]);

        }
    }

    /**
     * @Route("/DelRoyaume")
     */
    public function delRoyaumeAction()
    {
        if (!empty($_POST['id'])) {

            $em = $this->getDoctrine()->getManager();
            $royaume = $em->getRepository('GameOfThronesBundle:Royaume')
                ->find($_POST['id']);
            $em->remove($royaume);
            $em->flush();
            $succesMsgDel = "Royaume supprimé";
            return $this->render('GameOfThronesBundle:Default:royaumes.html.twig', [
                'succesMsgDel' => $succesMsgDel,
                'royaume' => $royaume,
            ]);

        }
    }

}
