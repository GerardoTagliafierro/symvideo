<?php

namespace App\Controller;

use App\Entity\Video;
use App\Entity\User;
use App\Entity\Seen;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SeenController extends AbstractController
{
    /**
     * @Route("/seen/add/{video}", name="seen")
     * ({"GET","POST"})
     */
    public function toggleSeen($video){
        $user = $this->getUser()->getId();
        $seen = new Seen();

        $check = $this->getDoctrine()->getRepository(Seen::class)
            ->findBy(array(
                'user' => $user,
                'video'=> $video
            ));
        if (!$check):
        $seen->setUser($user);
        $seen->setVideo($video);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($seen);
        $entityManager->flush();

        return $this->redirectToRoute('single_video', ['id' => $video]);
        else:
        $entityManager = $this->getDoctrine()->getManager();
        
        $entityManager->remove($check[0]);  
        $entityManager->flush();
        return $this->redirectToRoute('single_video', ['id' => $video]);
        endif;
    }
}
