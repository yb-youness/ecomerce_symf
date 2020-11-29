<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @Vich\Uploadable()
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/[a-zA-Z]$/")
     */
    private $nom_article;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_article;
    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

     /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $createdAt;

     /**
     * @Vich\UploadableField(mapping="post_thumbnails", fileNameProperty="image_article")
     * @var File
     */
    private $thumbnail;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Regex("/[a-zA-Z]$/")
    */
  
    
    private $description_article;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/[a-zA-Z]$/")
     */
    private $couleur;

    /**
     * @ORM\Column(type="float")
     * @Assert\Type(
     *     type="double",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     */
    private $prix_article;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite_article;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

 

   
    public function __construct()
    {
        $this->createdAt=new \DateTime();
        $this->updatedAt=new \DateTime();
        $this->setQuantiteArticle(50);   
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomArticle(): ?string
    {
        return $this->nom_article;
    }

    public function setNomArticle(string $nom_article): self
    {
        $this->nom_article = $nom_article;

        return $this;
    }

    public function getImageArticle(): ?string
    {
        return $this->image_article;
    }

    public function setImageArticle(?string $image_article): self
    {
        $this->image_article = $image_article;

        return $this;
    }

    public function getDescriptionArticle(): ?string
    {
        return $this->description_article;
    }

    public function setDescriptionArticle(?string $description_article): self
    {
        $this->description_article = $description_article;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getPrixArticle(): ?float
    {
        return $this->prix_article;
    }

    public function setPrixArticle(float $prix_article): self
    {
        $this->prix_article = $prix_article;

        return $this;
    }

    public function getQuantiteArticle(): ?int
    {
        return $this->quantite_article;
    }

    public function setQuantiteArticle(int $quantite_article): self
    {
        $this->quantite_article = $quantite_article;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }



 
    public function __toString()
    {
        return $this->nom_article;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

  
     /**
     * @return mixed
     */
    public function getthumbnail()
    {
        return $this->thumbnail;
    }
        /**
     * @param mixed $thumbnail
     * @throws \Exception
     */
    public function setthumbnail(File $thumbnail = null )
    {
        $this->thumbnail = $thumbnail;

        
        if ($thumbnail) {
        
            $this->updatedAt = new \DateTime('now');
        }
    }
    
    public function setimage_article(?string $image_article):self{
        $this->image_article=$image_article;
        return $this;

    }

    public $PhotoPath;  

    public function getPhotoPath()
    {
        return '/uploads/files/'.$this->image_article;
    }


    
    // public function getPhotoPath2()
    // {
    //     return $this->image_article;
    // }
   

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }






}
