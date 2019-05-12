<?php

namespace App\Controller;

use App\Entity\Log;
use App\Entity\Support;
use App\Entity\SupportSearch;
use App\Form\QuantitySupportType;
use App\Form\SupportSearchType;
use App\Form\SupportType;
use App\Repository\SupportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class  SupportController extends AbstractController
{
    /**
     * @Route("/support", name="app_support")
     * @Route("/support/list", name="app_support_list")
     * @Route("/admin/support", name="app_support_admin")
     * @param SupportRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(SupportRepository $repository, PaginatorInterface $paginator , Request $request )
    {
        $search = new SupportSearch();
        $form = $this->createForm(SupportSearchType::class, $search);
        $form->handleRequest($request);

        $supports = $paginator->paginate(
            $repository->findAllQuery($search),
            $request->query->getInt('page',1),
            12
        );

        if ( $request->getRequestUri() == "/admin/support" and ( array_key_exists('ROLE_DATA_ADMIN',array_flip($this->getUser()->getRoles())) or array_key_exists('ROLE_ADMIN',array_flip($this->getUser()->getRoles())))){
            return $this->render('support/admin.html.twig', [
                'supports' => $supports,
                'form' => $form->createView()
            ]);
        }
        else {
            return $this->render('support/index.html.twig', [
                'supports' => $supports,
                'form' => $form->createView()
            ]);
        }
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
     * @param SupportRepository $supportRepository
     * @return RedirectResponse|Response
     */
    public function create(EntityManagerInterface $entityManager, Request $request){

        $form = $this->createForm(SupportType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            /** @var Support $support */
            $support = $form->getData();
            $user = $this->getUser();
            $entityManager->persist($support);

            $log = new Log($user->getId(), $support->getId(), $support->getName(), $user->getFirstname(), $support->getQuantity(), 'success');
            $entityManager->persist($log);
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

        $user = $this->getUser();
        $log = new Log($user->getId(), $support->getId(), $support->getName(), $user->getFirstname(), $support->getQuantity(), 'danger');
        $entityManager->persist($log);
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
        $user = $this->getUser();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $support = $form->getData();

            $log = new Log($user->getId(), $support->getId(), $support->getName(), $user->getFirstname(), $support->getQuantity(), 'secondary');
            $entityManager->persist($log);
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

    /**
     * @Route("/support/edit/quantity/{id}", name="app_support_edit_quantity")
     * @param Support $support
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function editQuantity(Support $support, EntityManagerInterface $entityManager, Request $request){

        $form = $this->createForm(QuantitySupportType::class, $support);
        $user = $this->getUser();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $support = $form->getData();

            if ( $support->getQuantity() >= 0 ){

                $log = new Log($user->getId(), $support->getId(), $support->getName(), $user->getFirstname(), $support->getQuantity(), 'secondary');
                $entityManager->persist($log);
                $entityManager->persist($support);
                $entityManager->flush();

                $this->addFlash('success','Support successfully updated ! Well done, Agent Molly !');

                return $this->redirectToRoute('app_support');
            }
            else {
                $this->addFlash('warning', 'Quantité non valide');
            }
        }

        return $this->render('support/edit_quantity.html.twig', [
            'editSupportForm' => $form->createView(),
            'support' => $support,
        ]);

    }
}
