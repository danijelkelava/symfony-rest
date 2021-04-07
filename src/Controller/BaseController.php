<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BaseController extends AbstractController
{
    /**
     * @var SerializerInterface
     */
    public $serializer;

    /**
     * @var ValidatorInterface
     */
    public $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * Extracts request body data and decodes it into array
     * Throws BadRequestHttpException in case of invalid request body or missing parameter
     *
     * @param array $requiredFields
     * @param string $json
     * @throws BadRequestHttpException
     * @return string
     */
    public function validateJson(array $requiredKeys, string $json): string
    {
        //$data = json_decode($json, true);
        $data = $this->serializer->decode($json, 'json');

        if ($data === null) {
            throw new BadRequestHttpException('Invalid JSON');
        }

        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $data)) {
                throw new BadRequestHttpException('Required parameter '.$key.' is missing');
            }
        }

        return $json;
    }
}


