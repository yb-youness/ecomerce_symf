<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PaiementRepository;

/**
 * @ORM\Entity(repositoryClass=PaiementRepository::class)
 */
class Paiement
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
     * @Assert\NotBlank  
     */
    public $nom;
     /**
     *@Assert\NotBlank    
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/[a-zA-Z]$/")
     */

    public $prenom;
    /**
     * @ORM\Column(type="string", length=180)
     * @Assert\Email(
     * message = "The email '{{ value }}' is not a valid email.")
     */
    private $email;
     /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank  
     * @Assert\Regex(pattern="/^[0-9]*$/", message="Entrer un numéro de téléphone valide")
     */
    private $tel;

      /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/[a-zA-Z]$/")
     */
    private $adress;
    /**
     * @ORM\Column(type="string", length=255)
     */
    public $panier;
    /**
     * @ORM\Column(type="date")
     */
    private $date_paiemnet;
    


    public function getId(): ?int
    {
        return $this->id;
    }
   
  
    public function getDatePaiemnet(): ?\DateTimeInterface
    {
        return $this->date_paiemnet;
    }

    public function setDatePaiemnet(\DateTimeInterface $date_paiemnet): self
    {
        $this->date_paiemnet = $date_paiemnet;

        return $this;
    }


    /**
     * Get the value of nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Set the value of panier
     *
     * @return  self
     */ 
    public function setPanier($panier)
    {
        $this->panier = $panier;

        return $this;
    }

    /**
     * Get the value of panier
     */ 
    public function getPanier()
    {
        return $this->panier;
    }



    /**
     * Set the value of prenom
     *
     * @return  self
     */ 
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

   


    /**
     * Set message = "The email '{{ value }}' is not a valid email.")
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

  


    /**
     * Set the value of tel
     *
     * @return  self
     */ 
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Set the value of adress
     *
     * @return  self
     */ 
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get message = "The email '{{ value }}' is not a valid email.")
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of tel
     */ 
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Get the value of adress
     */ 
    public function getAdress()
    {
        return $this->adress;
    }
}
