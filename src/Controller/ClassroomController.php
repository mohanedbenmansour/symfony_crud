<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use App\Repository\ClassroomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class ClassroomController extends AbstractController
{ /**
 * /Symfony/Component/HttpFoundation/Response
 * @param Request $request
 * @Route("/classroom/create", name="create_classroom")
 */
    public function createClassroom(Request $request)
    { $classroom=new Classroom();
        $form=$this->createForm(ClassroomType::class,$classroom);

        $form->add("add",SubmitType::class,['attr'=>[
            'class'=>"btn btn-success mt-2"
        ]]);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($classroom);
            $em->flush();
            return  $this->redirectToRoute("show_classroom");
        }
        return  $this->render('classroom/add.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * /Symfony/Component/HttpFoundation/Response
     * @Route("/classroom/affiche", name="show_classroom")
     */
    public function show()
    {
        $repository = $this->getDoctrine()
            ->getRepository(    Classroom::class);
        $classrooms=$repository->findAll();



        return $this->render("classroom/affiche.html.twig",["classrooms"=>$classrooms]);
    }

    /**
     * @Route("/classroom/edit/{id}",name="editClassroom")
     */
    public function update($id,Request $request,ClassroomRepository  $repository)
    {
        $classroom=$repository->find($id);

        $form=$this->createForm(ClassroomType::class,$classroom);

        $form->add("update",SubmitType::class,['attr'=>[
            'class'=>"btn btn-success mt-2"
        ]]);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return  $this->redirectToRoute("show_classroom");

        }
        return  $this->render('classroom/edit.html.twig',[
            'form'=>$form->createView()
        ]);    }

    /**
     * @Route("/classroom/delete/{id}",name="deleteClassroom")
     */
    public function delete($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $classroom = $entityManager->getRepository(Classroom::class)->find($id);

        if (!$classroom) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $entityManager->remove($classroom);
        $entityManager->flush();

        return $this->redirectToRoute("show_classroom");
    }
}
