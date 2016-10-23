<?php

namespace AppBundle\Utils;

use JMS\Serializer\Handler\ConstraintViolationHandler;
use JMS\Serializer\JsonSerializationVisitor;
use Symfony\Component\Validator\ConstraintViolation;

class ConstraintValidationHandler extends ConstraintViolationHandler
{
    public function serializeViolationToJson(
        JsonSerializationVisitor $visitor,
        ConstraintViolation $violation,
        array $type = null
    ) {
        $data = [
            'field' => $violation->getPropertyPath(),
            'message' => $violation->getMessage()
        ];

        if (null === $visitor->getRoot()) {
            $visitor->setRoot($data);
        }

        return $data;
    }
}
