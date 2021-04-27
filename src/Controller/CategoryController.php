<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

use App\Entity\Category;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CategoryController extends AbstractFOSRestController 
{
    private function returnNormalized($param)
    {
        $encoders = [new JsonEncoder];
        $normalizers = [new ObjectNormalizer];
        $serializer = new Serializer($normalizers, $encoders);

        return $serializer->serialize($param, 'json');
    }

    private function getCategoryById(Request $request)
    {
        return $this->getDoctrine()
                ->getRepository('App\Entity\Category')
                ->find($request->get('id'));
    }

    /**
     * @Rest\Post("/categories")
     * @param Request $request
     * @return View
     */
    public function postCategory(Request $request, ValidatorInterface $validator): View
    {
        $category = new Category;
        $category->setName($request->get('name'));

        $errors = $validator->validate($category);
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                return View::create($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();

        return View::create($this->returnNormalized($category), Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/categories/{id}")
     * @param Request $request
     * @return View
     */
    public function getCategory(Request $request): View
    {
        $category = $this->getCategoryById($request);
        return View::create($this->returnNormalized($category), Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/categories")
     * @return View
     */
    public function getCategories(): View
    {
        $categories = $this->getDoctrine()
            ->getRepository('App\Entity\Category')
            ->findAll();

        return View::create($this->returnNormalized($categories), Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/categories/{id}")
     * @param Request $request
     * @return View
     */
    public function putCategory(Request $request): View
    {
        $category = $this->getCategoryById($request);

        if ($category) {
            $category->setName($request->get('name'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
        }

        return View::create($this->returnNormalized($category), Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/categories/{id}")
     * @param Request $request
     * @return View
     */
    public function deleteCategory(Request $request)
    {
        $category = $this->getCategoryById($request);

        if ($category) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();
        }

        return View::create($this->returnNormalized($category), Response::HTTP_OK);
    }
}