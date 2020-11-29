<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Panier;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     */
    public function show(Request $req,SessionInterface $session,ArticleRepository $articlerepo)
    {    $panier=$session->get("panier",[]);
        $panierArticle=[];
        $total=0;
        foreach($panier as $id => $quantite){
            $panierArticle[]=[
                'article'=>$articlerepo->find($id),
                'quantite'=>$quantite
            ];

        }
        $donnes="";
        foreach($panierArticle as $data){
            $total+=$data['article']->getPrixArticle()*$data['quantite']; 
            $donnes.=" <br> Article = ".$data['article']->getNomArticle().", quantite = ".$data['quantite'].",";
        }
        $donnes.=" total=".$total;
         
        return $this->render('home/panier.html.twig',["panierArticle"=>$panierArticle,'total'=>$total,'donnes'=>rawurlencode($donnes)]);
    }




     /**
     * @Route("/panier/add/{id}", name="AddPanier")
     */
    public function Add(Request $req,$id,SessionInterface $session){
    
        
        $panier=$session->get("panier",[]);
        if(empty($panier[$id])){
            $panier[$id]=$session->get('q'); 
        }
        else{
            $panier[$id]=$session->get('q')+$panier[$id];
        }
          $val=count($panier);
          $session->set("count",$val);
          $session->set("panier",$panier);
        return $this->redirectToRoute('home'); 
    }


       /**
     * @Route("/panier/remove/{id}", name="RemovePanier")
     */
    public function Remove($id,SessionInterface $session,ArticleRepository $articlerepo)
    { $panier=$session->get("panier",[]);
        if(!empty($panier[$id])){
            $session->set("count",$session->get("count")-1);       
          unset($panier[$id]); 
        }
       $session->set("panier",$panier);
       
        return $this->redirectToRoute('panier'); 
    }









}
