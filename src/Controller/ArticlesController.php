<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use GpsLab\Bundle\PaginationBundle\Service\Configuration;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ArticlesController extends AbstractController
{


    /**
     * @Route("/articles", name="articles")
     */
    public function index(ArticlesRepository $articlesRepository, PaginatorInterface $paginator, Request $request): Response
    {
        //Recherche
        //Creer une entité de recherche + formulaire + traitement dans le controlleur

        //Pagination
        //Appel du service PaginatorInterface en paramètre
        //Appel de la methode paginate + paramètres
        $pagination = $paginator->paginate(
            //On recupère tous les articles
            $articlesRepository->findAll(),
            //On liste par entier (knp_paginator.yaml) on definit la cle dans url, par defaut ma page=1 + nombre d'article a afficher (ici 2)
            $request->query->getInt('page', 1), 2
        );

        return $this->render('articles/index.html.twig', [
            'controller_name' => 'ArticlesController',
            'articles' => $articlesRepository->findAll(),
            'pagination' => $pagination
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/ajouter_article", name="ajouter_article")
     */

    public function ajouterArticle(Request $request):Response{
        //Instance de entité (class) Articles
        $article = new Articles();
        //creation du formulaire
        $formArticle = $this->createForm(ArticlesType::class, $article);

        //Ajout du bouton se soumision
        $formArticle->add('ajouter_article', SubmitType::class,[
           'label' => 'Ajouter l\'article',
        ]);

        //Recup des données du formulaire
        $formArticle->handleRequest($request);

        //Cette condition verifie la methode et creer un __token qui lutte contre les injection SQL
        //Faille CRSF Cross Site Request Forgery
        if($request->isMethod("post") && $formArticle->isValid()){

            //import de photo
            $file = $formArticle['imageArticle']->getData();

            //Image est elle chargé
            if(!is_string($file)){
                //Nom rorinale de la photo
                $fileName = $file->getClientOriginalName();
                //deplacement de la photo
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
                //Attribution de la photo a entité a l'aide des setters
                $article->setImageArticle($fileName);
            }else{
                //Erreur + flashbad
                //Erreur + flashbag
                $session = $request->getSession();
                $session->getFlashBag()->add('message', 'Merci d\'ajouter une image au produit');
                $session->set('statut', 'danger');
                //Si ca marche redirection vers la meme page
                return $this->redirect($this->generateUrl('ajouter_article'));
            }

            //Appel de doctrine entityManager
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            //Message de reussite
            $session = $request->getSession();
            $session->getFlashBag()->add('message', 'L\'articleà bien été ajouté');
            $session->set('statut', 'success');
            //Si ca marche redirection ves la page de liste des produits
            return $this->redirectToRoute('articles');

            //Si ca marche
            return $this->redirectToRoute('articles');
        }
        //Aficher le formulaire d'ajout dans ca vue
        return $this->render('articles/ajouterArticles.html.twig',[
            'form_article' => $formArticle->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param Articles $articles
     * @return Response
     * @Route("/editer_article/{id}", name="editer_article")
     */

    public function editerArticle(Request $request, $id):Response{
        //Appel de Doctrine et entity Manager
        $entityManager = $this->getDoctrine()->getManager();
        //Appel du repository avec entité en paramètre
        $articleRepository = $entityManager->getRepository(Articles::class);
        //Creation du produit on passe id du produit en paramètre
        $article = $articleRepository->find($id);

        //Image existante avec le Getter
        $img = $article->getImageArticle();

        //creation du formulaire
        $formArticle = $this->createForm(ArticlesType::class, $article);

        //Ajout du bouton se soumision
        $formArticle->add('ajouter_article', SubmitType::class,[
            'label' => 'Mettre à jour l\'article',
        ]);

        //Recup des données du formulaire
        $formArticle->handleRequest($request);

        //Cette condition verifie la methode et creer un __token qui lutte contre les injection SQL
        //Faille CRSF Cross Site Request Forgery
        if($request->isMethod("post") && $formArticle->isValid()){

            //import de photo
            $file = $formArticle['imageArticle']->getData();

            //Image est elle chargé
            if(!is_string($file)){
                //Nom rorinale de la photo
                $fileName = $file->getClientOriginalName();
                //deplacement de la photo
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
                //Attribution de la photo a entité a l'aide des setters
                $article->setImageArticle($fileName);
            }else{
                //SINON ON RECUP LA PHOTO EXISTANTE
                $article->setImageArticle($img);
            }

            //Appel de doctrine entityManager

            $entityManager->persist($article);
            $entityManager->flush();

            //Message de reussite
            $session = $request->getSession();
            $session->getFlashBag()->add('message', 'L\'articleà bien été ajouté');
            $session->set('statut', 'success');
            //Si ca marche redirection ves la page de liste des produits
            return $this->redirectToRoute('articles');

        }
        //Aficher le formulaire d'ajout dans ca vue
        return $this->render('articles/ajouterArticles.html.twig',[
            'form_article' => $formArticle->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param Articles $articles
     * @Route("/supprimer_article/{id}", name="supprimer_article")
     */

    public function supprimerArticle(Request $request, $id){
        //Appel Doctrine et entity Manager
        $entityManager = $this->getDoctrine()->getManager();
        //Appel du repos et ses methodes find
        $articleRepository = $entityManager->getRepository(Articles::class);
        //Trouver le produit
        $article = $articleRepository->find($id);
        //Supprimer le produit methode remove()
        $entityManager->remove($article);
        //Confirmer
        $entityManager->flush();

        //Message de succes depuis l'objet request
        $session = $request->getSession();
        $session->getFlashBag()->add('message', 'Le produit à bien été supprimer !');
        $session->set('statut', 'success');
        //Redirection
        return $this->redirect($this->generateUrl('articles'));
    }

    /**
     * @param Articles $articles
     * @return Response
     * @Route("/lire_article/{slug}/{id}", name="lire_article")
     */

    public function lireArticle(Articles $articles): Response{

        return $this->render('articles/detailsArticle.html.twig',[
            'article' => $articles
        ]);

    }

}
