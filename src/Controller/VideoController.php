<?php
namespace App\Controller;

use App\Entity\Video;
use App\Entity\User;
use App\Entity\Seen;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class VideoController extends Controller{
  /**
  *@Route("/" , name="home" )
  *@Method({"GET"})
  */
  public function home(){
    //return new Response('<html><body>Ciao Mondo</body></html>');
    
    $videos = $this->getDoctrine()->getRepository(Video::class)->findAll();

    return $this->render('video/home.html.twig', array('videos' => $videos));
  }

  /**
  *@Route("/admin" , name="admin" )
  *@Method({"GET"})
  */
  public function index(){
    //return new Response('<html><body>Ciao Mondo</body></html>');
    
    $videos = $this->getDoctrine()->getRepository(Video::class)->findAll();

    return $this->render('video/index.html.twig', array('videos' => $videos));
  }

  
  /**
  *@Route("/video/new", name="new_video")
  *Method({"GET","POST"})
  */
  public function new(Request $request){
    $video = new Video();

    $form = $this->createFormBuilder($video)
      ->add('title', TextType::class, array(
        'attr'=> array( 'class' => 'form-control')))
      ->add('description', TextareaType::class, array(
        'required' => false,
        'attr' => array('class' => 'form-control')))
      ->add('save', SubmitType::class, array(
        'label'=> 'Create',
        'attr' => array('class' => 'btn-dark btn mt-3 btn-primary')))
      ->add('filename', FileType::class, array(
        'label' => 'Upload a video',
        'attr' => array('class' => 'form-control'),
      ))
      ->getForm();
        
       $form->handleRequest($request);
     
        if( $form->isSubmitted() && $form->isValid()){

          $fileVideo = $form['filename']->getData();

          if($fileVideo){
            $originalFilename = pathinfo($fileVideo->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$fileVideo->guessExtension();

            try {
              $fileVideo->move(
                  $this->getParameter('video_directory'),
                  $newFilename
              );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $video->setFilename($newFilename);
          }

          $video = $form->getData();

          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($video);
          $entityManager->flush();

           return $this->redirectToRoute('home');
         }
      
       return $this->render('video/new.html.twig', array(
        'form' => $form->createView()
       ));
      
  }

/**
  *@Route("/video/edit/{id}", name="edit_video")
  *Method({"GET","POST"})
  */
  public function edit(Request $request, $id){
    $video = new Video();
    $video = $this->getDoctrine()->getRepository(Video::class)->find($id);

    $form = $this->createFormBuilder($video)
      ->add('title', TextType::class, array(
        'attr'=> array( 'class' => 'form-control')))
      ->add('description', TextareaType::class, array(
        'required' => false,
        'attr' => array('class' => 'form-control')))
      ->add('save', SubmitType::class, array(
        'label'=> 'Update',
        'attr' => array('class' => 'btn-dark btn mt-3 btn-primary')))
      ->getForm();
        
       $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid()){

         $entityManager = $this->getDoctrine()->getManager();

         $entityManager->flush();

           return $this->redirectToRoute('home');
         }
      
       return $this->render('video/edit.html.twig', array(
        'form' => $form->createView()
       ));
      
  }
  /**
  *@Route("/video/delete/{id}")
  *Method({"DELETE"})
  */
    public function delete(Request $request, $id){
      $video = $this->getDoctrine()->getRepository(Video::class)->find($id);

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($video);
      $entityManager->flush();
      return $this->render('video/deleted.html.twig' , array( 'video' => $video ) );
    }
  /**
  *@Route("/video/{id}", name="single_video")
  */
  public function show($id){
    $video = $this->getDoctrine()->getRepository(Video::class)->find($id);
    if ($this->getUser()) {
      $user  = $this->getUser()->getId();

      $check = $this->getDoctrine()->getRepository(Seen::class)
          ->findBy(array(
              'user' => $user,
              'video'=> $video->getId()
          ));
  
      if ($check):
        $seencheck = 1;
      else:
        $seencheck = 0;
      endif;  
    }
    $seencheck = 0;
    return $this->render('video/single.html.twig', array( 'video' => $video, 'seencheck' => $seencheck ) );
  }

  /**
  *@Route("/article/save")
  *@Method({"GET"})
  */
  //public function save() {
    // $entityManager = $this->getDoctrine()->getManager();

    // $video = new Video();
    // $video->setTitle('Secondo video');
    // $video->setDescription('Questa è la descrizione del secondo video');
    
    // $entityManager->persist($video);

    // $entityManager->flush();

    // return new Response('Salvato video con id '.$video->getId());
  //}
}
