<?php
declare(strict_types=1);

namespace App\Validator;

use App\Data\FormDTO;

class CalculatingFormValidator
{
    public function validate(FormDTO $dto): array
    {
        $errors = [];

        if (empty($dto->getPostCode())) {
            $errors['postCode'] = 'Post code is required';
        }
        if (strlen((string)$dto->getPostCode()) !== 5) {
            $errors['postCode'] = 'Post code should have exactly 5 digits';
        }


        if (empty($dto->getTotalAmount())) {
            $errors['totalAmount'] = 'Total amount is required';
        }
        if ($dto->getTotalAmount() < 0) {
            $errors['totalAmount'] = 'Total amount should be a positive number';
        }

        if (empty($dto->getLongProduct())) {
            $errors['longProduct'] = 'Long product is required';
        }
        return $errors;
    }
}