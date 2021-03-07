<?php

namespace App\Service;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

class Utils
{
    /**
     * 
     * Format response to json
     * 
     * @param array $data
     * 
     * @return Response
     * 
     */
    public function getJsonResponse($data, $status): Response
    {

        $response = new Response();
        $response->setContent(json_encode($data));
        $response->setStatusCode($status);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


    public function getFormErrors(Form $form)
    {
        foreach ($form->getErrors(true, false) as $error) {
            $errors[] = $error->__toString();
        }
        return $errors;
    }
}
