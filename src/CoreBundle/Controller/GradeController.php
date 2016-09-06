<?php

namespace CoreBundle\Controller;

use CoreBundle\Entity\ProjectGroup;
use CoreBundle\Entity\Student;
use CoreBundle\Form\GroupSelectType;
use CoreBundle\Form\GroupType;
use CoreBundle\Form\StudentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GradeController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('CoreBundle:Default:index.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);

        $group = new ProjectGroup();
        $groupForm = $this->createForm(GroupType::class, $group);
        $groupSelectForm = $this->createForm(GroupSelectType::class, $group);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $group->
            $student->setProjectGroup($group);

            var_dump($student);
            var_dump($group);
            die();

            $em->persist($student);
            $em->flush();

            return $this->redirect($this->generateUrl(
                'grade_search'
            ));
        }

        return $this->render(
            'CoreBundle:Grade:new.html.twig',
            array(
                'form' => $form->createView(),
                'groupForm' => $groupForm->createView(),
                'groupSelectForm' => $groupSelectForm->createView(),
            )
        );
    }

    /**
     * @param $id
     */
    public function detailAction($id)
    {
        echo $id; exit;
    }
}
