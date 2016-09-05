<?php

namespace CoreBundle\Entity;

/**
 * GroupRating
 */
class GroupRating
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $product;

    /**
     * @var int
     */
    private $documentation;


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
     * Set product
     *
     * @param integer $product
     *
     * @return GroupRating
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return int
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set documentation
     *
     * @param integer $documentation
     *
     * @return GroupRating
     */
    public function setDocumentation($documentation)
    {
        $this->documentation = $documentation;

        return $this;
    }

    /**
     * Get documentation
     *
     * @return int
     */
    public function getDocumentation()
    {
        return $this->documentation;
    }
    /**
     * @var \CoreBundle\Entity\ProjectGroup
     */
    private $projectGroup;


    /**
     * Set projectGroup
     *
     * @param \CoreBundle\Entity\ProjectGroup $projectGroup
     *
     * @return GroupRating
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
