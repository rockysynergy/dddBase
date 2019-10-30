<?php
namespace Orq\DddBase;

use Illuminate\Support\Facades\Log;

trait TimeStampTrait
{

    /**
     * @param string
     */
    protected $createdAt;

    /**
     * @param string
     */
    protected $updatedAt;

    public function setCreatedAt(string $time):void
    {
        try {
            $n = new \DateTime($time);
            $this->createdAt = $n->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            Log::warning($e->getMessage().json_encode($e->getTrace()));
            throw $e;
        }
    }

    public function getCreatedAt(string $format=null)
    {
        $n = new \DateTime($this->createdAt);
        if (is_null($format)) return $n;

        return $n->format($format);
    }

    public function setUpdatedAt(string $time):void
    {
        try {
            $n = new \DateTime($time);
            $this->updatedAt = $n->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            Log::warning($e->getMessage().json_encode($e->getTrace()));
            throw $e;
        }
    }

    public function getUpdatedAt(string $format=null)
    {
        $n = new \DateTime($this->updatedAt);
        if (is_null($format)) return $n;

        return $n->format($format);
    }
}
