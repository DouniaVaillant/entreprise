<?php

namespace App\Controller;

use App\Entity\Employes;
use App\Form\EmployesType;
use App\Repository\EmployesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployesController extends AbstractController
{
    #[Route('/employes', name: 'app_employes')]
    public function index(): Response
    {
        return $this->render('employes/index.html.twig', [
            'controller_name' => 'EmployesController',
        ]);
    }
    
    #[Route('/', name: 'employes_liste')]
    public function liste(EmployesRepository $repo): Response
    {

        $employes = $repo->findAll();
        // dd($employes);

        return $this->render('employes/liste.html.twig', [
            'employes' => $employes,
        ]);

    }

    #[Route('/employes/ajouter', name: 'employe_create')]
    #[Route('/employes/modifier/{id}', name: 'employe_edit')]
    public function form(Request $globals, EntityManagerInterface $manager, Employes $employes = null) : Response
    {
        if ($employes == null) { 
            $employes = new Employes;
        }

        $form = $this->createForm(EmployesType::class, $employes);
        $form->handleRequest($globals);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($employes);
            $manager->flush();

            return $this->redirectToRoute('employes_liste', [
                'id' => $employes->getId()
            ]);
        }

        return $this->renderForm("employes/form.html.twig", [
            'formEmployes' => $form,
            'editMode' => $employes->getId() !== null
        ]);
    }
    
    #[Route('/employes/supprimer{id}', name: 'employe_delete')]
    public function delete($id, EntityManagerInterface $manager, EmployesRepository $repo) : Response
    {
        $employes= $repo->find($id);
        $manager->remove($employes);
        $manager->flush();

        return $this->redirectToRoute('employes_liste');
    }
}
