<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PaymentsRepository")
 * @ORM\Table(name="lkw_payments")
 */
class Payments {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="amount", type="integer",  nullable=false) 
     */
    private $amount;
    
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
     * @var \AppBundle\Entity\Courses
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Courses")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     * })
     */
    private $course;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", nullable=true)
     */
    private $status;

    /**
     * @var text
     *
     * @ORM\Column(name="result", type="text", nullable=true)
     */
    private $result;
    
    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", nullable=true)
     */
    private $currency;
    
    /**
     * @var string
     *
     * @ORM\Column(name="pdatetime", type="datetime",  nullable=true)
     */
    private $pdatetime;
    
    public function __construct() {
        
    }


    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return Reviews
     */
    public function setAmount($amount) {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer
     */
    public function getAmount() {
        return $this->amount;
    }
    
    
 /**
     * Set tag
     *
     * @param Courses $course
     *
     * @return Payments
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
     * @return Payments
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
     * @return Payments
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
    
    /**
     * Set result
     *
     * @param string $result
     *
     * @return Payments
     */
    public function setResult($result) {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return string
     */
    public function getResult() {
        return $this->result;
    }
    
    /**
     * Set currency
     *
     * @param string $currency
     *
     * @return Payments
     */
    public function setCurrency($currency) {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency() {
        return $this->currency;
    }
    
    /**
     * Set pdatetime
     *
     * @param \DateTime $pdatetime
     *
     * @return Payments
     */
    public function setPdatetime($pdatetime) {
        $this->pdatetime = $pdatetime;

        return $this;
    }

    /**
     * Get pdatetime
     *
     * @return \DateTime
     */
    public function getPdatetime() {
        return $this->pdatetime;
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
