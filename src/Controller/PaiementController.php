<?php

namespace App\Controller;

use App\Entity\Paiement;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class PaiementController extends AbstractController
{
    /**
     * @Route("/paiement/{donnes}", name="paiement")
     */
    public function AjouterPaiement(Request $request,$donnes,MailerInterface $mailer,SessionInterface $session,ArticleRepository $articlerepo)
    { 
       
        $panier=$session->get("panier",[]);
        $panierArticle=[];
        foreach($panier as $id => $quantite){
            $panierArticle[]=[
                'article'=>$articlerepo->find($id),
                'quantite'=>$quantite
            ];
        }

    //  dd($panierArticle);

      
        $entityManager = $this->getDoctrine()->getManager();
        $Paiement = new Paiement();
        $monpanier=rawurldecode($donnes);
        $total=0;
        $totalp=[];
        foreach($panierArticle as $data){
            $total+=$data['article']->getPrixArticle()*$data['quantite']; 
            array_push($totalp,$data['article']->getPrixArticle()*$data['quantite']);
        }
 


        // $d=strip_tags ($monpanier,'<p>');
        //  dd($d);
        if($request->request->count()>0){
            $user = $this->getUser();  
            $Paiement->setPanier($monpanier);
            $Paiement->setNom($request->request->get('nom'));
            $Paiement->setPrenom($request->request->get('prenom'));
            $Paiement->setEmail($user->getEmail());//$request->request->get('email'
            $Paiement->setAdress($request->request->get('adresse'));
            $Paiement->setTel($request->request->get('Tel'));
             $Paiement->setDatePaiemnet( new \DateTime());
             $entityManager->persist($Paiement);
             $entityManager->flush();

       //! to do
     
       $email = (new Email())
       ->from('ecomercnet@gmail.com')
       ->to($user->getEmail())  //!!! a changer $user->getEmail()
       ->subject("Confirmation de transaction" )   
       ->html('<h1>Achat réussi</h1>'.$request->request->get('nom').' '.$request->request->get('prenom') .'<p>'.$monpanier.'</p>');
       $mailer->send($email);
             $this->addFlash("success","Achat réussi vérifier votre email pour plus de detail");
             $session = $request->getSession();
             $session->remove('panier');
             $session->remove('count');
        }
        return $this->render('paiement/index.html.twig',["panierArticle"=>$panierArticle,'total'=>$total,"prixt"=>$totalp]);
    }
}
