<?php

namespace MIKA\BasecodeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SousCategories
 *
 * @ORM\Table(name="sous_categories")
 * @ORM\Entity(repositoryClass="MIKA\BasecodeBundle\Repository\SousCategoriesRepository")
 */
class SousCategories
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
     * @ORM\Column(name="nomSousCategorie", type="string", length=50)
     */
    private $nomSousCategorie;

    /**
     * @ORM\OneToOne(targetEntity="MIKA\BasecodeBundle\Entity\Images", cascade={"persist"})
     */
    private $imageSousCategorie;

    /**
     * @ORM\ManyToOne(targetEntity="MIKA\BasecodeBundle\Entity\Categories", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

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
     * Set nomSousCategorie.
     *
     * @param string $nomSousCategorie
     *
     * @return SousCategories
     */
    public function setNomSousCategorie($nomSousCategorie)
    {
        $this->nomSousCategorie = $nomSousCategorie;

        return $this;
    }

    /**
     * Get nomSousCategorie.
     *
     * @return string
     */
    public function getNomSousCategorie()
    {
        return $this->nomSousCategorie;
    }

    public function setImageSousCategorie($imageSousCategorie)
    {
        $this->imageSousCategorie = $imageSousCategorie;

        return $this;
    }

    public function getImageCategorie()
    {
        return $this->imageCategorie;
    }

    /**
     * Get imageSousCategorie.
     *
     * @return \MIKA\BasecodeBundle\Entity\Images|null
     */
    public function getImageSousCategorie()
    {
        return $this->imageSousCategorie;
    }

    /**
     * Set categorie.
     *
     * @param \MIKA\BasecodeBundle\Entity\Categories $categorie
     *
     * @return SousCategories
     */
    public function setCategorie(\MIKA\BasecodeBundle\Entity\Categories $categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie.
     *
     * @return \MIKA\BasecodeBundle\Entity\Categories
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
}
