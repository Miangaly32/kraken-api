<?php

namespace App\Service;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;

class Utils
{
    /**
     * 
     * Format response to json
     * 
     * @param array $data
     * 
     * @param int $status
     * 
     * @return JsonResponse
     * 
     */
    public function getJsonResponse($data, $status): JsonResponse
    {
        return new JsonResponse($data, $status);
    }


    public function getFormErrors(Form $form)
    {
        foreach ($form->getErrors(true, false) as $error) {
            $errors[] = $error->__toString();
        }
        return $errors;
    }
}
