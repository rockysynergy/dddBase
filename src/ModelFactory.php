<?php

namespace Orq\DddBase;

use ReflectionClass;

class ModelFactory
{
    use FieldToPropertyTrait;

    public static function make(string $class, array $data, array $constructArgs=[]): object
    {
        if (count($constructArgs)<1) {
            $obj = new $class();
        } else {
            $r = new ReflectionClass($class);
            $obj = $r->newInstanceArgs($constructArgs);
        }
        try {
            foreach ($data as $k => $v) {
                if (!is_null($v)) {
                    $k = self::toProperty($k);
                    $setter = 'set' . ucfirst($k);
                    $obj->{$setter}($v);
                }
            }
        } catch(IllegalArgumentException $e) {
            throw $e;
        }

        $validatorClass = $class.'Validator';
        if (class_exists($validatorClass)) {
            $validator = new $validatorClass();
            try {
                $validator->validate($obj);
            } catch (DomainException $e) {
                throw $e;
            }
        }
        return $obj;
    }

    public static function update($obj, array $data) {
        try {
            foreach ($data as $k => $v) {
                if (!is_null($v)) {
                    $k = self::toProperty($k);
                    $setter = 'set' . ucfirst($k);
                    $obj->{$setter}($v);
                }
            }
        } catch(IllegalArgumentException $e) {
            throw $e;
        }

        $validatorClass = get_class($obj).'Validator';
        if (class_exists($validatorClass)) {
            $validator = new $validatorClass();
            try {
                $validator->validate($obj);
            } catch (DomainException $e) {
                throw $e;
            }
        }
        return $obj;
    }
}
