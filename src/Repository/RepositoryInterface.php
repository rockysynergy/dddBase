<?php
namespace Orq\DddBase\Repository;

use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function save($entity):void;
    public function update($entity):void;
    public function findById(int $id);
    public function find(array $where):?Collection;
}
