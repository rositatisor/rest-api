<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Category;
use App\Entity\Item;

class CategoryController extends AbstractFOSRestController 
{
    private function returnNormalized($param)
    {
        $encoder = [new JsonEncoder()];
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getName();
            },
        ];
        $normalizer = [new ObjectNormalizer(null, null, null, null, null, null, $defaultContext)];

        $serializer = new Serializer($normalizer, $encoder);

        return $serializer->serialize($param, 'json');
    }

    private function getCategoryById(Request $request)
    {
        return $this->getDoctrine()
                ->getRepository(Category::class)
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
            ->getRepository(Category::class)
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