<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Category;
use App\Entity\Item;

class ItemController extends AbstractFOSRestController
{
    private function returnNormalized($param)
    {
        $encoders = [new JsonEncoder];
        $normalizers = [new ObjectNormalizer];
        $serializer = new Serializer($normalizers, $encoders);

        return $serializer->serialize($param, 'json');
    }

    private function getItemById(Request $request)
    {
        return $this->getDoctrine()
                ->getRepository('App\Entity\Item')
                ->find($request->get('id'));
    }

    /**
     * @Rest\Post("/items")
     * @param Request $request
     * @return View
     */
    public function postItem(Request $request, ValidatorInterface $validator): View
    {
        $item = new Item;
        $item
            ->setName($request->get('name'))
            ->setValue($request->get('value'))
            ->setQuality($request->get('quality'));

        $errors = $validator->validate($item);
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                return View::create($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($item);
        $em->flush();

        return View::create($this->returnNormalized($item), Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/items/{id}")
     * @param Request $request
     * @return View
     */
    public function getItem(Request $request): View
    {
        $item = $this->getItemById($request);
        return View::create($this->returnNormalized($item), Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/items")
     * @return View
     */
    public function getItems(): View
    {
        $items = $this->getDoctrine()
            ->getRepository('App\Entity\Item')
            ->findAll();

        return View::create($this->returnNormalized($items), Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/items/{id}")
     * @param Request $request
     * @return View
     */
    public function putItem(Request $request): View
    {
        $item = $this->getItemById($request);

        if ($item) {
            $item
            ->setName($request->get('name'))
            ->setValue($request->get('value'))
            ->setQuality($request->get('quality'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();
        }

        return View::create($this->returnNormalized($item), Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/items/{id}")
     * @param Request $request
     * @return View
     */
    public function deleteItem(Request $request)
    {
        $item = $this->getItemById($request);

        if ($item) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($item);
            $em->flush();
        }

        return View::create($this->returnNormalized($item), Response::HTTP_OK);
    }
}
