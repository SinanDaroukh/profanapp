<?php

namespace App\Controller;

use App\Entity\Log;
use App\Form\QuantityMediumType;
use App\Repository\MediumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/medium/list", name="app_medium_list")
     * @Route("/admin/medium", name="app_medium_admin")
     * @param PaginatorInterface $paginator
     * @param MediumRepository $repo
     * @param Request $request
     * @return Response
     */
    public function index(PaginatorInterface $paginator, MediumRepository $repo, Request $request)
    {

        $search= new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        $medium = $paginator->paginate(
            $repo->findAllQuery($search),
            $request->query->getInt('page',1),
            12
        );

        if ( preg_match("/^\/admin\/medium/", $request->getRequestUri()) and ( array_key_exists('ROLE_DATA_ADMIN',array_flip($this->getUser()->getRoles())) or array_key_exists('ROLE_ADMIN',array_flip($this->getUser()->getRoles())))){
            return $this->render('medium/admin.html.twig', [
                'mediums' => $medium,
                'formSearch' => $form->createView()
            ]);
        }
        else {

            return $this->render('medium/index.html.twig', [
                'formSearch' => $form->createView(),
                'mediums' => $medium
            ]);
        }

    }

    /**
     * @Route("/medium/view/{id}", name="app_medium_view")
     *
     * @param Medium $medium
     * @return Response
     */
    public function viewUser(Medium $medium){
        return $this->render('medium/view.html.twig', [
            'medium' => $medium
        ]);
    }
    /**
     * @Route("/medium/create", name="app_medium_create")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function create(EntityManagerInterface $entityManager, Request $request){

        $form = $this->createForm(MediumType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            /** @var Medium $medium */
            $medium = $form->getData();
            $user = $this->getUser();
            $entityManager->persist($medium);

            $log = new Log($user->getId(), $medium->getId(), $medium->getNom(), $user->getFirstname(), $medium->getQuantity(), 'success');
            $entityManager->persist($log);
            $entityManager->flush();

            $this->addFlash('success','Medium successfully created ! Well done, Agent Polly !');

            return $this->redirectToRoute('app_medium_admin');
        }

        return $this->render('medium/create.html.twig', [
            'createMediumForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/medium/delete/{id}", name="app_medium_delete")
     * @param medium $medium
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse
     */
    public function delete(medium $medium, EntityManagerInterface $entityManager){

        $user = $this->getUser();
        $log = new Log($user->getId(), $medium->getId(), $medium->getNom(), $user->getFirstname(), $medium->getQuantity(), 'danger');
        $entityManager->persist($log);
        $entityManager->remove($medium);
        $entityManager->flush();

        $this->addFlash('success','The medium named ' . $medium->getNom() . ' has been deleted ! Congrats, Agent Nick !');

        return $this->redirectToRoute('app_medium_admin');
    }

    /**
     * @Route("/medium/edit/{id}", name="app_medium_edit")
     * @param Medium $medium
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function edit(Medium $medium, EntityManagerInterface $entityManager, Request $request){

        $form = $this->createForm(MediumType::class, $medium);
        $user = $this->getUser();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $medium = $form->getData();

            $log = new Log($user->getId(), $medium->getId(), $medium->getNom(), $user->getFirstname(), $medium->getQuantity(), 'secondary');
            $entityManager->persist($log);
            $entityManager->persist($medium);
            $entityManager->flush();

            $this->addFlash('success','Medium successfully updated ! Well done, Agent Molly !');

            return $this->redirectToRoute('app_medium_admin');
        }

        return $this->render('medium/edit.html.twig', [
            'editMediumForm' => $form->createView(),
            'medium' => $medium,
        ]);

    }

    /**
     * @Route("/medium/edit/quantity/{id}", name="app_medium_edit_quantity")
     * @param Medium $medium
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function editQuantity(Medium $medium, EntityManagerInterface $entityManager, Request $request){

        $form = $this->createForm(QuantityMediumType::class, $medium);
        $user = $this->getUser();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $medium = $form->getData();

            if ( $medium->getQuantity() >= 0 ){

                $log = new Log($user->getId(), $medium->getId(), $medium->getNom(), $user->getFirstname(), $medium->getQuantity(), 'secondary');
                $entityManager->persist($log);
                $entityManager->persist($medium);
                $entityManager->flush();

                $this->addFlash('success','Medium successfully updated ! Well done, Agent Molly !');

                return $this->redirectToRoute('app_medium_list');
            }
            else {
                $this->addFlash('warning', 'Quantité non valide');
            }
        }

        return $this->render('medium/edit_quantity.html.twig', [
            'editMediumForm' => $form->createView(),
            'medium' => $medium,
        ]);

    }


}
