<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Video;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function searchBar(){
        $form = $this->createFormBuilder(null)
        ->setAction($this->generateUrl('handlesearch'))
        ->add('query', TextType::class , array(
            'label'=> 'Cerca un video',
            'attr'=> array( 'class' => 'form-control')))
        ->add('search', SubmitType::class , array(
            'attr'=> array( 'class' => 'btn btn-primary')))
        ->getForm();

        return $this->render('search/bar.html.twig', array(
            'form' => $form->createView()
        ));
    }
    /**
     * @Route("/handleSearch", name="handlesearch")
     * 
     */
    public function handleSearch(Request $request){
        $query = $request->request->get('form')['query']; 
        $videos = $this->getDoctrine()->getRepository(Video::class)->findByTitle($query);

        return $this->render('video/home.html.twig', array('videos' => $videos)); 
    }
}
