<?php

namespace MIKA\BasecodeBundle\Controller;

use MIKA\BasecodeBundle\Entity\Article;
use MIKA\BasecodeBundle\Entity\Categories;
use MIKA\BasecodeBundle\Entity\SousCategories;
use MIKA\BasecodeBundle\Form\ArticleType;
use MIKA\BasecodeBundle\Form\CategoriesType;
use MIKA\BasecodeBundle\Form\SousCategoriesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SiteController extends Controller
{
    //Affichage des catégories
    public function accueilAction()
    {
        $em = $this->getDoctrine()
            ->getManager();
        $listCategories = $em->getRepository('MIKABasecodeBundle:Categories')->findBy(array('user' => $this->getUser()));
        return $this->render('@MIKABasecode/Site/accueil.html.twig', array('listCategories' => $listCategories));
    }
    //Affichage des sous-catégories
    public function souscategorieAction(Request $request, Categories $categories, $id){
        $session = $request->getSession();
        $em = $this->getDoctrine()
            ->getManager();
        $listSousCategorie = $em->getRepository('MIKABasecodeBundle:SousCategories')->findBy(array('categorie' => $id));
        return $this->render('@MIKABasecode/Site/sousCategorie.html.twig', array(
            'listSousCategorie'=> $listSousCategorie,
            'categorie'   => $categories
        ));
    }
    //Affichage des articles
    public function articleAction(Request $request, SousCategories $sousCategories, Categories $categories = null, $id){
        $session = $request->getSession();
        $em = $this->getDoctrine()
            ->getManager();
        $listArticle = $em->getRepository('MIKABasecodeBundle:Article')->findBy(array('sousCategorie' => $id));
        return $this->render('@MIKABasecode/Site/article.html.twig', array(
            'listArticle'=> $listArticle,
            'categorie'   => $categories,
            'sousCategorie' => $sousCategories
        ));
    }
    //Ajouter catégories
    public function addcategorieAction(Request $request){

        $categorie = new Categories();
        $form = $this->get('form.factory')->create(CategoriesType::class, $categorie);
        // Si la requête est en POST
        if ($request->isMethod('POST')&& $form->handleRequest($request)->isValid()) {
            // On enregistre notre objet $advert dans la base de données, par exemple
            $em = $this->getDoctrine()->getManager();
            $categorie->setUser($this->getUser());
            $em->persist($categorie);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Nouvelle catégorie ajouté.');
            // On redirige vers la page de visualisation de l'annonce nouvellement créée
            return $this->redirectToRoute('mika_basecode_homepage');
        }
        // On passe la méthode createView() du formulaire à la vue
        // afin qu'elle puisse afficher le formulaire toute seule
        return $this->render('@MIKABasecode/Site/addCategorie.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    //Ajouter sous-catégories
    public function addsouscategorieAction(Request $request){
        $sousCategorie = new SousCategories();
        $form = $this->get('form.factory')->create(SousCategoriesType::class, $sousCategorie);
        // Si la requête est en POST
        if ($request->isMethod('POST')&& $form->handleRequest($request)->isValid()) {
            // On enregistre notre objet $advert dans la base de données, par exemple
            $em = $this->getDoctrine()->getManager();
            $em->persist($sousCategorie);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Nouvelle catégorie ajouté.');

            // On redirige vers la page de visualisation de l'annonce nouvellement créée
            return $this->redirectToRoute('mika_basecode_sous_categorie', array('id'=> $sousCategorie->getCategorie()->getId()));
        }
        // On passe la méthode createView() du formulaire à la vue
        // afin qu'elle puisse afficher le formulaire toute seule
        return $this->render('@MIKABasecode/Site/addSousCategorie.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function addarticleAction(Request $request, $id, Categories $categories = null){
        $article = new Article();
        $session = $request->getSession();
        $em = $this->getDoctrine()
            ->getManager();
        $categorie = $em->getRepository('MIKABasecodeBundle:Categories')->findBy(array('id' => $id));
        $form = $this->get('form.factory')->create(ArticleType::class, $article, [
            'entity_manager' => $em,
            'categorie'      => $categorie,]);
        if ($request->isMethod('POST')&& $form->handleRequest($request)->isValid()) {
            // On enregistre notre objet $advert dans la base de données, par exemple
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Nouvelle article ajouté.');
            // On redirige vers la page de visualisation de l'annonce nouvellement créée
            return $this->redirectToRoute('mika_basecode_article', array('id'=> $article->getSousCategorie()->getId()));
        }
        return $this->render('@MIKABasecode/Site/addArticle.html.twig', array(
            'categorie' => $categorie,
            'form' => $form->createView(),
        ));
    }

    public function modifiercategorieAction(Request $request, $id){

        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('MIKABasecodeBundle:Categories')->find($id);
        $form = $this->get('form.factory')->create(CategoriesType::class, $categorie);
        // Si la requête est en POST
        if ($request->isMethod('POST')&& $form->handleRequest($request)->isValid()) {
            // On enregistre notre objet $advert dans la base de données, par exemple
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Catégorie modifié.');
            // On redirige vers la page de visualisation de l'annonce nouvellement créée
            return $this->redirectToRoute('mika_basecode_homepage');
        }
        // On passe la méthode createView() du formulaire à la vue
        // afin qu'elle puisse afficher le formulaire toute seule
        return $this->render('@MIKABasecode/Site/addCategorie.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function modifiersouscategorieAction(Request $request, $id){

        $em = $this->getDoctrine()->getManager();
        $sousCategorie = $em->getRepository('MIKABasecodeBundle:SousCategories')->find($id);
        $form = $this->get('form.factory')->create(SousCategoriesType::class, $sousCategorie);
        // Si la requête est en POST
        if ($request->isMethod('POST')&& $form->handleRequest($request)->isValid()) {
            // On enregistre notre objet $sousCategorie dans la base de données
            $em = $this->getDoctrine()->getManager();
            $em->persist($sousCategorie);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Sous-catégorie modifié.');
            // On redirige vers la page de visualisation des sous-catégories
            return $this->redirectToRoute('mika_basecode_sous_categorie', array('id'=> $sousCategorie->getCategorie()->getId()));
        }
        // On passe la méthode createView() du formulaire à la vue
        // afin qu'elle puisse afficher le formulaire toute seule
        return $this->render('@MIKABasecode/Site/addSousCategorie.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    public function modifierarticleAction(Request $request, $id){
        $session = $request->getSession();
        $em = $this->getDoctrine()
            ->getManager();
        $article = $em->getRepository('MIKABasecodeBundle:Article')->find(array('id' => $id));
        $idCat = $article->getSousCategorie()->getCategorie()->getId();
        $categorie = $em->getRepository('MIKABasecodeBundle:Categories')->find(array('id' => $idCat));
        $form = $this->get('form.factory')->create(ArticleType::class, $article,  [
            'entity_manager' => $em,
            'categorie'      => $categorie,]);
        if ($request->isMethod('POST')&& $form->handleRequest($request)->isValid()) {
            // On enregistre notre objet $sousCategorie dans la base de données
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Article modifié.');
            // On redirige vers la page de visualisation des sous-catégories
            return $this->redirectToRoute('mika_basecode_article', array('id'=> $article->getSousCategorie()->getId()));
        }
        return $this->render('@MIKABasecode/Site/addArticle.html.twig', array(
            'categorie' => $categorie,
            'form' => $form->createView(),
        ));
    }

    public function supprimerarticleAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('MIKABasecodeBundle:Article')->find($id);

        if (null === $article) {
            throw new NotFoundHttpException("L'article n'existe pas.");
        }
        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'article contre cette faille
        $form = $this->get('form.factory')->create();
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $idCat = $article->getSousCategorie()->getId();
            $em->remove($article);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', "L'article a bien été supprimé.");
            return $this->redirectToRoute('mika_basecode_article', array('id'=> $idCat));
        }
        return $this->render('@MIKABasecode/Site/supprimerArticle.html.twig', array(
            'article' => $article,
            'form'   => $form->createView(),
        ));
    }

    public function supprimersouscategorieAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $sousCategorie = $em->getRepository('MIKABasecodeBundle:SousCategories')->find($id);
        if (null === $sousCategorie) {
            throw new NotFoundHttpException("La sous-catégorie n'existe pas.");
        }
        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'article contre cette faille
        $form = $this->get('form.factory')->create();
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $idCat = $sousCategorie->getCategorie()->getId();
            $em->remove($sousCategorie);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', "La sous-catégorie a bien été supprimé.");
            return $this->redirectToRoute('mika_basecode_sous_categorie', array('id'=> $idCat));
        }
        $nom = $sousCategorie->getId();
        $nbArticles = $em->getRepository('MIKABasecodeBundle:Article')->countArticlesBySc($nom);
        return $this->render('@MIKABasecode/Site/supprimerSousCategorie.html.twig', array(
            'sousCategorie' => $sousCategorie,
            'nbArticles' => $nbArticles,
            'form'   => $form->createView(),
        ));
    }

    public function supprimercategorieAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('MIKABasecodeBundle:Categories')->find($id);
        if (null === $categorie) {
            throw new NotFoundHttpException("La catégorie n'existe pas.");
        }
        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'article contre cette faille
        $form = $this->get('form.factory')->create();
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($categorie);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', "La sous-catégorie a bien été supprimé.");
            return $this->redirectToRoute('mika_basecode_homepage');
        }
        $nom = $categorie->getId();
        $nbSousCategories = $em->getRepository('MIKABasecodeBundle:SousCategories')->countArticlesByC($nom);
        return $this->render('@MIKABasecode/Site/supprimerCategorie.html.twig', array(
            'categorie' => $categorie,
            'nbSousCategories' => $nbSousCategories,
            'form'   => $form->createView(),
        ));
    }
}