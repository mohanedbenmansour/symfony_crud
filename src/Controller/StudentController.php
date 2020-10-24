<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{

    /**
     * /Symfony/Component/HttpFoundation/Response
     * @param Request $request
     * @Route("/student/create", name="create_student")
     */
    public function createStudent(Request $request)
    { $student=new Student();
        $form=$this->createForm(StudentType::class,$student);

$form->add("add",SubmitType::class,['attr'=>[
    'class'=>"btn btn-success mt-2"
    ]]);
        $form->handleRequest($request);
if($form->isSubmitted()&& $form->isValid()){
$em=$this->getDoctrine()->getManager();
$em->persist($student);
$em->flush();
return  $this->redirectToRoute("show_student");
}
return  $this->render('student/add.html.twig',[
    'form'=>$form->createView()
]);
    }
    /**
     * /Symfony/Component/HttpFoundation/Response
     * @Route("/student/affiche", name="show_student")
     */
    public function show()
    {
        $repository = $this->getDoctrine()
            ->getRepository(    Student::class);
        $students=$repository->findAll();



        return $this->render("student/affiche.html.twig",["students"=>$students]);
    }
    /**
     * @Route("/student/edit/{id}",name="edit")
     */
    public function update($id,StudentRepository $repository,Request $request)
    {
        $student=$repository->find($id);

        $form=$this->createForm(StudentType::class,$student);

        $form->add("update",SubmitType::class,['attr'=>[
            'class'=>"btn btn-success mt-2"
        ]]);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return  $this->redirectToRoute("show_student");

    }
        return  $this->render('student/edit.html.twig',[
            'form'=>$form->createView()
        ]);    }

    /**
     * @Route("/student/delete/{id}",name="delete")
     */
    public function delete($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $student = $entityManager->getRepository(Student::class)->find($id);

        if (!$student) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $entityManager->remove($student);
        $entityManager->flush();

        return $this->redirectToRoute("show_student");
    }
}
