<?php

namespace CoreBundle\Entity;

/**
 * GroupRating
 */
class GroupRating
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $product;

    /**
     * @var string
     */
    private $documentation;

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
     * Set product
     *
     * @param string $product
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
     * @return string
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set documentation
     *
     * @param string $documentation
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
     * @return string
     */
    public function getDocumentation()
    {
        return $this->documentation;
    }

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

