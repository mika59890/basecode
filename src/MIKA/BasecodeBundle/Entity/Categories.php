<?php

namespace MIKA\BasecodeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Categories
 *
 * @ORM\Table(name="categories")
 * @ORM\Entity(repositoryClass="MIKA\BasecodeBundle\Repository\CategoriesRepository")
 */
class Categories
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_categorie", type="string", length=50, unique=true)
     */
    private $nomCategorie;

    /**
     * @ORM\OneToOne(targetEntity="MIKA\BasecodeBundle\Entity\Images", cascade={"persist"})
     */
    private $imageCategorie;

    /**
     * @ORM\ManyToOne(targetEntity="MIKA\UserBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nomCategorie.
     *
     * @param string $nomCategorie
     *
     * @return Categories
     */
    public function setNomCategorie($nomCategorie)
    {
        $this->nomCategorie = $nomCategorie;

        return $this;
    }

    /**
     * Get nomCategorie.
     *
     * @return string
     */
    public function getNomCategorie()
    {
        return $this->nomCategorie;
    }

    public function setImageCategorie($imageCategorie)
    {
        $this->imageCategorie = $imageCategorie;

        return $this;
    }

    public function getImageCategorie()
    {
        return $this->imageCategorie;
    }

    /**
     * Set user.
     *
     * @param \MIKA\UserBundle\Entity\User $user
     *
     * @return Categories
     */
    public function setUser(\MIKA\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \MIKA\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
