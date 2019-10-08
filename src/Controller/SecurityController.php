<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     * Method({"GET","POST"})
     */
    public function login(Request $request, AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $lastUsername = $utils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername
        ]);
    }
     /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, AuthenticationUtils $utils, UserPasswordEncoderInterface $encoder)
    {
        $utente = new User();
        $form = $this->createFormBuilder($utente)
        ->add('username', TextType::class, array(
            'attr'=> array( 'class' => 'form-control mb-3')))
        ->add('password', PasswordType::class,array(
            'attr'=> array( 'class' => 'form-control mb-3')))
        ->add('save', SubmitType::class, array(
            'label'=> 'Register',
            'attr' => array('class' => ' btn mt-3 btn-primary')))
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $user = $form->getData();
           $plain = $form['password']->getData();
           $encoded = $encoder->encodePassword($user, $plain);
           $user->setPassword($encoded);
            
           $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }
        return $this->render(
            'security/register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){
        
    }
}
