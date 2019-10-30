<?php
namespace Orq\DddBase;


interface EntityInterface
{
    public function getId():?int;
    public function setId(int $id):void;
    public function getPersistData():array;
    public function getData(array $fieldsToInclude=[], array $fieldsToExclude=[]):array;
}
