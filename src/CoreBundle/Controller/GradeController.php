<?php

namespace CoreBundle\Controller;

use CoreBundle\Entity\GroupRating;
use CoreBundle\Entity\ProjectGroup;
use CoreBundle\Entity\SingleRating;
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
        $session = $request->getSession();

        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);

        $group = new ProjectGroup();
        $groupForm = $this->createForm(GroupType::class, $group);
        $groupSelectForm = $this->createForm(GroupSelectType::class, $group);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();



            if ($request->request->get('group_exists')) {

            } else {


                $studentData = $request->request->get('student');
                $groupData = $request->request->get('group');

                $group->setName($groupData['name']);

                $advisor = $this->getDoctrine()->getRepository('CoreBundle:Advisor')->find($groupData['advisor']);
                $topic = $this->getDoctrine()->getRepository('CoreBundle:Topic')->find($groupData['topic']);
                $projectClass = $this->getDoctrine()->getRepository('CoreBundle:ProjectClass')->find($groupData['projectClass']);

                $group->setAdvisor($advisor);
                $group->setTopic($topic);
                $group->setProjectClass($projectClass);


                $groupRating = new GroupRating();
                $groupRating->setDocumentation($groupData['documentation']);
                $groupRating->setProduct($groupData['product']);
                $groupRating->setProjectGroup($group);
                $group->setGroupRating($groupRating);

                $singleRating = new SingleRating();
                $singleRating->setStudent($student);
                $singleRating->setDiscussion($studentData['discussion']);
                $singleRating->setPresentation($studentData['presentation']);
                $singleRating->setTotalGso($studentData['totalGso']);
                $singleRating->setTotalIhk($studentData['totalIhk']);



                $student->setProjectGroup($group);
                $student->setSingleRating($singleRating);

                $em->persist($group);
                $em->persist($student);
            }

            $em->flush();

            $session->getFlashBag()->add(
                'success',
                'Die Noten wurden erfolgreich eingetragen!'
            );

            return $this->redirect($this->generateUrl(
                'grade_new'
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
