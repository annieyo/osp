<?php

namespace CoreBundle\Entity;

/**
 * Advisor
 */
class Advisor
{
    /**
     * @var int
     */
    private $id;


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
     * Add projectGroup
     *
     * @param \CoreBundle\Entity\ProjectGroup $projectGroup
     *
     * @return Advisor
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
