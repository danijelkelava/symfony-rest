<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ExtractorService
{
    /**
     * Extracts request body data and decodes it into array
     * Throws BadRequestHttpException in case of invalid request body or missing parameter
     *
     * @param array $requiredFields
     * @param Request $request
     * @throws BadRequestHttpException
     * @return array
     */
    public function extractFromJson(array $requiredKeys, string $jsonString): array
    {
        $data = json_decode($jsonString, true);

        if ($data === null) {
            throw new BadRequestHttpException('Invalid JSON');
        }

        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $data)) {
                throw new BadRequestHttpException('Required parameter '.$key.' is missing');
            }
        }

        return $data;
    }
}
