<?php
 
namespace AppBundle\Entity;
 
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="lkw_coursecategories")
 */
class Coursecategories 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false) 
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="tag", type="string", length=255, nullable=false) 
     */
    private $tag;
    
    
    public function __construct()
    {
             
        
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Coursecategories
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
     * Set tag
     *
     * @param string $tag
     *
     * @return Coursecategories
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

   
    /**
     *
     * @return string
     */
   
     public function __toString() {
        return (string) $this->getName();
    }
    
    
}