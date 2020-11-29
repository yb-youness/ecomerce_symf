<?php

namespace App\Entity;

use App\Repository\SousCategorieRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass=SousCategorieRepository::class)
 * @Vich\Uploadable()
 */
class SousCategorie
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
    private $nom_sous_categ;

    /**
     * @ORM\Column(type="text")
     * @Assert\Regex("/[a-zA-Z]$/") 
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $iamge_scateg;

      /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

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
     * @Vich\UploadableField(mapping="post_thumbnails", fileNameProperty="iamge_scateg")
     * @var File
     */
    private $thumbnail;

    public function __construct()
    {
        $this->createdAt=new \DateTime();
        $this->updatedAt=new \DateTime();
      
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSousCateg(): ?string
    {
        return $this->nom_sous_categ;
    }

    public function setNomSousCateg(string $nom_sous_categ): self
    {
        $this->nom_sous_categ = $nom_sous_categ;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIamgeScateg(): ?string
    {
        return $this->iamge_scateg;
    }

    public function setIamgeScateg(?string $iamge_scateg): self
    {
        $this->iamge_scateg = $iamge_scateg;

        return $this;
    }


    
    public function __toString()
    {
        return $this->nom_sous_categ;

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
    
    public function setimage_article(?string $iamge_scateg):self{
        $this->iamge_scateg=$iamge_scateg;
        return $this;

    }

    public $PhotoPath;  

    public function getPhotoPath()
    {
        return '/uploads/files/'.$this->iamge_scateg;
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


}
