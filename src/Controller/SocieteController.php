<?php

namespace App\Controller;

use App\Entity\Societe;
use App\Form\SocieteType;
use App\Repository\SocieteRepository;
use Doctrine\DBAL\Tools\Dumper;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\Test\DummyTest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SocieteController extends AbstractController
{
    #[Route('/societes', name: 'societes')]
    #[IsGranted("ROLE_ADMIN")]
    public function societes(SocieteRepository $societeRepository): Response
    {


        return $this->render('societe/index.html.twig', [
            'societes' => $societeRepository->findAll(),
        ]);
    }

    #[Route('/societe/show/{id}', name: 'societe_show')]
    #[IsGranted("ROLE_ADMIN")]
    public function show($id, SocieteRepository $societeRepository): Response
    {
        $s = $societeRepository->find($id);


        return $this->render('societe/show.html.twig', [
            'societe' => $s,
        ]);
    }

    #[Route('/societe/delete/{id}', name: 'societe_delete')]
    #[IsGranted("ROLE_ADMIN")]
    public function delete($id, EntityManagerInterface $manager, SocieteRepository $societeRepository): Response
    {
        $s = $societeRepository->find($id);
        $manager->remove($s);
        $manager->flush();

        return $this->redirectToRoute("societes");
    }

    #[Route('/societe/add', name: 'societe_add')]
    #[Route('/societe/edit/{id}', name: 'societe_edit')]
    #[IsGranted("ROLE_ADMIN")]
    public function addEdit($id = null, SocieteRepository $societeRepository, EntityManagerInterface $manager, Request $request): Response
    {
        $societe = new Societe();
        $editMode = false;
        if($id != null) {
            $societe = $societeRepository->find($id);
            $editMode = true;
        }
        
        $form = $this->createForm(SocieteType::class, $societe);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($societe);
            $manager->flush();
            return $this->redirectToRoute("societe_show", ['id'=>$societe->getId()]);
        }


        return $this->render('societe/form.html.twig', [
            'form' => $form->createView(),
            'editMode' => $editMode
        ]);
    }

}
