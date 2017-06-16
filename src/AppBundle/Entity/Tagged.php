<?php
 
namespace AppBundle\Entity;
 
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="lkw_tagged")
 */
class Tagged 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \AppBundle\Entity\Coursecategories
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tags")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     * })
     */
    private $tag;
    
    /**
     * @var string
     *
     * @ORM\Column(name="class", type="string", length=255, nullable=false) 
     */
    private $class;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id_entity", type="integer", nullable=true)
     */
    private $entity;
        
    
    public function __construct()
    {
                     
    }

    /**
     * Set tag
     *
     * @param string $tag
     *
     * @return Tagged
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }   
    
    /**
     * Set class
     *
     * @param string $class
     *
     * @return Tagged
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }       
    
    /**
     * Set entity
     *
     * @param string $entity
     *
     * @return Tagged
     */
    public function setEntity($entity) {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return string
     */
    public function getEntity() {
        return $this->entity;
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
     * @return string
     */
    public function __toString()
    {
        return (string) $this->tag();
    }
       
    
}