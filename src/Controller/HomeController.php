<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Offre;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use Symfony\Component\Mime\Email;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
        /**
    *@Route("/",name="home")
    */
  public function ArticleParNom(Request $request,PaginatorInterface $paginator)
    
  {   
    $paginations=true;
    $articles= [];    
     $repos=$this->getDoctrine()->getRepository(Article::class);
     $propertySearch = new PropertySearch();
     $donnes=$repos->createQueryBuilder('s')->getQuery($propertySearch);
   // $donnes=$repos->findAll(); //cuz findAll its verry Slow !!    
      $form = $this->createForm(PropertySearchType::class,$propertySearch);
      $form->handleRequest($request);
      $articles=$paginator->paginate(
      $donnes,//on passe les donnes 
      $request->query->getInt('page',1),//Numéro de la page en cours,1 par défaut
      5 //Limit dans chaque page 
    );
     //initialement le tableau des articles est vide, 
     //on affiche les articles que lorsque l'utilisateur clique sur le bouton rechercher  
    //  if($form->isSubmitted() && $form->isValid()) {
    //   $paginations=false;
    //   $minPrice = $propertySearch->prixmin; 
    //   $maxPrice = $propertySearch->prixmax;
    //   $category = $propertySearch->categorie;
    //   $nom = $propertySearch->getNom(); 
  
    // switch ($articles) {
    //   case $nom!="":
    //     $articles= $repos->findBy(['nom_article' => $nom] );
    //       break;
    //   case $minPrice!=""&& $maxPrice!="":
    //     $articles=$repos->findbyprix($minPrice,$maxPrice);//ceci n'est ps un erreur!!
    //             break; 
    //   case $category!="":
    //     $articles= $repos->findBy(['categorie' => $category] );
    //            break;           
    //   default:  $articles= $repos->createQueryBuilder('s')->getQuery($propertySearch);//ceci n'est ps un erreur!!  
    //           break;    

    //                    } 
    //  }  
       //! Offre Carsole

       $offres=[];
       $repos=$this->getDoctrine()->getRepository(Offre::class);
       $offre=$repos->findAll();
       foreach($offre as $of){
         $article=$this->getDoctrine()->getRepository(Article::class)->findOneBy(["id"=>$of->getidar()]);
         array_push($offres,$article);
       }
       $nvprd=$this->getDoctrine()->getRepository(Article::class)->findAll(array(),array('createdAt' => 'ASC'));
      return  $this->render('home/index.html.twig',[ 'form' =>$form->createView(),'bestar' => $nvprd,'articles' => $articles,'paginations'=>$paginations,'offre'=>$offres]);
                    
    }

     /**
     * @Route("/article/{id}",name="detail")
     */
    public function Afficher($id,Request $request,SessionInterface $session){
  
        if(isset($_POST['add'])){
         $session->set('q', $_POST["qunt"]);
          // dd($_POST["qunt"]);
            $qu=$request->request->get('qunt');
      
            return $this->redirectToRoute('AddPanier',['id'=>$id]);
        }else{
        $repos=$this->getDoctrine()->getRepository(Article::class);
        $article=$repos->find($id);
        return $this->render('/home/afficher.html.twig',['article'=>$article]);
        }
    }

    /**
     * @Route("/products",name="products")
     */
    public function products(Request $request,PaginatorInterface $paginator){
      $articles= [];
      $paginations=true;    
      $repos=$this->getDoctrine()->getRepository(Article::class);
      $propertySearch = new PropertySearch();
      $donnes=$repos->createQueryBuilder('s')->getQuery($propertySearch);
    // $donnes=$repos->findAll(); //cuz findAll its verry Slow !!    
       $form = $this->createForm(PropertySearchType::class,$propertySearch);
       $form->handleRequest($request);
       $articles=$paginator->paginate(
       $donnes,//on passe les donnes 
       $request->query->getInt('page',1),//Numéro de la page en cours,1 par défaut
       5 //Limit dans chaque page 
     );
      //initialement le tableau des articles est vide, 
      //on affiche les articles que lorsque l'utilisateur clique sur le bouton rechercher  
      if(isset($_POST['btn']) and !empty($_POST['categorie'])) {
       $paginations=false;
       $category=$_POST['categorie'];
       $catrep=$this->getDoctrine()->getRepository(Categorie::class);
      $repos=$this->getDoctrine()->getRepository(Article::class);

      $cat= $catrep->findBy(['Nom_cat' => $category] );
         if(count($cat)>0){
        $id=$cat[0]->getId();  
        $articles= $repos->findBy(['categorie' => $id] );
          return  $this->render('home/allproduct.html.twig',['articles' => $articles,'paginations'=>$paginations]);
         }else{
          $articles=[];
          return  $this->render('home/allproduct.html.twig',['articles' => $articles,'paginations'=>$paginations]);
         }
      }  
  
      return  $this->render('home/allproduct.html.twig',['articles' => $articles,'paginations'=>$paginations]);
    }


    /**
     * @Route("/offre",name="offre")
     */
    public function offre(){
      $offres=[];
      $repos=$this->getDoctrine()->getRepository(Offre::class);
      $offre=$repos->findAll();
      ////
       

      /////
      $date=new \DateTime();
      $date->format("Y-m-d");
      $red=[];
      $offer=$repos->findoffers($date);
      foreach($offer as $of){
        $article=$this->getDoctrine()->getRepository(Article::class)->findOneBy(["id"=>$of->getidar()]);
        array_push($offres,$article);
        $m=$article->getPrixArticle()* $of->getreduction()/100;
        $montan=$article->getPrixArticle()-$m;
        array_push($red,$montan);
      }

      return $this->render('/home/offre.html.twig',['articles'=>$offres,'monta'=>$red]);
  }
   
     /**
     * @Route("/about",name="about")
     */
    public function About(){
  
      return $this->render('/home/about.html.twig');
      }
    



  /**
     * @Route("/contact",name="contact")
     *  @Route("/contact/{mail}",name="contactadmin")
     */
    public function contact(Request $req,MailerInterface $mailer,$mail=null,Security $sec){
         $admin=true;
        if($req->request->count()>0){
            if($mail!=null){
              $admin=false;
              $user = $this->getUser();
             
              $email = (new Email())
              ->from($user->getEmail())
              ->to($req->request->get('email'))  //!!! a changer
              ->subject($req->request->get('sujet'))   
              ->html('Email ecrit par '. $user->getUsername().'<p>'.$req->request->get('message').'</p>');
                 $mailer->send($email);
              $this->addFlash("success","Email Envoyé avec succès");
            //  return $this->render('/home/Contact.html.twig',["admin"=>$admin]);
              return $this->render('/home/Contact.html.twig',["admin"=>true]);     
            }else{

          //! 1) Activer l option 
          //!  https://myaccount.google.com/lesssecureapps?pli=1
          //! 2)config .env  line 38
          //! MAILER_DSN=gmail://email@gmail.com:pass@default

          $email = (new Email())
          ->from($req->request->get('email'))
          ->to('ecomercnet@gmail.com')  //!!! a changer
          ->subject($req->request->get('sujet'))   
          ->text($req->request->get('message'))
          ->html('<p>'.'Email ecrit par '.$req->request->get('nom') .'<br> '.$req->request->get('message').'</p>');
          $mailer->send($email);
          $this->addFlash("success","Email Envoyé avec succès");
         return $this->render('/home/Contact.html.twig',["admin"=>$admin]);
            }
        }
       
      return $this->render('/home/Contact.html.twig',["admin"=>$admin]);
  }

}
