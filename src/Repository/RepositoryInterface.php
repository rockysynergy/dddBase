<?php
namespace Orq\DddBase\Repository;

use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public static function save($entity):void;
    public static function update($entity):void;
    public static function findById(int $id);
    public static function find(array $where):?Collection;
}
