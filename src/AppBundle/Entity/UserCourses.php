<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserCoursesRepository")
 * @ORM\Table(name="lkw_user_courses")
 */
class UserCourses {

    /**
     * @var integer
     * 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \AppBundle\Entity\Courses
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Courses")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     * })
     */
    private $course;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

    public function __construct() {
        
    }

    /**
     * Set tag
     *
     * @param Courses $course
     *
     * @return UserCourses
     */
    public function setCourse($course) {
        $this->course = $course;

        return $this;
    }

    /**
     * Get tag
     *
     * @return Courses
     */
    public function getCourse() {
        return $this->course;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return UserCourses
     */
    public function setUser($user) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return UserCourses
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus() {
        return $this->status;
    }

    public function __toString() {
        return (string) $this->getId();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

}
