<?php

namespace App\Entity;

use App\Entity\Article;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OffreRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=OffreRepository::class)
 */
class Offre
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_debut;

    /**
     * @ORM\Column(type="date")
     */
    private $date_fin;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="offre")
     */
    private $article;

   /**
     * @ORM\Column(type="integer")
     */
    private $reduction; 
 
    public function getreduction(): ?int
    {
        return $this->reduction;
    }

    public function setreduction(int $reduction): self
    {
        $this->reduction = $reduction;

        return $this;
    }


    public function __construct()
    {
        $this->article = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }



    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

 

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function __toString()
    {
        return $this->id." ".$this->article->getId();
    }

    public function getArticle(): ?Article
    {    
        
        return $this->article=null;
    }
   
    
    public $idar;  
    public function getidar()
    {
        return $this->article->getId();
    }


    public $idarticle;  
    public function getidarticle()
    {
        return $this->article->getNomArticle();
    }
    public $prixavred;  
    public function prixavred()
    {
        return $this->article->getPrixArticle();
    }

    public $prixapresreduction;  
    public function prixapresreduction()
    {   
        $m=$this->article->getPrixArticle()* $this->getreduction()/100;
         $montan=$this->article->getPrixArticle()-$m;
        return $montan;
    }



    public $photarticle;  
    public function photarticle()
    {
        return $this->article->getPhotoPath();
    }

   

    
}
