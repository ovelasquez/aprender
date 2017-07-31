<?php
// src/AppBundle/Entity/User.php
 
namespace AppBundle\Entity;
 
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity
 * @ORM\Table(name="lkw_user")
 */
class User extends BaseUser
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
     * @ORM\Column(name="last_name", type="string", length=255, nullable=false) 
     */
    protected $lastName;

    /** 
     * @ORM\Column(name="facebook_id", type="string", length=255, nullable=true) 
     */
    protected $facebook_id;
    
    /** 
     * @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true) 
     */
    protected $facebook_access_token;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=true)     
     * @Assert\File(
     *     maxSize = "1024k",
     *     mimeTypes = {"image/jpeg", "image/jpg", "image/png"},
     *     mimeTypesMessage = "Please upload a valid image"
     * )
     * @Assert\Image(
     *     minWidth = 200,
     *     maxWidth = 800,
     *     minHeight = 200,
     *     maxHeight = 800
     * )
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="video", type="string", length=255, nullable=true)
     */
    private $video;

    /**
     * @var string
     *
     * @ORM\Column(name="timezone", type="string", length=255, nullable=true)
     */
    private $timezone;

    
        /**
     * @var boolean
     *
     * @ORM\Column(name="subnews", type="boolean", nullable=true)
     */
    private $subnews = false;    
    
    /**
     * @var \AppBundle\Entity\Coursecategories
     * 
     * @ORM\ManyToMany(targetEntity="Coursecategories")
     * @ORM\JoinTable(name="lkw_user_coursecategories",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="coursecategory_id", referencedColumnName="id")}
     *      )
     */
    private $coursecategories;
    
    
    /**
     * @var \AppBundle\Entity\Courses
     * 
     * @ORM\ManyToMany(targetEntity="Courses")
     * @ORM\JoinTable(name="lkw_user_courses",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="course_id", referencedColumnName="id")}
     *      )
     */
    private $courses;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="province", type="string", length=255, nullable=true)
     */
    private $province;
    

 
    public function __construct()
    {
        parent::__construct();
        
        $this->addRole("ROLE_USUARIO");
        $this->coursecategories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->courses = new \Doctrine\Common\Collections\ArrayCollection();
        
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Contents
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
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Contents
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    
    
    /**
     * Set facebook_id
     *
     * @param string $facebook_id
     *
     * @return Contents
     */
    public function setFacebookId($facebook_id)
    {
        $this->facebook_id = $facebook_id;

        return $this;
    }

    /**
     * Get facebook_id
     *
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebook_id;
    }
    
    /**
     * Set facebook_access_token
     *
     * @param string $facebook_access_token
     *
     * @return Contents
     */
    public function setFacebookAccessToken($facebook_access_token)
    {
        $this->facebook_access_token = $facebook_access_token;

        return $this;
    }

    /**
     * Get facebook_access_token
     *
     * @return string
     */
    public function getFacebookAccessToken()
    {
        return $this->facebook_access_token;
    }
    
    


    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Patients
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set website
     *
     * @param string $website
     *
     * @return User
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }


    /**
     * Set video
     *
     * @param string $video
     *
     * @return User
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return User
     */
    public function setPhoto(File $photo = null)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }
    
    /**
     * Get photo
     *
     * @return string
     */
    public function getNamePhoto()
    {
        return $this->photo->getFilename();
    }

    /**
     * Set timezone
     *
     * @param string $timezone
     *
     * @return User
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Get timezone
     *
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }
    
    /**
     * Set subnews
     *
     * @param boolean $subnews
     *
     * @return User
     */
    public function setSubnews($subnews)
    {
        $this->subnews = $subnews;
        return $this;
    }
    /**
     * Get subnews
     *
     * @return boolean
     */
    public function getSubnews()
    {
        return $this->subnews;
    }
           
    /**
     * Set coursecategories
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $coursecategories
     *
     * @return User
     */
    public function setCoursecategories($coursecategories)
    {
        $this->coursecategories = $coursecategories;

        return $this;
    }

    /**
     * Get coursecategories
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getCoursecategories()
    {
        return $this->coursecategories;
    }
    
    
    /**
     * Set courses
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $courses
     *
     * @return User
     */
    public function setCourses($courses)
    {
        $this->courses = $courses;

        return $this;
    }

    /**
     * Get courses
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getCourses()
    {
        return $this->courses;
    }
    
   
    /**
     * Set country
     *
     * @param string $country
     *
     * @return User
     */
    public function setCountry($country) {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry() {
        return $this->country;
    }

    /**
     * Set province
     *
     * @param string $province
     *
     * @return User
     */
    public function setProvince($province) {
        $this->province = $province;

        return $this;
    }

    /**
     * Get province
     *
     * @return string
     */
    public function getProvince() {
        return $this->province;
    }
    
    
    
    public function getRoles()
    {
        return $this->roles;
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

   
    
    
}