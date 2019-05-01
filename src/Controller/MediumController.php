<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Medium;
use App\Entity\Search;
use App\Form\SearchType;
use App\Form\MediumType;

class MediumController extends AbstractController
{
    /**
     * @Route("/medium", name="medium")
     */
    public function index(Search $search=null, Request $request)
    {
        if (!$search){
            $search= new Search();
        }
        $query = $this->createForm(SearchType::class, $search);

        $query->handleRequest($request);

        $repo = $this->getDoctrine()->getRepository(Medium::class);

        if ($query->isSubmitted() && $query->isValid()) {
            $medium = $repo->findBy([
                'nom' => $search->getRecherche()
            ]);
        }
        else{
            $medium = $repo->findAll();
        }

        return $this->render('medium/index.html.twig', [
            'formSearch' => $query->createView(),
            'medium' => $medium
        ]);
    }


    /**
     * @Route("/medium/add",name="form_add")
     * @Route("/medium/{id}/edit",name="form_edit")
     *
     * @param Medium $medium
     * @param Request $request
     * @param ObjectManager $manager
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function form_add (Medium $medium=null, Request $request, ObjectManager $manager)
    {
        if (!$medium) {
            /*Si le medium en argument est vide*/
            /*Il faut en créer un nouveau*/
            $medium = new Medium();
        }

        $form = $this->createForm(MediumType::class, $medium);/*Création du formulaire*/

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) /*Si formulaire est valide et envoyé, on l'intègre à la database*/ {
            $manager->persist($medium);
            $manager->flush();

            return $this->redirectToRoute('medium');
        }

        return $this->render('medium/form.html.twig', [
            'formMedium' => $form->createView(),
            'form' => 'add',
            'editMode' => $medium->getId()!== null
        ]);
    }

    /**
     * @Route("/medium/{id}/delete",name="form_suppr")
     *
     * @param Medium $medium
     * @param Request $request
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
        public function form_suppr (Medium $medium, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(MediumType::class, $medium);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $medium->getId()) {

            $manager->remove($medium);
            $manager->flush();

            return $this->redirectToRoute('medium');
        }

        return $this->render('medium/form.html.twig', [
            'formMedium' => $form->createView(),
            'form' => 'suppr'
        ]);
    }


}
