<?php

namespace App\Controller;

use App\Entity\Kraken;

use App\Service\Utils;
use App\Service\TentacleService;
use App\Form\Type\KrakenType;
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

    public function __construct(EntityManagerInterface $entityManager, Utils $utils, TentacleService $tentacleService)
    {
        $this->entityManager = $entityManager;
        $this->utils = $utils;
        $this->tentacleService = $tentacleService;
    }


    /**
     * Endpoint to create kraken
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
}
