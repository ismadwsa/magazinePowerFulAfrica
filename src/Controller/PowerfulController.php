<?php

namespace App\Controller;

use App\Entity\AncienMagazine;
use App\Entity\Article;
use App\Entity\Magazine;
use App\Entity\NewsLetter;
use App\Entity\PubliciteHeader;
use App\Entity\User;
use App\Repository\AncienMagazineRepository;
use App\Repository\ArticleRepository;
use App\Repository\MagazineRepository;
use App\Repository\NewsLetterRepository;
use App\Repository\PubliciteHeaderRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PowerfulController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(
        PubliciteHeaderRepository $pubRepo,
        ArticleRepository $articleRepo,
        AncienMagazineRepository $ancienMagazineRepo,
        MagazineRepository $magazineRepo
    ): Response {
        $pubone = $pubRepo->findAll();
        $art = $articleRepo->findAll();
        $magazine = $magazineRepo->findAll();
        $ancienMag = $ancienMagazineRepo->findAll();
        return $this->render('accueil/accueil.html.twig', [
            'maPub' => $pubone, 'mesArticles' => $art,
            'ancienMagazine' => $ancienMag, 'magazine' => $magazine
        ]);
    }
    /**
     * @Route("/deco", name="deco")
     */
    public function deco(): Response
    {
        return $this->redirectToRoute('admin');
    }
    /**
     * @Route("/apropos", name="apropos")
     */
    public function apropos(): Response
    {
        return $this->render('a_propos/apropos.html.twig');
    }
    /**
     * @Route("/aproposFR", name="aproposFR")
     */
    public function aproposFR(): Response
    {
        return $this->render('a_propos/aproposFR.html.twig');
    }
    /**
     * @Route("/adresseMails", name="adresseMails")
     */
    public function findMail(NewsLetterRepository $mailsRepo): Response
    {
        $adresseMails = $mailsRepo->findAll();

        return $this->render('clients/adressesMails.html.twig', [
            'mesAdressesMails' => $adresseMails,
        ]);
    }
    /**
     * @Route("/users/{id}/user", name="user")
     */
    public function user($id, UserRepository $userRepo): Response
    {
        $user = $userRepo->find($id);
        return $this->render('espaceAdmin/users.html.twig', [
            'connectedUser' => $user
        ]);
    }
    /**
     * @Route("/manager", name="admin")
     */
    public function login(Request $request, UserRepository $userRepo): Response
    {
        $allUsers = $userRepo->findAll();
        foreach ($allUsers as $user) {
            if (
                $user->getEmail() == $request->request->get('email') &&
                $request->request->count() > 0  &&
                $user->getPassword() == $request->request->get('password')
            ) {
                return $this->redirectToRoute('espaceAdmin', ['id' => $user->getId()]);
            }
        }
        if ($request->request->count() == 0)
            return $this->render('login/login.html.twig', [
                'email' => $request->request->get('email')
            ]);

        else return $this->render('login/erreur.html.twig', [
            'email' => $request->request->get('email')
        ]);
    }
    /**
     * @Route("/manager/{id}/accueil", name="espaceAdmin")
     */
    public function AcAdmin(
        $id,
        UserRepository $userRepo,
        PubliciteHeaderRepository $pubRepo,
        ArticleRepository $articleRepo,
        MagazineRepository $magazineRepo,
        AncienMagazineRepository $ancienMagazineRepo
    ): Response {
        $pubone = $pubRepo->findAll();
        $user = $userRepo->find($id);
        $art = $articleRepo->findAll();
        $magazine = $magazineRepo->findAll();
        $ancienMagazine = $ancienMagazineRepo->findAll();
        return $this->render('espaceAdmin/accueilAdmin.html.twig', [
            'connectedUser' => $user, 'maPub' => $pubone, 'mesArticles' => $art, 'magazine' => $magazine,
            'ancienMagazine' => $ancienMagazine
        ]);
    }
    /**
     * @Route("/updateUser/{id}", name="updateUser")
     */
    public function updateUser(Request $request, User $useree): Response
    {
        $manager = $this->getDoctrine()->getManager();
        if ($request->request->count() == 0) {
            return $this->render('espaceAdmin/updateUser.html.twig', [
                'myUser' => $useree
            ]);
        } else {
            $useree->setNom($request->request->get('nom'));
            $useree->setPrenom($request->request->get('prenom'));
            $useree->setEmail($request->request->get('email'));
            $useree->setPassword($request->request->get('password'));
            $manager->persist($useree);
            $manager->flush();
            return $this->redirectToRoute('user', ['id' => $useree->getId()]);
        }
    }
    /**
     * @Route("/deletePub/{id}", name="deletePub")
     */
    public function deletePub(PubliciteHeader $pub): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($pub);
        $manager->flush();
        return $this->redirectToRoute('espaceAdmin', ['id' => $pub->getUser()->getId()]);
    }
    /**
     * @Route("/deleteAncienMagazine/{id}", name="deleteAncienMagazine")
     */
    public function deleteAncienMagazine(AncienMagazine $mag): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($mag);
        $manager->flush();
        return $this->redirectToRoute('espaceAdmin', ['id' => $mag->getUser()->getId()]);
    }
    /**
     * @Route("/deleteArticle/{id}", name="deleteArticle")
     */
    public function deleteArticle(Article $article): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($article);
        $manager->flush();
        return $this->redirectToRoute('espaceAdmin', ['id' => $article->getUser()->getId()]);
    }
    /**
     * @Route("/newsletter", name="newsLetter" )
     */
    public function newsLetter(Request $request, NewsLetterRepository $clientRepo): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $clients = $clientRepo->findAll();
        foreach ($clients as $user)
            if (!empty($_POST['adresseMail']) && $request->request->get('adresseMail') != $user->getAdresseMail()) {
                $newsLetter = new NewsLetter();
                $newsLetter->setAdresseMail($request->request->get('adresseMail'));
                $manager->persist($newsLetter);
                $manager->flush();
                return $this->render('accueil/bienvenue.html.twig');
            } else {
                return $this->redirectToRoute('accueil');
            }
    }
    /**
     * @Route("updateArticle/{id}", name="updateArticle")
     *
     */
    public function modifArticle(Request $request, Article $article = null): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder($article)
            ->add('image', FileType::class, [
                'attr' =>
                [
                    'placeholder' => "Image :",
                    'requierd' => false
                ]
            ])
            ->add('titre', TextType::class, [
                'attr' =>
                [
                    'placeholder' => "Tittre :"
                ]
            ])
            ->add(
                'datePublication',
                TextType::class,
                [
                    'attr' =>
                    [
                        'placeholder' => "date de Publication :"
                    ]
                ]
            )
            ->add(
                'contenu',
                TextType::class,
                [
                    'attr' =>
                    [
                        'placeholder' => "Contenu :"
                    ]
                ]
            )
            ->getForm();
        if ($request->request->count() == 0) {
            return $this->render('espaceAdmin/updateArticle.html.twig', [
                'mesArticle' => $article,
                'formArticle' => $form->createView()
            ]);
        } else {
            $form->handleRequest($request);
            $manager->persist($article);
            $manager->flush();
            return $this->redirectToRoute('espaceAdmin', ['id' => $article->getUser()->getId()]);
        }
    }
    //modification publicité principale

    /**
     * @Route("updatePub/{id}", name="updatePub")
     *
     */
    public function updatePuble(Request $request, PubliciteHeader $pub = null): Response
    {
        $manager = $this->getDoctrine()->getManager();
    // Création des formulaire coté controller
        $form = $this->createFormBuilder($pub)
            ->add('image', FileType::class, [
                'attr' => [
                    'placeholder' => "Image :",
                    'requierd' => false
                ]
            ])
            ->getForm();
        if ($request->request->count() == 0) {
            return $this->render('espaceAdmin/updatePubl.html.twig', [
                'mesPub' => $pub,
                'formPub' => $form->createView()
            ]);
        } else {
            $form->handleRequest($request);
            $manager->persist($pub);
            $manager->flush();
            return $this->redirectToRoute('espaceAdmin', ['id' => $pub->getUser()->getId()]);
        }
    }
    /**
     * @Route("manager/{id}/newArticle", name="newArticle")
     *
     */
    public function newArt(Request $request, Article $article = null, UserRepository $userRepo, $id): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $user = $userRepo->find($id);

        // Création des formulaire coté controller
        $article = new Article;
        $form = $this->createFormBuilder($article)
            ->add('image', FileType::class, [
                'attr' => [
                    'placeholder' => "Image :",
                    'requierd' => false
                ]
            ])
            ->add('titre', TextType::class, [
                'attr' => [
                    'placeholder' => "Tittre :"
                ]
            ])
            ->add(
                'contenu',
                TextType::class,
                [
                    'attr' => [
                        'placeholder' => "Contenu :"
                    ]
                ]
            )
            ->add(
                'datePublication',
                TextType::class,
                [
                    'attr' => [
                        'placeholder' => "date de Publication :"
                    ]
                ]
            )

            ->getForm();
        if ($request->request->count() == 0) {
            return $this->render('espaceAdmin/newArticle.html.twig', [
                'mesArticle' => $article,
                'formArticle' => $form->createView()
            ]);
        } else {
            $form->handleRequest($request);
            $article->setUser($user)->setUpdatedAt(new \DateTime());
            $manager->persist($article);
            $manager->flush();
            return $this->redirectToRoute('espaceAdmin', ['id' => $article->getUser()->getId()]);
        }
    }
    /**
     * @Route("updateMagazine/{id}", name="updateMagazine")
     *
     */
    public function newMaganzinz(Request $request, Magazine $magazine = null): Response
    {
        $manager = $this->getDoctrine()->getManager();
        // Création des formulaire coté controller
        $form = $this->createFormBuilder($magazine)
            ->add('image', FileType::class, [
                'attr' => [
                    'placeholder' => "Image du magazine :",
                    'requierd' => false
                ]
            ])
            ->add('titre', TextType::class, [
                'attr' => [
                    'placeholder' => "Tittre  :"
                ]
            ])
            ->add(
                'datePublication',
                TextType::class,
                [
                    'attr' => [
                        'placeholder' => "date de Publication :"
                    ]
                ]
            )
            ->getForm();
        if ($request->request->count() == 0) {
            return $this->render('espaceAdmin/updateMagazine.html.twig', [
                'magazine' => $magazine,
                'formMagazine' => $form->createView()
            ]);
        } else {
            $form->handleRequest($request);
            $manager->persist($magazine);
            $manager->flush();
            return $this->redirectToRoute('espaceAdmin', ['id' => $magazine->getUser()->getId()]);
        }
    }
    /**
     * @Route("manager/{id}/ancienMag", name="ancienMag")
     *
     */
    public function ancienMag(Request $request, AncienMagazine $ancienMag = null, UserRepository $userRepo, $id): Response
    {

        $manager = $this->getDoctrine()->getManager();
        $user = $userRepo->find($id);

        // Création des formulaire coté controller
        $ancienMag = new AncienMagazine();

        $form = $this->createFormBuilder($ancienMag)

            ->add('image', FileType::class, [
                'attr' => [
                    'placeholder' => "Image de l'ancien Magazine :",
                    'requierd' => false
                ]
            ])
            ->getForm();

        if ($request->request->count() == 0) {
            return $this->render('espaceAdmin/ancienMag.html.twig', [
                'mesancienMag' => $ancienMag,
                'formAncienMag' => $form->createView()
            ]);
        } else {


            $form->handleRequest($request);
            $ancienMag->setUser($user)->setUpdatedAt(new \DateTime());
            $manager->persist($ancienMag);
            $manager->flush();

            return $this->redirectToRoute('espaceAdmin', ['id' => $ancienMag->getUser()->getId()]);
        }
    }

    /**
     * @Route("/manager/{id}/newPub", name="newPub")
     */
    public function newPub(Request $request, PubliciteHeader $newPub = null, UserRepository $userRepo, $id): Response
    {

        $manager = $this->getDoctrine()->getManager();
        $user = $userRepo->find($id);

        // Création des formulaire coté controller
        $newPub = new PubliciteHeader();

        $form = $this->createFormBuilder($newPub)

            ->add('image', FileType::class, [
                'attr' => [
                    'placeholder' => "Image de la nouvelle Publicité :",
                    'requierd' => false
                ]
            ])
            ->getForm();

        if ($request->request->count() == 0) {
            return $this->render('espaceAdmin/newPub.html.twig', [
                'newPub' => $newPub,
                'formNewPub' => $form->createView()
            ]);
        } else {
            $form->handleRequest($request);
            $newPub->setUser($user)->setUpdatedAt(new \DateTime());
            $manager->persist($newPub);
            $manager->flush();

            return $this->redirectToRoute('espaceAdmin', ['id' => $newPub->getUser()->getId()]);
        }
    }
}
