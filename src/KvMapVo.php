<?php
namespace Orq\DddBase;

class KvMapVo
{
    private $config;

    public function __construct(array $config = [])
    {
        if (count($config) < 1) throw new IllegalArgumentException('请提供合法的config', 1572945921);
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    public function getValue(string $key)
    {
        if (!isset($this->config[$key])) throw new DomainException('找不到'.$key, 1572945091);
        return $this->config[$key];
    }

    /**
     * @return mixed | false return false when not found
     */
    public function getKey(string $value)
    {
        return array_search($value, $this->config);
    }

}
