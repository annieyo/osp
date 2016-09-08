<?php

namespace CoreBundle\Entity;

/**
 * Topic
 */
class Topic
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $projectGroup;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->projectGroup = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return Topic
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
     * Add projectGroup
     *
     * @param \CoreBundle\Entity\ProjectGroup $projectGroup
     *
     * @return Topic
     */
    public function addProjectGroup(\CoreBundle\Entity\ProjectGroup $projectGroup)
    {
        $this->projectGroup[] = $projectGroup;

        return $this;
    }

    /**
     * Remove projectGroup
     *
     * @param \CoreBundle\Entity\ProjectGroup $projectGroup
     */
    public function removeProjectGroup(\CoreBundle\Entity\ProjectGroup $projectGroup)
    {
        $this->projectGroup->removeElement($projectGroup);
    }

    /**
     * Get projectGroup
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjectGroup()
    {
        return $this->projectGroup;
    }
}

