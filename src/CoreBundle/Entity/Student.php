<?php

namespace CoreBundle\Entity;

/**
 * Student
 */
class Student
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \CoreBundle\Entity\SingleRating
     */
    private $singleRating;

    /**
     * @var \CoreBundle\Entity\ProjectGroup
     */
    private $projectGroup;


    /**
     * Get id
     *
     * @return integer
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
     * @return Student
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
     * Set singleRating
     *
     * @param \CoreBundle\Entity\SingleRating $singleRating
     *
     * @return Student
     */
    public function setSingleRating(\CoreBundle\Entity\SingleRating $singleRating = null)
    {
        $this->singleRating = $singleRating;

        return $this;
    }

    /**
     * Get singleRating
     *
     * @return \CoreBundle\Entity\SingleRating
     */
    public function getSingleRating()
    {
        return $this->singleRating;
    }

    /**
     * Set projectGroup
     *
     * @param \CoreBundle\Entity\ProjectGroup $projectGroup
     *
     * @return Student
     */
    public function setProjectGroup(\CoreBundle\Entity\ProjectGroup $projectGroup = null)
    {
        $this->projectGroup = $projectGroup;

        return $this;
    }

    /**
     * Get projectGroup
     *
     * @return \CoreBundle\Entity\ProjectGroup
     */
    public function getProjectGroup()
    {
        return $this->projectGroup;
    }
}

