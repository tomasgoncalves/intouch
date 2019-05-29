<?php

namespace App\Controller;

use Swift_Mailer;
use Swift_MailTransport;
use Swift_Message;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;



class HomeController extends AbstractController
{
  private $session;

  public function __construct(SessionInterface $session)
  {
        $this->session = $session;
  }

  //Sending email in Contact
  public function contactForm(Request $request, \Swift_Mailer $mailer) {

      $error = array();

      //Field's variable of the form
      $request->request->get('name');
      $request->request->get('email');
      $request->request->get('subject');
      $request->request->get('message');

      //If there is any error
      !$request->request->get('name') ? $error[] = 'nome' : false;
      !$request->request->get('email') ? $error[] = 'email' : false;
      !$request->request->get('subject') ? $error[] = 'assunto' : false;
      !$request->request->get('message') ? $error[] = 'mensagem' : false;

      //Counts how many error's exists
      if (count($error)>0){
            return new JsonResponse(array('status' => 0,'err' => $error)); 
      } else {  
          //If there is no error sends an email
          $transport = (new \Swift_SmtpTransport('mail.intouchbiz.com', 465, 'ssl'))
            ->setUsername('tomas.goncalves@intouchbiz.com')
            ->setPassword('intouchbiz#2019')
          ;

          // Create the Mailer using your created Transport
          $mailer = new \Swift_Mailer($transport);

          // Create a message
          $mail = (new \Swift_Message(''))
            ->setFrom(['tomas.goncalves@intouchbiz.com' => 'Tomás'])
            ->setTo([$request->request->get('email')])
            ->setBody('asdasf')
            ;

          // Send the message
          $result = $mailer->send($mail);

          return new JsonResponse(array('status' => 1, 'name' => $request->request->get('name'), 'email' => $request->request->get('email'), 'subject' => $request->request->get('subject'), 'message' => $request->request->get('message')));
      }
  }

  //Sending email in Footer
  public function footerForm(Request $request, \Swift_Mailer $mailer) {

      $error = array();

      //Field's variable of the form
      $request->request->get('name');
      $request->request->get('email');
      $request->request->get('subject');
      $request->request->get('message');

      //If there is any error
      !$request->request->get('name') ? $error[] = 'nome' : false;
      !$request->request->get('email') ? $error[] = 'email' : false;
      !$request->request->get('subject') ? $error[] = 'assunto' : false;
      !$request->request->get('message') ? $error[] = 'mensagem' : false;

      //Counts how many error's exists
      if (count($error)>0){
            return new JsonResponse(array('status' => 0,'err' => $error)); 
      } else { 
          //If there is no error sends an email 
          $transport = (new \Swift_SmtpTransport('mail.intouchbiz.com', 465, 'ssl'))
            ->setUsername('tomas.goncalves@intouchbiz.com')
            ->setPassword('intouchbiz#2019')
          ;

          // Create the Mailer using your created Transport
          $mailer = new \Swift_Mailer($transport);

          // Create a message
          $mail = (new \Swift_Message(''))
            ->setFrom(['tomas.goncalves@intouchbiz.com' => 'Tomás'])
            ->setTo([$request->request->get('email')])
            ->setBody('asdasf')
            ;

          // Send the message
          $result = $mailer->send($mail);

          return new JsonResponse(array('status' => 1, 'name' => $request->request->get('name'), 'email' => $request->request->get('email'), 'subject' => $request->request->get('subject'), 'message' => $request->request->get('message')));
      }
  }

  //Array of the page index
  public function index()
  {  
        
    $article = ['index/who', 'index/who', 'index/who', 'index/who', 'index/who'];

    return $this->render('/lucky/index.html.twig', [
      'page' => 'index', 'article' => $article
    ]);   
  }

  //Array of the page creation
  public function creation(){

    $creation = ['creation/development', 'creation/development', 'creation/development', 'creation/development'];

    return $this->render('/lucky/creation.html.twig', [ 
      'creation' => $creation, 'page' => 'creation'
    ]);
  }

  //Array of the page who
  public function who(){

    return $this->render('/lucky/who.html.twig', [ 
      'page' => 'who'
      ]);
  }

  //Translations
  public function userTranslation($lang, $page)
  {    
      $this->session->set('_locale', $lang);
      return $this->redirectToRoute($page);
  }

  //Array of the page seo
  public function seo(){
    
    $seo = ['creation/development', 'creation/development', 'creation/development', 'creation/development', ''];
     
    return $this->render('/lucky/seo.html.twig', [ 
      'seo' => $seo, 'page' => 'seo'
      ]);
  }

  //Array of the page products
  public function products(){

    $product = ['who', 'who', 'who', 'who', 'who'];
      
    return $this->render('/lucky/products.html.twig', [ 
        'product' => $product, 'page' => 'products'
      ]);
  }

  //Array of the page host
  public function host(){

    $host =  ['host/accomodation', 'host/registration'];
      
    return $this->render('/lucky/host.html.twig', [ 
        'host' => $host, 'page' => 'host'
      ]);
  }

  //Array of the page portfolio
  public function portfolio(){

    $port =  ['criacao', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''];
    
    $port1 = ['','','','',''];
           
    return $this->render('/lucky/portfolio.html.twig', [ 
      'port' => $port, 'page' => 'portfolio', 'port1' => $port1
    ]);
  }

  //Array of the page contacts
  public function contacts(){

   return $this->render('/lucky/contacts.html.twig', [
      'page' => 'contacts'
     ]);
  }

  //Array of the page accomodation 
  public function accomodation(){

    $accomodation = ['', '', '', '', '', ''];

    return $this->render('/lucky/accomodation.html.twig', [
      'page' => 'accomodation', 'accomodation' => $accomodation
    ]);

  }

  //Array of the page registration
  public function registration(){ 

   return $this->render('/lucky/registration.html.twig', [
      'page' => 'registration'
     ]);
  }

  //Array of the page development
  public function development(){

    $development =  ['', '', '', '', ''];
          
    return $this->render('/lucky/development.html.twig', [
      'development' => $development, 'page' => 'development'
     ]);
  }

  //Array of the page terms
  public function terms(){

    return $this->render('/lucky/terms.html.twig', [
     'page' => 'terms'
    ]);
  }

  //Array of the page safe_payment
  public function safe_payment(){

    return $this->render('/lucky/safe_payment.html.twig', [
     'page' => 'safe_payment'
    ]);
  }

  //Array of the page map
  public function map (){

    return $this->render('/lucky/map.html.twig', [
     'page' => 'map'
    ]);
  }

  //Array of the page deliveries
  public function deliveries(){

    return $this->render('/lucky/deliveries.html.twig', [
     'page' => 'deliveries'
    ]); 
  }

  //Array of the page we_call
  public function we_call(){

    return $this->render('/lucky/we_call.html.twig', [
       'page' => 'we_call'
    ]);
  }
}