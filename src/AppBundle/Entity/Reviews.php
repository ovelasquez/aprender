<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="lkw_reviews")
 */
class Reviews {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255, nullable=false) 
     */
    private $comment;

    /**
     * @var integer
     *
     * @ORM\Column(name="score", type="integer",  nullable=false) 
     */
    private $score;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="evaluator", type="integer",  nullable=false) 
     */
    private $evaluator;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="evaluated", type="integer",  nullable=false) 
     */
    private $evaluated;
    
    /**
     * @var string
     *
     * @ORM\Column(name="type_evaluated", type="string", length=10, nullable=false) 
     */
    private $type;
    

    public function __construct() {
        
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Reviews
     */
    public function setComment($comment) {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment() {
        return $this->comment;
    }

    /**
     * Set score
     *
     * @param integer $score
     *
     * @return Reviews
     */
    public function setScore($score) {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer
     */
    public function getScore() {
        return $this->score;
    }
    
    
    /**
     * Set evaluator
     *
     * @param integer $evaluator
     *
     * @return Reviews
     */
    public function setEvaluator($evaluator) {
        $this->evaluator = $evaluator;

        return $this;
    }

    /**
     * Get evaluator
     *
     * @return integer
     */
    public function getEvaluator() {
        return $this->evaluator;
    }
    
    
    /**
     * Set evaluated
     *
     * @param integer $evaluated
     *
     * @return Reviews
     */
    public function setEvaluated($evaluated) {
        $this->evaluated = $evaluated;

        return $this;
    }

    /**
     * Get evaluated
     *
     * @return integer
     */
    public function getEvaluated() {
        return $this->evaluated;
    }
    
    /**
     * Set type
     *
     * @param string $type
     *
     * @return Reviews
     */
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     *
     * @return string
     */
    public function __toString() {
        return (string) $this->getId();
    }

}
