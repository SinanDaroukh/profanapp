<?php
/**
 * Created by PhpStorm.
 * User: arwoon_shlaka
 * Date: 06/04/19
 * Time: 12:39
 */

namespace App\Controller;

use App\Repository\LogRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="app_portalpage")
     */
    public function portalpage()
    {
        return $this->render('base.html.twig', [
            'last_username'     => null,
            'error'         =>  null
        ]);
    }


    /**
     * @Route("/home", name="app_homepage")
     * @param LogRepository $logRepository
     * @return Response
     */
    public function homepage(LogRepository $logRepository){

        $log = $logRepository->findFiveMoreRecent();

        return $this->render('home.html.twig', [
            'logs' => $log
        ]);

    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/log", name="app_log")
     * @param LogRepository $logRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function log(LogRepository $logRepository,  PaginatorInterface $paginator, Request $request ){

        $log = $paginator->paginate(
            $logRepository->findAllQuery(),
            $request->query->getInt('page',1),
            25
        );

        return $this->render('/admin/log.html.twig', [
            'logs' => $log
        ]);

    }
}