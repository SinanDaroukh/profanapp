<?php


namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @IsGranted("ROLE_USER_ADMIN")
 */


class UserAdminController extends AbstractController
{
    /**
     * @Route("/admin/create_user", name="app_create_user")
     *
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
     */
    public function createUser(EntityManagerInterface $entityManager, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->createForm(UserFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            /** @var User $user */
           $user = $form->getData();

           $user->setPassword($passwordEncoder->encodePassword(
               $user,
               $user->getPassword()
           ));

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success','User successfully created ! Well done, Agent Polly !');

            return $this->redirectToRoute('app_list_user');
        }

        return $this->render('admin/user/create.html.twig', [
            'createUserForm' => $form->createView()
        ]);

    }

    /**
     * @Route("/admin/edit_user/{id}", name="app_edit_user")
     *
     * @param User $user
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
     */

    public function editUser(User $user, EntityManagerInterface $entityManager, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        /** Retrieving the actual user connected... */
        $actual_user_id = $this->getUser()->getId();

        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            /** @var User $user */
            $user = $form->getData();

            dd($user->getPassword());

            $user->setPassword($passwordEncoder->encodePassword(
                $user,
                $user->getPassword()
            ));

            $entityManager->persist($user);
            $entityManager->flush();


            if ($actual_user_id != $user->getId()){

                $this->addFlash('success','User successfully updated ! Well done, Agent Molly !');
                return $this->redirectToRoute('app_list_user');
            }
            else {
                $this->addFlash('warning','As you modify you own profile, you must reconnect !');
                return $this->redirectToRoute('app_logout');
            }
        }

        return $this->render('admin/user/edit.html.twig', [
            'editUserForm' => $form->createView(),
            'user' => $user,
        ]);

    }


    /**
     * @Route("/admin/view_user/{id}", name="app_view_user")
     *
     * @param User $user
     * @return Response
     */
    public function viewUser(User $user){
        return $this->render('admin/user/view.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/admin/list_user", name="app_list_user")
     *
     * @param UserRepository $userRepository
     * @return Response
     */
    public function listUser(UserRepository $userRepository)
    {
        $userRepository = $userRepository->findAll();

        return $this->render('admin/user/list.html.twig', [
            'users' => $userRepository,
        ]);

    }

    /**
     * @Route("/admin/delete_user/{id}", name="app_delete_user")
     *
     * @param User $user
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function deleteUser(User $user, EntityManagerInterface $entityManager){

        /** Retrieving the actual user connected... */
        $actual_user_id = $this->getUser()->getId();

        if ( $actual_user_id != $user->getId()){
            $entityManager->remove($user);
            $entityManager->flush();

            $this->addFlash('success','The user ' . $user->getFirstName() . ' has been deleted ! Congrats, Agent Nick !');
        }
        else {
            $this->addFlash('error', 'You cannot commit suicide ! Bad luck, Agent Rick !');
        }

        return $this->redirectToRoute('app_list_user');
    }
}