<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/clients', name: 'clients')]
    #[IsGranted("ROLE_ADMIN")]
    public function clients(ClientRepository $clientRepository): Response
    {


        return $this->render('client/index.html.twig', [
            'clients' => $clientRepository->findAll(),
        ]);
    }

    #[Route('/client/show/{id}', name: 'client_show')]
    #[IsGranted("ROLE_ADMIN")]
    public function show($id, ClientRepository $clientRepository): Response
    {
        $c = $clientRepository->find($id);


        return $this->render('client/show.html.twig', [
            'client' => $c,
        ]);
    }

    #[Route('/client/delete/{id}', name: 'client_delete')]
    #[IsGranted("ROLE_ADMIN")]
    public function delete($id, EntityManagerInterface $manager, ClientRepository $clientRepository): Response
    {
        $s = $clientRepository->find($id);
        $manager->remove($s);
        $manager->flush();

        return $this->redirectToRoute("clients");
    }

    #[Route('/client/add', name: 'client_add')]
    #[Route('/client/edit/{id}', name: 'client_edit')]
    #[IsGranted("ROLE_ADMIN")]
    public function addEdit($id = null, ClientRepository $clientRepository, EntityManagerInterface $manager, Request $request): Response
    {
        $client = new Client();
        $editMode = false;
        if($id != null) {
            $client = $clientRepository->find($id);
            $editMode = true;
        }
        
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $client->setCreateur($this->getUser());
            $manager->persist($client);
            $manager->flush();
            return $this->redirectToRoute("client_show", ['id'=>$client->getId()]);
        }


        return $this->render('client/form.html.twig', [
            'form' => $form->createView(),
            'editMode' => $editMode
        ]);
    }
}
