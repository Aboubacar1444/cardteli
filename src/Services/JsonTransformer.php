<?php
namespace App\Services;

use Symfony\Component\Form\DataTransformerInterface;

class JsonTransformer implements DataTransformerInterface {

    public function transform(mixed $value){
        if (empty($value)) {
            return json_encode([]);
        }

        return json_encode($value);
    }
    
    
    public function reverseTransform(mixed $value){
        if (empty($value)) {
            return [];
        }

        return json_decode($value);
    }

}