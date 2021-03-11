<?php

namespace App\Controller;

use App\Entity\Kraken;
use App\Entity\Tentacle;
use App\Entity\KrakenPower;
use App\Service\Utils;
use App\Service\TentacleService;
use App\Form\Type\KrakenType;
use App\Form\Type\TentacleType;
use App\Repository\KrakenRepository;
use App\Repository\PowerRepository;
use App\Repository\TentacleRepository;
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
     * @param Request $request
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

        $res = $kraken->toArray();
        $res["powers"] = $this->krakenService->getPowers($kraken);
        return $this->utils->getJsonResponse(["Message" => "Everything ok", "kraken" => $res], Response::HTTP_OK);
    }


    /**
     * Endpoint to add kraken tentacle
     *
     * @param int $id Kraken id
     *
     * @param Request $request
     *
     * @param KrakenRepository $krakenRepository
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
                $kraken->addTentacle($tentacle);
                $this->tentacleService->initTentacle($tentacle);
                $this->entityManager->persist($tentacle);
                $this->entityManager->flush();
            } else {
                return $this->utils->getJsonResponse(["Errors" => "Not allowed to add new tentacle to this kraken"], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return $this->utils->getJsonResponse(["Errors" => $this->utils->getFormErrors($form)], Response::HTTP_BAD_REQUEST);
        }

        $res = $kraken->toArray();
        $res["powers"] = $this->krakenService->getPowers($kraken);
        return $this->utils->getJsonResponse(["Message" => "Everything ok", "kraken" => $res], Response::HTTP_OK);
    }

    /**
     * Endpoint to remove kraken tentacle
     *
     * @param int $id Tentacle id to remove
     *
     * @param TentacleRepository $tentacleRepository
     *
     * @Route("/kraken/{id}/tentacle", name="remove_kraken_tentacle", methods={"DELETE"})
     *
     */
    public function removeKrakenTentacle(int $id, TentacleRepository $tentacleRepository)
    {
        $tentacle = $tentacleRepository->find($id);
        if ($tentacle) {
            $this->entityManager->remove($tentacle);
            $this->entityManager->flush();

            $kraken =  $tentacle->getKraken();
            $res =  $kraken->toArray();
            $res["powers"] = $this->krakenService->getPowers($kraken);
            return $this->utils->getJsonResponse(["Message" => "Everything ok", "kraken" => $res], Response::HTTP_OK);
        }
        return $this->utils->getJsonResponse(["Errors" => "Tentacle not found"], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Endpoint for add power to kraken
     *
     * @param int $kraken_id Kraken's id to add power
     *
     * @param int $power_id Power's id to add
     *
     * @Route("/kraken/{kraken_id}/power/{power_id}", name="add_kraker_power", methods={"POST"})
     */
    public function addPower(int $kraken_id, int $power_id, KrakenRepository $krakenRepository)
    {
        $kraken = $krakenRepository->find($kraken_id);
        if ($this->krakenService->canAddKrakenPower($kraken)) {
            $kraken_power = $this->krakenService->createKrakenPower($kraken, $power_id);
            $this->entityManager->persist($kraken_power);
            $this->entityManager->flush();

            $kraken =  $kraken_power->getKraken();
            $res =  $kraken->toArray();
            $res["powers"] = $this->krakenService->getPowers($kraken);
            return $this->utils->getJsonResponse(["Message" => "Everything ok", "kraken" => $res], Response::HTTP_OK);
        }
        return $this->utils->getJsonResponse(["Errors" => "Not authorized to add power"], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Endpoint for kraken details
     *
     * @param int $id Kraken's id
     *
     * @param Request $request
     *
     * @Route("/kraken/{id}", name="get_kraken_details", methods={"GET"})
     */
    public function getKrakenDetails(int $id)
    {
        $krakenDetails = $this->krakenService->getKrakenDetails($id);
        return $this->utils->getJsonResponse($krakenDetails, Response::HTTP_OK);
    }

    /**
     * Endpoint to get powers
     *
     * @param PowerRepository
     *
     * @Route("/powers", name="get_powers", methods={"GET"})
     */
    public function getPowers(PowerRepository $powerRepository)
    {
        $powers = $powerRepository->findAll();
        $result = [];
        foreach ($powers as $power) {
            $result[] = $power->toArray();
        }
        return $this->utils->getJsonResponse($result, Response::HTTP_OK);
    }
}
