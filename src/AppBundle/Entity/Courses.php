<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CoursesRepository")
 * @ORM\Table(name="lkw_courses")
 */
class Courses {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
     * @var \AppBundle\Entity\Coursecategories
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Coursecategories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     * 
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false) 
     */
    private $title;

    /**
     * @ORM\Column(name="description", type="string", nullable=false) 
     */
    protected $description;

    /**
     * @ORM\Column(name="resume", type="string", nullable=false) 
     */
    protected $resume;

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
     *     maxHeight = 800,
     *     allowLandscape = true,
     *     allowPortrait = true
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
     * @var integer
     *
     * @ORM\Column(name="place", type="integer", nullable=true)
     */
    private $place;

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

    /**
     * @var string
     *
     * @ORM\Column(name="avenue", type="string", length=255, nullable=true)
     */
    private $avenue;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="knowledge", type="string", nullable=true)
     */
    private $knowledge;

    /**
     * @var string
     *
     * @ORM\Column(name="tool", type="string", nullable=true)
     */
    private $tool;

    /**
     * @var integer
     *
     * @ORM\Column(name="minstudent", type="integer", nullable=true)
     */
    private $minstudent;

    /**
     * @var integer
     *
     * @ORM\Column(name="maxstudent", type="integer", nullable=true)
     */
    private $maxstudent;

    /**
     * @var string
     *
     * @ORM\Column(name="star_date", type="datetime",  nullable=true)
     */
    private $startdate;

    /**
     * @var string
     *
     * @ORM\Column(name="end_date", type="datetime", nullable=true)
     */
    private $enddate;

    /**
     * @var string
     *
     * @ORM\Column(name="hour", type="string", length=255, nullable=true)
     */
    private $hour;

    /**
     * @var string
     *
     * @ORM\Column(name="days", type="string", length=255, nullable=true)
     */
    private $days;

    /**
     * @var \AppBundle\Entity\Currency
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Currency")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="currency_id", referencedColumnName="id")
     * })
     * 
     */
    private $currency;

    /**
     * @var \AppBundle\Entity\Coursecosts
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Coursecosts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cost_id", referencedColumnName="id")
     * })
     */
    private $cost;

    /**
     * @var \AppBundle\Entity\Typespublications
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Typespublications")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * })
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

    /**
     * @var \AppBundle\Entity\User
     * 
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="lkw_user_courses",
     *      joinColumns={@ORM\JoinColumn(name="course_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     *      )
     */
    private $users;
    private $review;
    private $byEvaluation;

    public function __construct() {
        $this->users = new ArrayCollection();
        $this->review = 0;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Coursecategories $category
     *
     * @return Courses
     */
    public function setCategory(\AppBundle\Entity\Coursecategories $category = null) {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Coursecategories
     */
    public function getCategory() {
        return $this->category;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\Coursecategories $user
     *
     * @return Courses
     */
    public function setUser(\AppBundle\Entity\User $user = null) {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Courses
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Courses
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set resume
     *
     * @param string $resume
     *
     * @return Courses
     */
    public function setResume($resume) {
        $this->resume = $resume;

        return $this;
    }

    /**
     * Get resume
     *
     * @return string
     */
    public function getResume() {
        return $this->resume;
    }

    /**
     * Set video
     *
     * @param string $video
     *
     * @return User
     */
    public function setVideo($video) {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return string
     */
    public function getVideo() {
        return $this->video;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return User
     */
    public function setPhoto($photo) {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto() {
        return $this->photo;
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

    /**
     * Set place
     *
     * @param string $place
     *
     * @return User
     */
    public function setPlace($place) {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return string
     */
    public function getPlace() {
        return $this->place;
    }

    /**
     * Set avenue
     *
     * @param string $avenue
     *
     * @return User
     */
    public function setAvenue($avenue) {
        $this->avenue = $avenue;

        return $this;
    }

    /**
     * Get avenue
     *
     * @return string
     */
    public function getAvenue() {
        return $this->avenue;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return User
     */
    public function setAddress($address) {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * Set minstudent
     *
     * @param string $minstudent
     *
     * @return User
     */
    public function setMinstudent($minstudent) {
        $this->minstudent = $minstudent;

        return $this;
    }

    /**
     * Get minstudent
     *
     * @return string
     */
    public function getMinstudent() {
        return $this->minstudent;
    }

    /**
     * Set maxstudent
     *
     * @param string $maxstudent
     *
     * @return User
     */
    public function setMaxstudent($maxstudent) {
        $this->maxstudent = $maxstudent;

        return $this;
    }

    /**
     * Get maxstudent
     *
     * @return string
     */
    public function getMaxstudent() {
        return $this->maxstudent;
    }

    /**
     * Set startdate
     *
     * @param \DateTime $startdate
     *
     * @return User
     */
    public function setStartdate($startdate) {
        $this->startdate = $startdate;

        return $this;
    }

    /**
     * Get startdate
     *
     * @return \DateTime
     */
    public function getStartdate() {
        return $this->startdate;
    }

    /**
     * Set enddate
     *
     * @param \DateTime $enddate
     *
     * @return User
     */
    public function setEnddate($enddate) {
        $this->enddate = $enddate;

        return $this;
    }

    /**
     * Get enddate
     *
     * @return \DateTime
     */
    public function getEnddate() {
        return $this->enddate;
    }

    /**
     * Set hour
     *
     * @param string $hour
     *
     * @return User
     */
    public function setHour($hour) {
        $this->hour = $hour;

        return $this;
    }

    /**
     * Get hour
     *
     * @return string
     */
    public function getHour() {
        return $this->hour;
    }

    /**
     * Set days
     *
     * @param string $days
     *
     * @return User
     */
    public function setDays($days) {
        $this->days = $days;

        return $this;
    }

    /**
     * Get days
     *
     * @return string
     */
    public function getDays() {
        return $this->days;
    }

    /**
     * Set cost
     *
     * @param \AppBundle\Entity\Coursecosts $cost
     *
     * @return Courses
     */
    public function setCost(\AppBundle\Entity\Coursecosts $cost = null) {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return \AppBundle\Entity\Coursecategories
     */
    public function getCost() {
        return $this->cost;
    }

    /**
     * Set type
     *
     * @param \AppBundle\Entity\Coursecategories $type
     *
     * @return Courses
     */
    public function setType(\AppBundle\Entity\Typespublications $type = null) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \AppBundle\Entity\Typespublications
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
     * Set knowledge
     *
     * @param string $knowledge
     *
     * @return Courses
     */
    public function setKnowledge($knowledge) {
        $this->knowledge = $knowledge;

        return $this;
    }

    /**
     * Get knowledge
     *
     * @return string
     */
    public function getKnowledge() {
        return $this->knowledge;
    }

    /**
     * Set tool
     *
     * @param string $tool
     *
     * @return Courses
     */
    public function setTool($tool) {
        $this->tool = $tool;

        return $this;
    }

    /**
     * Get tool
     *
     * @return string
     */
    public function getTool() {
        return $this->tool;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return User
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
     * Set users
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $users
     *
     * @return User
     */
    public function setUsers($users) {
        $this->users = $users;

        return $this;
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getUsers() {
        return $this->users;
    }

    /**
     * Set review
     *
     * @param integer $review
     *
     * @return User
     */
    public function setReview($review) {
        $this->review = $review;

        return $this;
    }

    /**
     * Get review
     *
     * @return integer
     */
    public function getReview() {
        return $this->review;
    }

    /**
     * Set byEvaluation
     *
     * @param integer $byEvaluation
     *
     * @return User
     */
    public function setByEvaluation($byEvaluation) {
        $this->byEvaluation = $byEvaluation;

        return $this;
    }

    /**
     * Get byEvaluation
     *
     * @return integer
     */
    public function getByEvaluation() {
        return $this->byEvaluation;
    }

    public function isCompleted() {

        return (boolean) ($this->getEnddate()->format('Y-m-d') < date("Y-m-d") );
    }

    public function isActiveToRegister() {

        return (boolean) ($this->getStartdate()->format('Y-m-d') > date("Y-m-d") );
    }

    public function __toString() {
        return (string) $this->getTitle();
    }


    /**
     * Set currency
     *
     * @param \AppBundle\Entity\Currency $currency
     *
     * @return Courses
     */
    public function setCurrency(\AppBundle\Entity\Currency $currency = null)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return \AppBundle\Entity\Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Courses
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }
}
