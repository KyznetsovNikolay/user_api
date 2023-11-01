<?php


namespace App\Service;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationService
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    public function validate(object $data): array
    {
        if (count($errors = $this->validator->validate($data)) > 0) {
            $errorsData = [];
            foreach ($errors as $error) {
                $eMessages[$error->getPropertyPath()] = $error->getMessage();
            }
            return $errorsData;
        }

        return [];
    }
}
