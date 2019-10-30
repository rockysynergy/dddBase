<?php
namespace Orq\DddBase;

class KvMapVo
{
    /**
     * @param string
     */
    private $key;

    /**
     * @param string
     */
    private $value;

    /**
     * @param string
     */
    private $item;

    public function __construct(string $item, $kv)
    {
        $this->item = $item;
        if (is_int($kv)) {
            $this->key = (string) $kv;
            $this->value = config("kvconfig.{$item}.{$this->key}");
        }

        if (is_string($kv) && mb_strlen($kv)>1) {
            $items = config("kvconfig.{$item}");
            if (!is_array($items)) {
                $this->key = $item;
                $this->value = $items;
            } else {
                foreach ($items as $k=>$v) {
                    if ($v == $kv) {
                        $this->key = $k;
                        $this->value = $v;
                        break;
                    }
                }
            }
        }
    }

    public function getKey():string
    {
        return $this->key;
    }

    public function getValue():string
    {
        return $this->value;
    }

    public function update(int $key):KvMapVo
    {
        return new self($this->item, $key);
    }
}
