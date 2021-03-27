<?php


namespace App\Controller;


use App\Service\FileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends AbstractController
{

    /**
     * @Route("/", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('index.html.twig', []);
    }

    /**
     * @Route("/task1", methods={"GET"})
     * @param FileService $fileService
     * @return Response
     */
    public function task1(FileService $fileService): Response
    {
        $fileService->handle();
        return $this->render('task1.html.twig', []);
    }
}