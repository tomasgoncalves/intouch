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

    public function contactForm(Request $request, \Swift_Mailer $mailer) {

        $error = array();

        $request->request->get('nome');
        $request->request->get('email');
        $request->request->get('assunto');
        $request->request->get('mensagem');

        !$request->request->get('nome') ? $error[] = 'nome' : false;
        !$request->request->get('email') ? $error[] = 'email' : false;
        !$request->request->get('assunto') ? $error[] = 'assunto' : false;
        !$request->request->get('mensagem') ? $error[] = 'mensagem' : false;


        if (count($error)>0){
              return new JsonResponse(array('status' => 1,'err' => $error)); 
        } else { 

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
              ->setBody('asda')
              ;

            // Send the message
            $result = $mailer->send($mail);

            return new JsonResponse(array('status' => 0, 'nome' => $request->request->get('nome'), 'email' => $request->request->get('email'), 'assunto' => $request->request->get('assunto'), 'value' => $request->request->get('mensagem')));
        }
    }
 
    public function index()
    {  

      $array1 = array();

    	$array1[] = array ("title" => "Criação", "acess" => "criacao");
    	

      $array1[] = array ("title" => "SEO", "acess" => "seo");
      

      $array1[] = array ("title" => "HOST", "acess" => "host");
      

      $array1[] = array ("title" => "Produtos", "acess" => "produtos");
      

      $array1[] = array ("title" => "Portefólio", "acess" => "portefolio");
      
      $article = ['index/who', 'index/who', 'index/who', 'index/who', 'index/who'];

      return $this->render('/lucky/index.html.twig', [
        'array1' => $array1, 'page' => 'index', 'article' => $article
      ]);   
    }

    public function creation(){

      $creation = ['creation/development', 'creation/development', 'creation/development', 'creation/development'];

      return $this->render('/lucky/criacao.html.twig', [ 
        'creation' => $creation, 'page' => 'creation'

        ]);
    }

    public function who(){

      return $this->render('/lucky/quemsomos.html.twig', [ 
        'page' => 'who'
        ]);
    }

    public function userTranslation($lang, $page)
    {    
        $this->session->set('_locale', $lang);
        return $this->redirectToRoute($page);
    }

    public function seo(){
      
      $seo =  $creation = ['creation/development', 'creation/development', 'creation/development', 'creation/development'];
       
      return $this->render('/lucky/seo.html.twig', [ 
        'seo' => $seo, 'page' => 'seo'
        ]);
    }

    public function products(){

      $product = ['who', 'who', 'who', 'who', 'who'];
        
      

      return $this->render('/lucky/produtos.html.twig', [ 
          'product' => $product, 'page' => 'products'
        ]);
    }

    public function host(){

      $host =  ['host/accomodation', 'host/registration'];
        
      

      return $this->render('/lucky/host.html.twig', [ 
          'host' => $host, 'page' => 'host'
        ]);
    }

    public function portfolio(){

      

    $port =  ['criacao', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''];
    
    $port1 = ['','','','',''];
      
      

      return $this->render('/lucky/portefolio.html.twig', [ 
        'port' => $port, 'page' => 'portfolio', 'port1' => $port1
        ]);
    }

    public function contacts(){


     return $this->render('/lucky/contactos.html.twig', [
        'page' => 'contacts'
       ]);
    }

    public function accomodation(){


     return $this->render('/lucky/alojamento.html.twig', [
        'page' => 'accommodation'
       ]);
    }

    public function registration(){ 


     return $this->render('/lucky/registo.html.twig', [
        'page' => 'registration'
       ]);
    }

    public function development(){

      $development =  array();
        
      $development[] = array('id' => '1', 'title' => 'Plataformas', 'subtitle' => 'Tudo o que precisa para começar, é concentrar-se na sua sua área de negócio, nós cuidamos do resto.', 'img' => 'http://www.intouchbiz.com/template/online_shop.png');

      $development[] = array('id' => '2', 'title' => 'APP Android e IOS', 'subtitle' => 'A Criatividade e a originalidade são essenciais para transformar as suas ideias numa presença on-line.', 'img' => 'http://www.intouchbiz.com/template/webdesign_1.png');

      $development[] = array('id' => '3', 'title' => 'Soluções e medida', 'subtitle' => 'A plataforma que o ajuda a gerir os seus contactos e a definir as suas estratégias de Marketing Digital.', 'img' => 'http://www.intouchbiz.com/template/crm.png');

      $development[] = array('id' => '4', 'title' => 'Comércio B2B e B2C', 'subtitle' => 'Ao longo do tempo juntamos a melhor equipa de programadores para dar vida a criatividade da nossa equipa de design.', 'img' => 'http://www.intouchbiz.com/template/develop.png');

      $development[] = array('id' => '4', 'title' => 'Comércio On-line', 'subtitle' => 'Ao longo do tempo juntamos a melhor equipa de programadores para dar vida a criatividade da nossa equipa de design.', 'img' => 'http://www.intouchbiz.com/template/develop.png');


      return $this->render('/lucky/desenvolvimento.html.twig', [
        'development' => $development, 'page' => 'development'
       ]);
    }
}