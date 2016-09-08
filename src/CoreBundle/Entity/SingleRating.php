<?php

namespace CoreBundle\Entity;

/**
 * SingleRating
 */
class SingleRating
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $discussion;

    /**
     * @var string
     */
    private $presentation;

    /**
     * @var string
     */
    private $totalIhk;

    /**
     * @var string
     */
    private $totalGso;

    /**
     * @var \CoreBundle\Entity\Student
     */
    private $student;


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
     * Set discussion
     *
     * @param string $discussion
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
     * @return string
     */
    public function getDiscussion()
    {
        return $this->discussion;
    }

    /**
     * Set presentation
     *
     * @param string $presentation
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
     * @return string
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * Set totalIhk
     *
     * @param string $totalIhk
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
     * @return string
     */
    public function getTotalIhk()
    {
        return $this->totalIhk;
    }

    /**
     * Set totalGso
     *
     * @param string $totalGso
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
     * @return string
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

