<?php


namespace App\Service;


use Symfony\Component\Form\FormInterface;

class FormService
{
    /**
     * @param FormInterface $form
     * @return array
     */
    public function getErrorMessages(FormInterface $form): array {
        $errors = [];

        foreach ($form->getErrors() as $key => $error) {
            if ($form->isRoot()) {
                $errors['#'][] = $error->getMessage();
            } else {
                $errors[] = $error->getMessage();
            }
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getErrorMessages($child);
            }
        }

        return $errors;
    }
}