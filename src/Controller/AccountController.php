<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ResetPasswordType;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @IsGranted("ROLE_USER")
 */

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="app_account")
     */
    public function index(LoggerInterface $logger)
    {
        $logger->debug('Checking account page for '.$this->getUser()->getEmail());
        //dd($this->getUser());

        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
            'user' => $this->getUser()
        ]);
    }


    /**
     * @Route("/reset_password", name="app_reset_password_user")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
     */
    public function resetPasswordAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $em = $this->getDoctrine()->getManager();
        $connect_user = $this->getUser();
        $user = $connect_user;

        $form = $this->createForm(ResetPasswordType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

                $user->setPassword($passwordEncoder->encodePassword(
                    $user,
                    $user->getPassword()
                ));

                $em->persist($user);
                $em->flush();

                $this->addFlash('success', 'Votre mot de passe à bien été changé !');

            return $this->redirectToRoute('app_homepage');

        }

        return $this->render('account/resetpassword.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/reset_password/{id}", name="app_reset_password")
     * @param Request $request
     * @param User|null $userslug
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
     */
    public function resetPasswordAdminAction(Request $request, ?User $userslug, UserPasswordEncoderInterface $passwordEncoder)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $userslug;
        $form = $this->createForm(ResetPasswordType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword($passwordEncoder->encodePassword(
                $user,
                $user->getPassword()
            ));

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Votre mot de passe à bien été changé !');

            return $this->redirectToRoute('app_list_user');

        }

        return $this->render('account/resetpassword.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }
}
