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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;



class HomeController extends AbstractController
{
  private $session;

  public function __construct(SessionInterface $session)
  {
        $this->session = $session;
  }

  //Creates and build a form
  public function contacts(Request $request)
  {
    //Form to send data with the style of w3 css    
    $mensagem_default = ['message' => ''];//message default to be sent

    //creates a form type
    $form = $this->createFormBuilder($mensagem_default)

    //Adds the name field
    ->add('name', TextType::class, [
        'attr'=>[ 'class' => 'form-control'], 'extra_fields_message' => 'Name',  'required' => false 
    ])
    
    //Adds the email field
    ->add('email', TextType::class, [
        'attr'=>[ 'class' => 'form-control'], 'required' => false
    ])
    
    //Adds the subject field 
    ->add('subject', TextType::class, [
         'attr'=>[ 'class' => 'form-control'], 'required' => false 
    ])
        
    //Adds the message field
    ->add('message', TextareaType::class, [
        'attr'=>[ 'class' => 'form-control'], 'required' => false
    ])
    //Adds the send button
    ->add('send', SubmitType::class, [
         'attr'=>[ 'class' => 'btn-marg botaoEnviar hvr-sweep-to-left']
    ])

    ->getForm();
                   
    //Renders the array for the main page and renders the form for the body
    return $this -> render('lucky/contacts.html.twig', ['page'=> 'contacts', 'form'=> $form ->createView()]);
  }

  //Error form
  public function errorForm(Request $request) 
  {
    //Form to send data with the style of w3 css    
    $mensagem_default = ['message' => ''];//message default to be sent

    //creates a form type
    $form = $this->createFormBuilder($mensagem_default)

    //Adds the name field
    ->add('name', TextType::class, [
        'attr'=>[ 'class' => 'form-control'], 'extra_fields_message' => 'Name',  'required' => false 
    ])
    
    //Adds the email field
    ->add('email', TextType::class, [
        'attr'=>[ 'class' => 'form-control'], 'required' => false
    ])
    
    //Adds the subject field 
    ->add('subject', TextType::class, [
         'attr'=>[ 'class' => 'form-control'], 'required' => false 
    ])
        
    //Adds the message field
    ->add('message', TextareaType::class, [
        'attr'=>[ 'class' => 'form-control'], 'required' => false
    ])

    //Adds the send button
    ->add('send', SubmitType::class, [
         'attr'=>[ 'class' => 'btn-marg botaoEnviar hvr-sweep-to-left']
    ])

    ->getForm();
  
    //will fetch the fields from the form of the data that will be sent
    $form->handleRequest($request);

    //if form submission exists and the same is valid
    if($form->isSubmitted() && $form->isValid())
    {
      // will fetch the name, email, and message to the base file form
      //getData () method serves to fetch data from the ajax request
      $name=$form["name"]->getData();
      $email=$form["email"]->getData();
      $subject=$form["subject"]->getData();
      $message=$form["message"]->getData();

      //array declaration 
      $error=array();

      //if the name value is filled, will let 
      //otherwise it puts in the error array the name to print in the base file
      if(!$name)
      {
        $error[] = 'name';
      } 

      //if the email value is filled, will let 
      //otherwise it puts in the error array the email to print in the base file
      if(!$email)
      {
        $error[] = 'email';
      }

      //if the subject value is filled, will let 
      //otherwise it puts in the error array the subject to print in the base file
      if(!$subject)
      {
        $error[] = 'subject';
      }    

      //if the message value is filled, will let 
      //otherwise it puts in the error array the message to print in the base file
      if(!$message)
      {
        $error[] = 'message';
      }

      //if the error variable is filled, it returns to the base file
      if(!empty($error))
      {
        //gives status return which is 0 to make the boolean in the base file and also returns the variable data that contains the array
        return new JsonResponse(array(
          // status=0 is when it fails and tells you the field that isn't filled
          'status' => 0,
          // the variable data contains the name of the errors if it is the missing name returns the name, if it is the email returns the email error, if it is the message it returns the error of the emsage and if it is all returns all, etc ...
          'data' => $error,       
        )); 
      }

      //the response variable will stay with what comes from the array
      $response = 'array';
    }
       
    // Create the Transport
    $transport = (new \Swift_SmtpTransport('smtp.sapo.pt', 465, 'ssl'))
    ->setUsername('alticedoraul@sapo.pt')
    ->setPassword('Altice12');

    // Create the Mailer using your created Transport
    $mailer = new \Swift_Mailer($transport);

    // Create a message
    $mail = (new \Swift_Message())
    ->setFrom(['alticedoraul@sapo.pt' => 'Intouch PT'])
    ->setTo($email)
    ->setBody($this->renderView('email/registration.html.twig',
                    array(
                        'name' => $name,
                        'email' => $email,
                        'subject' => $subject,
                        'message' => $message,
                        'logo' => 'https://www.intouchbiz.com/template/logo.png',
                        
                        )
                    ),'text/html');

    // Send the message
    $mailer->send($mail);

    //If status=>1 sends the email
    return new JsonResponse(array('status' => 1));          
  }

  /*public function footer(Request $request)
  {
    //Form to send data with the style of w3 css    
    $mensagem_default = ['message' => ''];//message default to be sent

    //creates a form type
    $form = $this->createFormBuilder($mensagem_default)

    //Adds the name field
    ->add('name', TextType::class, [
        'attr'=>[ 'class' => 'form-control'], 'extra_fields_message' => 'Name',  'required' => false 
    ])
    
    //Adds the email field
    ->add('email', TextType::class, [
        'attr'=>[ 'class' => 'form-control'], 'required' => false
    ])
    
    //Adds the subject field 
    ->add('subject', TextType::class, [
         'attr'=>[ 'class' => 'form-control'], 'required' => false 
    ])
        
    //Adds the message field
    ->add('message', TextareaType::class, [
        'attr'=>[ 'class' => 'form-control'], 'required' => false
    ])
    //Adds the send button
    ->add('send', SubmitType::class, [
         'attr'=>[ 'class' => 'btn-marg botaoEnviar hvr-sweep-to-left']
    ])

    ->getForm();
                   
    //Renders the array for the main page and renders the form for the body
    return $this -> render('/Lucky/footer.html.twig', ['form'=> $form ->createView()]);
  }*/


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

    $who = ['','','','','','',''];

    return $this->render('/lucky/who.html.twig', [ 
      'page' => 'who', 'who' => $who
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

    $product = ['', '', '', '', ''];
      
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
  public function safePayment(){

    return $this->render('/lucky/safe_payment.html.twig', [
     'page' => 'safePayment'
    ]);
  }

  //Array of the page map
  public function map(){

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
  public function weCall(){

    return $this->render('/lucky/we_call.html.twig', [
       'page' => 'weCall'
    ]);
  }
}