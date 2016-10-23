<?php

namespace AppBundle\Utils;

use Symfony\Component\Form\FormInterface;

class FormErrorSerializer
{
    public function serializeFormErrors(FormInterface $form, $flatArray = true, $addFormName = true, $glueKeys = '_')
    {
        $errors = $this->serialize($form);

        if ($flatArray) {
            $errors = $this->arrayFlatten(
                $errors,
                $glueKeys,
                (($addFormName) ? $form->getName() : '')
            );
        }

        return $errors;
    }

    private function serialize(FormInterface $form)
    {
        $localErrors = [];
        foreach ($form as $key => $child) {
            foreach ($child->getErrors() as $error) {
                $localErrors[$key] = $error->getMessage();
            }

            if (count($child) > 0) {
                $localErrors[$key] = $this->serialize($child);
            }
        }

        return $localErrors;
    }

    private function arrayFlatten($array, $separator = '_', $flattenedKey = '')
    {
        $flattenedArray = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $flattenedArray = array_merge($flattenedArray,
                    $this->arrayFlatten($value, $separator,
                        (strlen($flattenedKey) > 0 ? $flattenedKey . $separator : '') . $key)
                );
            } else {
                $flattenedArray[(strlen($flattenedKey) > 0 ? $flattenedKey . $separator : '') . $key] = $value;
            }
        }
        return $flattenedArray;
    }

}