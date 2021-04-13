<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AdminController extends AbstractController
{
    /**
     * @Route("/ajouter", name="ajouter")
     */
    public function ajouter(Request $request):Response{
        //Instance du produit
        $produit = new Produit();
        //Appel de la methode createForm de AbstactController
        //En paramètre on passe le formulaire + entité
        $formProduit = $this->createForm(ProduitType::class, $produit);
        //Ajout d'un bouton de soumission
        $formProduit->add('ajouter', SubmitType::class,[
            'label' => 'Ajouter le produit',
            'validation_groups' => array('produits', 'all'),
            'attr' => [
                'class' => 'btn btn-outline-success mt-3'
            ]
        ]);

        //Recupération des données des champs du formulaire
        $formProduit->handleRequest($request);


        //Condition de securité et de methode de formInterface (booléen verifie l'integrité des champs)
        if($request->isMethod('post') && $formProduit->isValid()){

            //return new JsonResponse($request->request->all());

            //Appel d'entityManager de Doctrine
            $entityManager = $this->getDoctrine()->getManager();

            //Upload de la photo (appel de  private $photoProduit; de entité)
            $file = $formProduit['photoProduit']->getData();

            //Une image a t elle ete chargée
            if(!is_string($file)){
                //Nom originale de la photo
                $fileName = $file->getClientOriginalName();
                //php move_uploaded chemin dans config/services.yaml
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
                //Entité produit et Setters photoImage
                $produit->setPhotoProduit($fileName);
            }else{
                //Erreur + flashbag
                $session = $request->getSession();
                $session->getFlashBag()->add('message', 'Merci d\'ajouter une image au produit');
                $session->set('statut', 'danger');
                //Si ca marche redirection vers la meme page
                return $this->redirect($this->generateUrl('ajouter'));
            }

            //Persistance des données entrées dans le formulaire
            $entityManager->persist($produit);
            //Enregistrement en base de données
            $entityManager->flush();
            //Message de reussite
            $session = $request->getSession();
            $session->getFlashBag()->add('message', 'Le produit à bien été ajouté');
            $session->set('statut', 'success');
            //Si ca marche redirection ves la page de liste des produits
            return $this->redirectToRoute('liste_produits');

        }
        //Affiche de base le formulaire @Route (ajouter etc...)
        return $this->render('admin/ajouter.html.twig',[
            //Ici la methode formView genere de html
            'formulaire_produit' => $formProduit->createView()
        ]);
    }

    /**
     * @Route("/editer/{id}", name="editer")
     */
    public function editer(Request $request, $id):Response{

        //Appel d'entityManager de Doctrine
        $entityManager = $this->getDoctrine()->getManager();
        //Appel du repository avec entité en paramètre
        $produitRepository = $entityManager->getRepository(Produit::class);
        //Creation du produit on passe id du produit en paramètre
        $produit = $produitRepository->find($id);

        //On recupère la photo existante
        $img = $produit->getPhotoProduit();

        //Appel de la methode createForm de AbstactController
        //En paramètre on passe le formulaire + entité
        $formProduit = $this->createForm(ProduitType::class, $produit);
        //Ajout d'un bouton de soumission
        $formProduit->add('ajouter', SubmitType::class,[
            'label' => 'Mettre à jour le produit',
            'validation_groups' => array('all'),
            'attr' => [
                'class' => 'btn btn-outline-warning mt-3'
            ]
        ]);

        //Recupération des données des champs du formulaire
        $formProduit->handleRequest($request);

        //Condition de securité et de methode de formInterface (booléen verifie l'integrité des champs)
        if($request->isMethod('post') && $formProduit->isValid()){

            //return new JsonResponse($request->request->all());

            //Upload de la photo (appel de  private $photoProduit; de entité)
            $file = $formProduit['photoProduit']->getData();

            //Une image a t elle ete chargée
            if(!is_string($file)){
                //Nom originale de la photo
                $fileName = $file->getClientOriginalName();
                //php move_uploaded chemin dans config/services.yaml
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
                //Entité produit et Setters photoImage
                $produit->setPhotoProduit($fileName);
            }else{
                //Si l'image ne change pas on recupère l'ancienne (Setters $img (Getters))
                $produit->setPhotoProduit($img);

            }

            //Persistance des données entrées dans le formulaire
            $entityManager->persist($produit);
            //Enregistrement en base de données
            $entityManager->flush();
            //Message de reussite
            $session = $request->getSession();
            $session->getFlashBag()->add('message', 'Le produit à bien été mis à jour');
            $session->set('statut', 'success');
            //Si ca marche redirection ves la page de liste des produits
            return $this->redirectToRoute('liste_produits');

        }
        //Affiche de base le formulaire @Route (ajouter etc...)
        return $this->render('admin/editer.html.twig',[
            //Ici la methode formView genere de html
            'formulaire_produit' => $formProduit->createView()
        ]);


    }

    /**
     * @Route("/supprimer/{id}", name="supprimer")
     */
    public function supprimer(Request $request, $id):Response{

        //Appel de la methode entityManage de Doctrine
        $entityManager = $this->getDoctrine()->getManager();
        //Recuperation du Repo et de l'entité en paramètre
        $produitRepository = $entityManager->getRepository(Produit::class);
        //Recupération du produit
        $produit = $produitRepository->find($id);
        //Supression du produit
        $entityManager->remove($produit);
        //Confirmation de la supression
        $entityManager->flush();

        //Message de succes depuis l'objet request
        $session = $request->getSession();
        $session->getFlashBag()->add('message', 'Le produit à bien été supprimer !');
        $session->set('statut', 'success');
        //Redirection
        return $this->redirect($this->generateUrl('liste_produits'));
    }
}
