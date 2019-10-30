<?php
namespace Orq\DddBase;

trait IdTrait
{

    /**
     * @param int
     */
    protected $id;

    public function setId(int $id):void
    {
        if (!is_int($id) || $id<0) {
            throw new IllegalArgumentException('请提供合法的id', 1562220248);
        }

        $this->id = $id;
    }

    public function getId():?int
    {
        return $this->id;
    }
}
