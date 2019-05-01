<?php

namespace App\Controller;

use App\Entity\Support;
use App\Form\SupportType;
use App\Repository\SupportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SupportController extends AbstractController
{
    /**
     * @Route("/support", name="app_support")
     * @Route("/support/list", name="app_support_list")
     * @param SupportRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(SupportRepository $repository, PaginatorInterface $paginator ,Request $request )
    {
        $supports = $paginator->paginate(
            $repository->findAllQuery(),
            $request->query->getInt('page',1),
            12
        );
        return $this->render('support/index.html.twig', [
            'supports' => $supports,
        ]);
    }

    /**
     * @Route("/support/view/{id}", name="app_support_view")
     *
     * @param Support $support
     * @return Response
     */
    public function viewUser(Support $support){
        return $this->render('support/view.html.twig', [
            'support' => $support
        ]);
    }


    /**
     * @Route("/support/create", name="app_support_create")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function create(EntityManagerInterface $entityManager, Request $request){

        $form = $this->createForm(SupportType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            /** @var Support $support */
            $support = $form->getData();

            $entityManager->persist($support);
            $entityManager->flush();

            $this->addFlash('success','Support successfully created ! Well done, Agent Polly !');

            return $this->redirectToRoute('app_support');
        }

        return $this->render('support/create.html.twig', [
            'createSupportForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/support/delete/{id}", name="app_support_delete")
     * @param Support $support
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse
     */
    public function delete(Support $support, EntityManagerInterface $entityManager){

        $entityManager->remove($support);
        $entityManager->flush();

        $this->addFlash('success','The support named ' . $support->getName() . ' has been deleted ! Congrats, Agent Nick !');

        return $this->redirectToRoute('app_support');
    }

    /**
     * @Route("/support/edit/{id}", name="app_support_edit")
     * @param Support $support
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function edit(Support $support, EntityManagerInterface $entityManager, Request $request){

        $form = $this->createForm(SupportType::class, $support);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $support = $form->getData();

            $entityManager->persist($support);
            $entityManager->flush();

            $this->addFlash('success','Support successfully updated ! Well done, Agent Molly !');

            return $this->redirectToRoute('app_support');
        }

        return $this->render('support/edit.html.twig', [
            'editSupportForm' => $form->createView(),
            'support' => $support,
        ]);

    }
}
