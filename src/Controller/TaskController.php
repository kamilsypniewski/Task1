<?php

namespace App\Controller;

use App\Service\FileService;
use App\Service\ValidationService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/validation/pesel", name="api_validation_pesel", methods={"POST"})
     * @param Request $request
     * @param LoggerInterface $logger
     * @param ValidationService $validationService
     * @return JsonResponse
     */
    public function validationPesel(Request $request, LoggerInterface $logger, ValidationService $validationService): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
            if (null === $data) {
                throw new \InvalidArgumentException('error.bad_request.incorrect_json');
            }

            if (empty($data) || !isset($data['pesel'])) {
                throw new \InvalidArgumentException('error.bad_request.required_parameters_not_set');
            }

            $validationService->handle($data['pesel']);

            return new JsonResponse(
                ['ok'],
                Response::HTTP_OK
            );

        } catch (\Exception $exception) {
            $logger->error('Message: ' . $exception->getMessage() . ' Stack: ' . $exception->getTraceAsString());
            $code = $exception->getCode();
            if (!isset($code) || (int)$code === 0) {
                $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            }

            return new JsonResponse(
                ['error' => $exception->getMessage()],
                $code
            );
        }
    }
}