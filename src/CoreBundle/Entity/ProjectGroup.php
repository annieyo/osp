<?php

namespace CoreBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ProjectGroup
 */
class ProjectGroup
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \CoreBundle\Entity\GroupRating
     */
    private $groupRating;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $students;

    /**
     * @var \CoreBundle\Entity\ProjectClass
     */
    private $projectClass;

    /**
     * @var \CoreBundle\Entity\Advisor
     */
    private $advisor;

    /**
     * @var \CoreBundle\Entity\Topic
     */
    private $topic;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ProjectGroup
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set groupRating
     *
     * @param \CoreBundle\Entity\GroupRating $groupRating
     *
     * @return ProjectGroup
     */
    public function setGroupRating(GroupRating $groupRating = null)
    {
        $this->groupRating = $groupRating;

        return $this;
    }

    /**
     * Get groupRating
     *
     * @return \CoreBundle\Entity\GroupRating
     */
    public function getGroupRating()
    {
        return $this->groupRating;
    }

    /**
     * Add student
     *
     * @param \CoreBundle\Entity\Student $student
     *
     * @return ProjectGroup
     */
    public function addStudent(Student $student)
    {
        $this->students[] = $student;

        return $this;
    }

    /**
     * Remove student
     *
     * @param \CoreBundle\Entity\Student $student
     */
    public function removeStudent(Student $student)
    {
        $this->students->removeElement($student);
    }

    /**
     * Get students
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStudents()
    {
        return $this->students;
    }

    /**
     * Set projectClass
     *
     * @param \CoreBundle\Entity\ProjectClass $projectClass
     *
     * @return ProjectGroup
     */
    public function setProjectClass(ProjectClass $projectClass = null)
    {
        $this->projectClass = $projectClass;

        return $this;
    }

    /**
     * Get projectClass
     *
     * @return \CoreBundle\Entity\ProjectClass
     */
    public function getProjectClass()
    {
        return $this->projectClass;
    }

    /**
     * Set advisor
     *
     * @param \CoreBundle\Entity\Advisor $advisor
     *
     * @return ProjectGroup
     */
    public function setAdvisor(Advisor $advisor = null)
    {
        $this->advisor = $advisor;

        return $this;
    }

    /**
     * Get advisor
     *
     * @return \CoreBundle\Entity\Advisor
     */
    public function getAdvisor()
    {
        return $this->advisor;
    }

    /**
     * Set topic
     *
     * @param \CoreBundle\Entity\Topic $topic
     *
     * @return ProjectGroup
     */
    public function setTopic(Topic $topic = null)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * Get topic
     *
     * @return \CoreBundle\Entity\Topic
     */
    public function getTopic()
    {
        return $this->topic;
    }
}
