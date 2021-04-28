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

class ItemController extends AbstractFOSRestController
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

    private function getItemById(Request $request)
    {
        return $this->getDoctrine()
                ->getRepository(Item::class)
                ->find($request->get('id'));
    }

    /**
     * @Rest\Post("/items")
     * @param Request $request
     * @return View
     */
    public function postItem(Request $request, ValidatorInterface $validator): View
    {
        $category = $this->getDoctrine()
                ->getRepository(Category::class)
                ->find($request->get('id'));

        $item = new Item;
        $item
            ->setName($request->get('name'))
            ->setValue($request->get('value'))
            ->setQuality($request->get('quality'))
            ->setCategory($category);

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
            ->getRepository(Item::class)
            ->findAll();

        return View::create($this->returnNormalized($items), Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/items/category/{categoryId}")
     * @return View
     */
    public function getItemsByCategoryId(Request $request): View
    {
        $items = $this->getDoctrine()
            ->getRepository(Item::class)
            ->findBy(['category' => $request->get('categoryId')]);

        return View::create($this->returnNormalized($items), Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/items/{id}")
     * @param Request $request
     * @return View
     */
    public function putItem(Request $request, ValidatorInterface $validator): View
    {
        $category = $this->getDoctrine()
                ->getRepository(Category::class)
                ->find($request->get('id'));

        $item = $this->getItemById($request);

        if ($item) {
            $item
                ->setName($request->get('name'))
                ->setValue($request->get('value'))
                ->setQuality($request->get('quality'))
                ->setCategory($category);
            
            $errors = $validator->validate($item);
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    return View::create($error->getMessage(), Response::HTTP_BAD_REQUEST);
                }
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

        } else {
            return View::create('Category does not exist.', Response::HTTP_BAD_REQUEST);
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

    /**
     * @Rest\Delete("/items/category/{categoryId}")
     * @param Request $request
     * @return View
     */
    public function deleteItemByCategory(Request $request)
    {
        $items = $this->getDoctrine()
            ->getRepository(Item::class)
            ->findBy(['category' => $request->get('categoryId')]);

        if ($items) {
            foreach ($items as $item) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($item);
                $em->flush();
            }
        }

        return View::create($this->returnNormalized($items), Response::HTTP_OK);
    }
}
