<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method User getUser()
 */
abstract class BaseController extends AbstractController
{
    protected function processForm(Request $request, FormInterface $form)
    {
        $data = $request->request->all();

        if ($data === null) {
            $apiProblem = array('Error on API parameters', 400);
            throw new NotFoundHttpException($apiProblem);
        }


        $clearMissing = $request->getMethod() != 'PATCH';
        $form->submit($data, $clearMissing);
    }
}
