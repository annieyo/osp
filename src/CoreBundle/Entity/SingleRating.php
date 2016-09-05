<?php

namespace CoreBundle\Entity;

/**
 * SingleRating
 */
class SingleRating
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $discussion;

    /**
     * @var int
     */
    private $presentation;

    /**
     * @var int
     */
    private $totalIhk;


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
     * Set discussion
     *
     * @param integer $discussion
     *
     * @return SingleRating
     */
    public function setDiscussion($discussion)
    {
        $this->discussion = $discussion;

        return $this;
    }

    /**
     * Get discussion
     *
     * @return int
     */
    public function getDiscussion()
    {
        return $this->discussion;
    }

    /**
     * Set presentation
     *
     * @param integer $presentation
     *
     * @return SingleRating
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * Get presentation
     *
     * @return int
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * Set totalIhk
     *
     * @param integer $totalIhk
     *
     * @return SingleRating
     */
    public function setTotalIhk($totalIhk)
    {
        $this->totalIhk = $totalIhk;

        return $this;
    }

    /**
     * Get totalIhk
     *
     * @return int
     */
    public function getTotalIhk()
    {
        return $this->totalIhk;
    }
    /**
     * @var integer
     */
    private $totalGso;

    /**
     * @var \CoreBundle\Entity\Student
     */
    private $student;


    /**
     * Set totalGso
     *
     * @param integer $totalGso
     *
     * @return SingleRating
     */
    public function setTotalGso($totalGso)
    {
        $this->totalGso = $totalGso;

        return $this;
    }

    /**
     * Get totalGso
     *
     * @return integer
     */
    public function getTotalGso()
    {
        return $this->totalGso;
    }

    /**
     * Set student
     *
     * @param \CoreBundle\Entity\Student $student
     *
     * @return SingleRating
     */
    public function setStudent(\CoreBundle\Entity\Student $student = null)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student
     *
     * @return \CoreBundle\Entity\Student
     */
    public function getStudent()
    {
        return $this->student;
    }
}
