<?php

namespace CoreBundle\Controller;

use CoreBundle\Entity\GroupRating;
use CoreBundle\Entity\ProjectGroup;
use CoreBundle\Entity\SingleRating;
use CoreBundle\Entity\Student;
use CoreBundle\Form\FilterType;
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

            $studentData = $request->request->get('student');

            $singleRating = new SingleRating();
            $singleRating->setStudent($student);
            $singleRating->setDiscussion($studentData['discussion']);
            $singleRating->setPresentation($studentData['presentation']);
            $singleRating->setTotalGso($studentData['totalGso']);
            $singleRating->setTotalIhk($studentData['totalIhk']);

            if($request->request->get('student')['group_exists'] == 0 && $request->request->get('group')['name'] == "") {

                $session->getFlashBag()->add(
                    'warning',
                    'Noten nicht gespeichert. Bitte Gruppe wählen'
                );

                return $this->redirect($this->generateUrl(
                    'grade_new'
                ));
            }

            if (!$request->request->get('student')['group_exists']) {
                // group exists

                $selectedGroupId = $request->request->get('group_select')['selectedGroup'];
                $selectedGroup = $this->getDoctrine()->getRepository('CoreBundle:ProjectGroup')->find($selectedGroupId);

                $student->setProjectGroup($selectedGroup);
            } else {
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

                $student->setProjectGroup($group);

                $em->persist($group);
            }

            $student->setSingleRating($singleRating);

            $em->persist($student);
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
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function searchAction(Request $request)
    {
        $session = $request->getSession();
        $group = new ProjectGroup();
        $form = $this->createForm(FilterType::class, $group);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $studentRepository = $em->getRepository('CoreBundle:Student');

            $searchTerms = explode(' ', $request->request->get('filter')['name']);
            $advisor = $request->request->get('filter')['advisor'];
            $topic = $request->request->get('filter')['topic'];

            $results = $studentRepository->getSearchResult($searchTerms, $advisor, $topic);

            if (count($results) == 1) {
                return $this->redirectToRoute('student_detail', array('id' => $results[0]->getId()));
            }

            if (count($results) == 0) {
                $session->getFlashBag()->add(
                    'danger',
                    'Es wurden keine Einträge gefunden'
                );

                return $this->render(
                    'CoreBundle:Grade:search.html.twig',
                    array(
                        'form' => $form->createView()
                    )
                );
            }

            return $this->render(
                'CoreBundle:Grade:search.html.twig',
                array(
                    'form' => $form->createView(),
                    'results' => $results
                )
            );
        }

        return $this->render(
            'CoreBundle:Grade:search.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detailAction($id)
    {
        $student = $this->getDoctrine()
            ->getManager()
            ->getRepository('CoreBundle:Student')
            ->findOneBy(array('id' => $id));

        return $this->render(
            'CoreBundle:Grade:detail.html.twig',
            array(
                'student' => $student
            )
        );
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();

        $student = $this->getDoctrine()
            ->getManager()
            ->getRepository('CoreBundle:Student')
            ->findOneBy(array('id' => $id));

        if ($student) {
            $em->remove($student);
            $em->flush();

            $session->getFlashBag()->add(
                'success',
                'Der Schüler wurde erfolgreich gelöscht'
            );
        }

        return $this->redirectToRoute('grade_search');
    }
}
