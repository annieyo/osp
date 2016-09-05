<?php

namespace CoreBundle\Entity;

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
        $this->students = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set groupRating
     *
     * @param \CoreBundle\Entity\GroupRating $groupRating
     *
     * @return ProjectGroup
     */
    public function setGroupRating(\CoreBundle\Entity\GroupRating $groupRating = null)
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
    public function addStudent(\CoreBundle\Entity\Student $student)
    {
        $this->students[] = $student;

        return $this;
    }

    /**
     * Remove student
     *
     * @param \CoreBundle\Entity\Student $student
     */
    public function removeStudent(\CoreBundle\Entity\Student $student)
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
    public function setProjectClass(\CoreBundle\Entity\ProjectClass $projectClass = null)
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
    public function setAdvisor(\CoreBundle\Entity\Advisor $advisor = null)
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
    public function setTopic(\CoreBundle\Entity\Topic $topic = null)
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
