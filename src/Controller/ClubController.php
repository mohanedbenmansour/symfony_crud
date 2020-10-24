<?php

namespace App\Controller;

use App\Entity\Club;
use App\Form\ClubType;
use App\Repository\ClubRepository;
use http\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClubController extends AbstractController
{
    /**
     * /Symfony/Component/HttpFoundation/Response
     * @param Request $request
     * @Route("/club/create", name="create_club")
     */
    public function createClub(Request $request)
    { $club=new Club();
        $form=$this->createForm(ClubType::class,$club);

        $form->add("add",SubmitType::class,['attr'=>[
            'class'=>"btn btn-success mt-2"
        ]]);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($club);
            $em->flush();
            return  $this->redirectToRoute("show_club");
        }
        return  $this->render('club/add.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * /Symfony/Component/HttpFoundation/Response
     * @Route("/club/affiche", name="show_club")
     */
    public function show()
    {
        $repository = $this->getDoctrine()
            ->getRepository(    Club::class);
        $clubs=$repository->findAll();



        return $this->render("club/affiche.html.twig",["clubs"=>$clubs]);
    }

    /**
     * @Route("/club/edit/{id}",name="editClub")
     */
    public function update($id,Request $request,ClubRepository  $repository)
    {
        $club=$repository->find($id);

        $form=$this->createForm(ClubType::class,$club);

        $form->add("update",SubmitType::class,['attr'=>[
            'class'=>"btn btn-success mt-2"
        ]]);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return  $this->redirectToRoute("show_club");

        }
        return  $this->render('club/edit.html.twig',[
            'form'=>$form->createView()
        ]);    }

    /**
     * @Route("/club/delete/{id}",name="deleteClub")
     */
    public function delete($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $club = $entityManager->getRepository(Club::class)->find($id);

        if (!$club) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $entityManager->remove($club);
        $entityManager->flush();

        return $this->redirectToRoute("show_club");
    }
}


