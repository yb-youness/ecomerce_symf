<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 * @Vich\Uploadable()
 */
class Categorie
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
    private $Nom_cat;

    /**
     * @ORM\Column(type="text", length=255)
     * @Assert\Regex("/[a-zA-Z]$/")
     */
    private $Description_cat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     
     */
    private $image_cate;

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
     * @Vich\UploadableField(mapping="post_thumbnails", fileNameProperty="image_cate")
     * @var File
     */
    private $thumbnail;


  

    public function __construct()
    {
        $this->createdAt=new \DateTime();
        $this->updatedAt=new \DateTime();
      
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCat(): ?string
    {
        return $this->Nom_cat;
    }

    public function setNomCat(string $Nom_cat): self
    {
        $this->Nom_cat = $Nom_cat;

        return $this;
    }

    public function getDescriptionCat(): ?string
    {
        return $this->Description_cat;
    }

    public function setDescriptionCat(string $Description_cat): self
    {
        $this->Description_cat = $Description_cat;

        return $this;
    }

    public function getImageCate(): ?string
    {
        return $this->image_cate;
    }

    public function setImageCate(?string $image_cate): self
    {
        $this->image_cate = $image_cate;

        return $this;
    }

   

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setCategorie($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getCategorie() === $this) {
                $article->setCategorie(null);
            }
        }

        return $this;
    }

  

    public function addSousCategory(SousCategorie $sousCategory): self
    {
        if (!$this->sousCategories->contains($sousCategory)) {
            $this->sousCategories[] = $sousCategory;
            $sousCategory->setCategorie($this);
        }

        return $this;
    }

    public function removeSousCategory(SousCategorie $sousCategory): self
    {
        if ($this->sousCategories->contains($sousCategory)) {
            $this->sousCategories->removeElement($sousCategory);
            // set the owning side to null (unless already changed)
            if ($sousCategory->getCategorie() === $this) {
                $sousCategory->setCategorie(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->Nom_cat;
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
    
    public function setimage_cate(?string $image_cate):self{
        $this->image_cate=$image_cate;
        return $this;

    }

    public $PhotoPath;  

    public function getPhotoPath()
    {
        return '/uploads/files/'.$this->image_cate;
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
