<?php

namespace App\Controller;

use App\Entity\Kraken;
use App\Entity\Tentacle;
use App\Service\Utils;
use App\Service\TentacleService;
use App\Form\Type\KrakenType;
use App\Form\Type\TentacleType;
use App\Repository\KrakenRepository;
use App\Service\KrakenService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends AbstractController
{
    private $entityManager;
    private $utils;
    private $tentacleService;
    private $krakenService;

    public function __construct(EntityManagerInterface $entityManager, Utils $utils, TentacleService $tentacleService, KrakenService $krakenService)
    {
        $this->entityManager = $entityManager;
        $this->utils = $utils;
        $this->tentacleService = $tentacleService;
        $this->krakenService = $krakenService;
    }


    /**
     * Endpoint to create kraken
     * 
     * @param $request
     * 
     * @Route("/kraken", name="create_kraken", methods={"POST"})
     * 
     */
    public function postKraken(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $kraken = new Kraken();
        $form = $this->createForm(KrakenType::class, $kraken);

        $form->submit($data);

        if ($form->isValid()) {
            $this->entityManager->persist($kraken);
            $this->entityManager->flush();
        } else {
            return $this->utils->getJsonResponse($this->utils->getFormErrors($form), Response::HTTP_BAD_REQUEST);
        }

        return $this->utils->getJsonResponse(["Everything ok"], Response::HTTP_OK);
    }


    /**
     * Endpoint to add kraken tentacle
     * 
     * @param $id Kraken id
     * 
     * @param $request
     * 
     * @param $krakenRepository
     * 
     * @Route("/kraken/{id}/tentacle", name="add_kraken_tentacle", methods={"POST"})
     * 
     */
    public function addKrakenTentacle(int $id, Request $request, KrakenRepository $krakenRepository)
    {
        $data = json_decode($request->getContent(), true);
        $tentacle = new Tentacle();
        $form = $this->createForm(TentacleType::class, $tentacle);

        $form->submit($data);

        if ($form->isValid()) {
            $kraken = $krakenRepository->find($id);

            if ($this->krakenService->checkAddTentacle($kraken)) {
                $tentacle->setKraken($kraken);
                $this->tentacleService->initTentacle($tentacle);
                $this->entityManager->persist($tentacle);
                $this->entityManager->flush();
            } else {
                return $this->utils->getJsonResponse("Not allowed to add new tentacle to this kraken", Response::HTTP_BAD_REQUEST);
            }
        } else {
            return $this->utils->getJsonResponse($this->utils->getFormErrors($form), Response::HTTP_BAD_REQUEST);
        }

        return $this->utils->getJsonResponse(["Everything ok"], Response::HTTP_OK);
    }
}
