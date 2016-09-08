<?php

namespace CoreBundle\Controller;

use CoreBundle\Entity\GroupRating;
use CoreBundle\Entity\ProjectClass;
use CoreBundle\Entity\ProjectGroup;
use CoreBundle\Entity\Topic;
use CoreBundle\Entity\Advisor;
use CoreBundle\Entity\SingleRating;
use CoreBundle\Entity\Student;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ImportController extends Controller
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        if (sizeof($request->files)) {

            $session = $request->getSession();

            $data = $this->importExcel($request);

            if(!is_array($data)) {
                $session->getFlashBag()->add(
                    'danger',
                    $data
                );
                return $this->render('CoreBundle:Grade:import.html.twig');
            }

            $this->saveData($data);

            $session->getFlashBag()->add(
                'success',
                'Daten wurden hinzugefügt'
            );

        }
        return $this->render('CoreBundle:Grade:import.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function importExcel($request)
    {

        $directory = $this->get('kernel')->getRootDir() . '/../web/uploads/';

        foreach ($request->files as $uploadedFile) {
            $name = $uploadedFile->getClientOriginalName();
            $file = $uploadedFile->move($directory, $name);
        }

        try {
            $inputFileType = \PHPExcel_IOFactory::identify($file);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($file);
        } catch (\Exception $e) {
            $error = 'Error loading file "' . pathinfo($file, PATHINFO_BASENAME) . '": ' . $e->getMessage();

            return $error;
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

        for ($i = 8; $i <= 13; $i++) {

            $studentName = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getFormattedValue();

            if ($studentName) {

                $student = [];
                $student['name'] = $studentName;

                $student['presentation'] = self::getGradeFromPointValue($objPHPExcel->getActiveSheet()->getCell('F' . $i)->getOldCalculatedValue());
                $student['discussion'] = self::getGradeFromPointValue($objPHPExcel->getActiveSheet()->getCell('G' . $i)->getOldCalculatedValue());

                $student['total_ihk'] = self::getGradeFromPointValue($objPHPExcel->getActiveSheet()->getCell('I' . $i)->getOldCalculatedValue());
                $student['total_gso'] = self::getGradeFromPointValue($objPHPExcel->getActiveSheet()->getCell('J' . $i)->getOldCalculatedValue());

                $sheetData['students'][] = $student;
            }
        }

        return $sheetData;
    }

    private function getProjectClassByName($name) {

        $projectClass = $this->getDoctrine()
            ->getManager()
            ->getRepository('CoreBundle:ProjectClass')
            ->findOneBy(array('name' => $name));

        if(is_null($projectClass)) {
            $projectClass = new ProjectClass();
            $projectClass->setName($name);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($projectClass);
        $em->flush();

        return $projectClass;
    }

    private function getAdvisorByName($name) {

        $advisor = $this->getDoctrine()
            ->getManager()
            ->getRepository('CoreBundle:Advisor')
            ->findOneBy(array('name' => $name));

        if(is_null($advisor)) {
            $advisor = new Advisor();
            $advisor->setName($name);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($advisor);
        $em->flush();

        return $advisor;
    }

    private function getTopicByName($name) {

        $topic = $this->getDoctrine()
            ->getManager()
            ->getRepository('CoreBundle:Topic')
            ->findOneBy(array('name' => $name));

        if(is_null($topic)) {
            $topic = new Topic();
            $topic->setName($name);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($topic);
        $em->flush();

        return $topic;
    }

    private function saveData($data) {

        $em = $this->getDoctrine()->getManager();

        $projectClass = $this->getProjectClassByName($data['projectClass']);
        $advisor = $this->getAdvisorByName($data['advisor']);
        $topic = $this->getTopicByName($data['topic']);

        $group = new ProjectGroup();
        $group->setAdvisor($advisor);
        $group->setTopic($topic);
        $group->setProjectClass($projectClass);
        $group->setName($data['groupName']);

        $groupRating = new GroupRating();
        $groupRating->setDocumentation($data['documentation']);
        $groupRating->setProduct($data['product']);
        $groupRating->setProjectGroup($group);

        $group->setGroupRating($groupRating);

        $em->persist($group);
        $em->flush();

        foreach ($data['students'] as $studentData) {

            $student = new Student();
            $student->setName($studentData['name']);

            $singleRating = new SingleRating();
            $singleRating->setStudent($student);
            $singleRating->setDiscussion($studentData['discussion']);
            $singleRating->setPresentation($studentData['presentation']);
            $singleRating->setTotalGso($studentData['total_gso']);
            $singleRating->setTotalIhk($studentData['total_ihk']);

            $student->setProjectGroup($group);
            $student->setSingleRating($singleRating);

            $em->persist($student);
            $em->flush();
        }

    }


    private function getGradeFromPointValue($points)
    {

        $a = false;

        switch ($points) {
            case ($points < 10):
                $a = "6-";
                break;

            case ($points < 25):
                $a = "6";
                break;

            case ($points < 30):
                $a = "6+";
                break;

            case ($points < 36):
                $a = "5-";
                break;

            case ($points < 43):
                $a = "5";
                break;

            case ($points < 50):
                $a = "5+";
                break;

            case ($points < 56):
                $a = "4-";
                break;

            case ($points < 62):
                $a = "4";
                break;

            case ($points < 67):
                $a = "4+";
                break;

            case ($points < 72):
                $a = "3-";
                break;

            case ($points < 77):
                $a = "3";
                break;

            case ($points < 81):
                $a = "3+";
                break;

            case ($points < 85):
                $a = "2-";
                break;

            case ($points < 89):
                $a = "2";
                break;

            case ($points < 92):
                $a = "2+";
                break;

            case ($points < 95):
                $a = "1-";
                break;

            case ($points < 96):
                $a = "1";
                break;

            case ($points <= 100):
                $a = "1+";
                break;
        }

        return $a;
    }

}
