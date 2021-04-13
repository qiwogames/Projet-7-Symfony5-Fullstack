<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    /**
     * @Route("/inscription", name="register")
     */
    public function inscription(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        // 1 - Construire le formulaire
        $user = new User();

        //Appel de RegisterType et association a entité User
        $formUser = $this->createForm(RegisterType::class, $user);

        //Ajout du bouton de soumission
        $formUser->add('register', SubmitType::class,[
            'label' => "S'incrire",
            'attr' => [
                'class' => 'btn btn-outline-success'
            ]
        ]);

        //Request recup les données du formulaire
        $formUser->handleRequest($request);

        //Soumisiion et condition de validiter
        if($request->isMethod('post') && $formUser->isValid()){
            //Accès aux champs du formulaire
            $data = $formUser->getData();
            //On encode le mot de passe
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            //Les roles Appel de getRoles Array avec au minimul le Role User
            $user->setRoles($user->getRoles());
            //Appel de Doctrine EntityManager
            $entityManager = $this->getDoctrine()->getManager();
            //Persistance des données
            $entityManager->persist($user);
            //Enregistrement des données
            $entityManager->flush();
            //Si ca marche on redirige vers login
            return $this->redirectToRoute('app_login');
        }

        //Appel de la vue et du formulaire d'incription
        return $this->render('register/index.html.twig', [
            'controller_name' => 'RegisterController',
            'form_user' => $formUser->createView()
        ]);
    }
}
