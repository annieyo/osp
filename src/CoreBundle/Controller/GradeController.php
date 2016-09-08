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
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class GradeController extends Controller
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function importAction(Request $request)
    {

        if(sizeof($request->files)) {

            $directory = $this->get('kernel')->getRootDir() . '/../web/uploads/';

            foreach ($request->files as $uploadedFile) {
                $name = $uploadedFile->getClientOriginalName();
                $file = $uploadedFile->move($directory, $name);
            }

            try {
                $inputFileType = \PHPExcel_IOFactory::identify($file);
                $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($file);
            } catch(\Exception $e) {
                die('Error loading file "'.pathinfo($file,PATHINFO_BASENAME).'": '.$e->getMessage());
            }

            $sheetData = [];

            $objPHPExcel->setActiveSheetIndex(0);

            $sheetData['projectClass'] = $objPHPExcel->getActiveSheet()->getCell('B5')->getValue();
            $sheetData['advisor'] = $objPHPExcel->getActiveSheet()->getCell('D7')->getValue();
            $sheetData['topic'] = $objPHPExcel->getActiveSheet()->getCell('D5')->getValue();
            $sheetData['groupName'] = $sheetData['projectClass'] . ' ' . $sheetData['topic'];

            $objPHPExcel->setActiveSheetIndex(13);

            $sheetData['documentation'] = self::getGradeFromPointValue($objPHPExcel->getActiveSheet()->getCell('B' . 8)->getOldCalculatedValue());
            $sheetData['product'] = self::getGradeFromPointValue($objPHPExcel->getActiveSheet()->getCell('C' . 8)->getFormattedValue());

            for($i = 8; $i <= 13; $i++) {

                $studentName = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getFormattedValue();

                if($studentName) {

                    $student = [];
                    $student['name'] = $studentName;

                    $student['presentation'] = self::getGradeFromPointValue($objPHPExcel->getActiveSheet()->getCell('F' . $i)->getOldCalculatedValue());
                    $student['discussion'] = self::getGradeFromPointValue($objPHPExcel->getActiveSheet()->getCell('G' . $i)->getOldCalculatedValue());

                    $student['total_ihk'] = self::getGradeFromPointValue($objPHPExcel->getActiveSheet()->getCell('I' . $i)->getOldCalculatedValue());
                    $student['total_gso'] = self::getGradeFromPointValue($objPHPExcel->getActiveSheet()->getCell('J' . $i)->getOldCalculatedValue());

                    $sheetData['students'][] = $student;
                }
            }
        }

        return $this->render('CoreBundle:Grade:import.html.twig');
    }


    private function getGradeFromPointValue($points) {

        $a = false;

        switch($points) {
            case ($points< 10):
                $a = "6-";
                break;

            case ($points< 25):
                $a = "6";
                break;

            case ($points< 30):
                $a = "6+";
                break;

            case ($points< 36):
                $a = "5-";
                break;

            case ($points< 43):
                $a = "5";
                break;

            case ($points< 50):
                $a = "5+";
                break;

            case ($points< 56):
                $a = "4-";
                break;

            case ($points< 62):
                $a = "4";
                break;

            case ($points< 67):
                $a = "4+";
                break;

            case ($points< 72):
                $a = "3-";
                break;

            case ($points< 77):
                $a = "3";
                break;

            case ($points< 81):
                $a = "3+";
                break;

            case ($points< 85):
                $a = "2-";
                break;

            case ($points< 89):
                $a = "2";
                break;

            case ($points< 92):
                $a = "2+";
                break;

            case ($points< 95):
                $a = "1-";
                break;

            case ($points< 96):
                $a = "1";
                break;

            case ($points<= 100):
                $a = "1+";
                break;
        }

        return $a;
    }


    /**
     * Creates a new student, adds his grades and (depending on the 'group_existing'
     * choice field) creates or adds a group
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $session = $request->getSession();

        // create student, group and group selector form
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $group = new ProjectGroup();
        $groupForm = $this->createForm(GroupType::class, $group);
        $groupSelectForm = $this->createForm(GroupSelectType::class, $group);

        $form->handleRequest($request);
        $groupForm->handleRequest($request);
        $groupSelectForm->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && ($groupForm->isValid()||$groupSelectForm->isValid())) {
            $em = $this->getDoctrine()->getManager();

            $studentData = $request->request->get('student');

            $singleRating = new SingleRating();
            $singleRating->setStudent($student);
            $singleRating->setDiscussion($studentData['discussion']);
            $singleRating->setPresentation($studentData['presentation']);
            $singleRating->setTotalGso($studentData['totalGso']);
            $singleRating->setTotalIhk($studentData['totalIhk']);

            // check if user chose an existing group or wanted to create a new one
            if (!$request->request->get('student')['group_exists']) {
                // existing group

                $selectedGroupId = $request->request->get('group_select')['selectedGroup'];
                $selectedGroup = $this->getDoctrine()->getRepository('CoreBundle:ProjectGroup')->find($selectedGroupId);

                $student->setProjectGroup($selectedGroup);
            } else {
                // new group
                $groupData = $request->request->get('group');
                $group->setName($groupData['name']);

                // get objects from ids
                $advisor = $this->getDoctrine()->getRepository('CoreBundle:Advisor')->find($groupData['advisor']);
                $topic = $this->getDoctrine()->getRepository('CoreBundle:Topic')->find($groupData['topic']);
                $projectClass = $this->getDoctrine()->getRepository('CoreBundle:ProjectClass')->find($groupData['projectClass']);

                // set data manually for unmapped fields
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
     * Updates student and grade data
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        $session = $request->getSession();

        // get student object by id provided as url parameter
        $student = $this->getDoctrine()
            ->getManager()
            ->getRepository('CoreBundle:Student')
            ->findOneBy(array('id' => $id));

        // create student, group and group selector form
        $form = $this->createForm(StudentType::class, $student);
        $groupForm = $this->createForm(GroupType::class, new ProjectGroup());
        $groupSelectForm = $this->createForm(GroupSelectType::class, $student->getProjectGroup());

        //setting data manually for unmapped form fields
        $singleRating = $student->getSingleRating();
        $form->get('discussion')->setData($singleRating->getDiscussion());
        $form->get('presentation')->setData($singleRating->getPresentation());
        $form->get('totalGso')->setData($singleRating->getTotalGso());
        $form->get('totalIhk')->setData($singleRating->getTotalIhk());
        $groupSelectForm->get('selectedGroup')->setData($student->getProjectGroup());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $studentData = $request->request->get('student');

            // delete old singleRating (because there can be only one entry with the student id)
            $em->remove($singleRating);
            $em->flush();
            $singleRating = new SingleRating();
            $singleRating->setStudent($student);
            $singleRating->setDiscussion($studentData['discussion']);
            $singleRating->setPresentation($studentData['presentation']);
            $singleRating->setTotalGso($studentData['totalGso']);
            $singleRating->setTotalIhk($studentData['totalIhk']);

            // check if user chose an existing group or wanted to create a new one
            if (!$request->request->get('student')['group_exists']) {
                // existing group

                $selectedGroupId = $request->request->get('group_select')['selectedGroup'];
                $selectedGroup = $this->getDoctrine()->getRepository('CoreBundle:ProjectGroup')->find($selectedGroupId);

                $student->setProjectGroup($selectedGroup);
            } else {
                // new group

                $group = new ProjectGroup();
                $groupData = $request->request->get('group');
                $group->setName($groupData['name']);

                // get objects from ids
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
                'Die Änderungen wurden erfolgreich gespeichert!'
            );

            return $this->redirect($this->generateUrl(
                'student_detail', array('id' => $student->getId())
            ));

        }

        return $this->render(
            'CoreBundle:Grade:edit.html.twig',
            array(
                'form' => $form->createView(),
                'groupForm' => $groupForm->createView(),
                'groupSelectForm' => $groupSelectForm->createView(),
            )
        );
    }

    /**
     * Searches for students based on advisor, topic or name and either displays a table of all results
     * or displays the student detail page when there's only one result
     *
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
                    'total' => sizeof($results),
                    'results' => $results
                )
            );
        }

        return $this->render(
            'CoreBundle:Grade:search.html.twig',
            array(
                'form' => $form->createView(),
                'total' => false,
            )
        );
    }

    /**
     * Shows the detail page of a student an his grades
     *
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
     * deletes a student and his grades
     *
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

    public function editGroupAction(Request $request, $id)
    {
        $session = $request->getSession();

        // get student object by id provided as url parameter
        $group = $this->getDoctrine()
            ->getManager()
            ->getRepository('CoreBundle:ProjectGroup')
            ->findOneBy(array('id' => $id));

        $form = $this->createForm(GroupType::class, $group);

        $form->get('product')->setData($group->getGroupRating()->getProduct());
        $form->get('documentation')->setData($group->getGroupRating()->getDocumentation());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $group = $form->getData();

            $em->remove($group->getGroupRating());
            $em->flush();

            $groupRating = new GroupRating();
            $groupRating->setDocumentation($request->request->get('group')['documentation']);
            $groupRating->setProduct($request->request->get('group')['product']);
            $groupRating->setProjectGroup($group);
            $group->setGroupRating($groupRating);

            $em->persist($group);
            $em->flush();

            $session->getFlashBag()->add(
                'success',
                'Die Änderungen wurden erfolgreich gespeichert!'
            );

        }

        return $this->render(
            'CoreBundle:Group:edit.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }
}
