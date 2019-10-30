<?php

namespace Orq\DddBase;


abstract class AbstractEntity implements EntityInterface
{
    use IdTrait;
    use FieldToPropertyTrait;

    /**
     * The fields configuration the items should be
     * 'fieldName', => ['func:param1:param2|func_2', [['error_msg', 'error_code'],['error_msg', 'error_code']]]
     * @param array
     */
    protected $fieldsConf = [];

    protected $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    public function __call($func, $value)
    {
        if (substr($func, 0,3) == 'set') {
            $this->setValue($func, $value);
        }

        if (substr($func, 0, 3) == 'get') {
            $prop = lcfirst(substr($func, 3));
            // The domain validator will check for the existance of the property by calling $model->getPropName(), thus no need to do is_null check here;
            return $this->$prop;
        }

    }

    protected function setValue(string $func, array $value):void
    {
        $name = lcfirst(substr($func, 3));
        try {
            // For safety concern, only those has validation rules are allow to be set
            if (isset($this->fieldsConf[$name])) {
                $rules = explode('|', $this->fieldsConf[$name][0]);
                for ($i = 0; $i < count($rules); $i++) {
                    $rule = explode(':', $rules[$i]);
                    $func = array_splice($rule, 0, 1)[0];
                    $args = array_merge($rule, $this->fieldsConf[$name][1][$i]);
                    $args = array_merge($value, $args);
                    call_user_func_array([$this->validator, $func], $args);
                }
                $this->$name = $value[0];
            }
        } catch (IllegalArgumentException $e) {
            throw $e;
        }
    }


    // All fields are fetched through getter
    public function __get($name)
    {
        $getter = 'get'.ucfirst($name);
        if (\method_exists($this, $getter)) {
            return $this->$getter();
        } else if (isset($this->$name)) {
            return $this->$name;
        }
    }

    /**
     * get properties
     */
    public function getFields(array $fields):array
    {
        $arr = [];
        foreach ($fields as $f) {
            $p = $this->toProperty($f);
            $v = isset($this->$p) ? $this->$p : null;
            $arr[$f] = $v;
        }
        return $arr;
    }

    /**
     * Get data for mostly frontend howing
     */
    public function getData(array $fieldsToInclude=[], $fieldsToExclude=[]):array
    {
        $data = $this->getPersistData();
        $arr = $data;
        if (count($fieldsToInclude) > 0) {
            $inFields = array_combine($fieldsToInclude, $fieldsToInclude);
            $arr = array_intersect_key($data, $inFields);

            $remains = array_diff_key($inFields, $data);
            foreach ($remains as $k) {
                $prop = $this->toProperty($k);
                $arr[$k] = $this->$prop;
            }
        }

        if (count($fieldsToExclude) > 0) {
            $exFields = array_combine($fieldsToExclude, $fieldsToExclude);
            $arr = array_diff_key($arr, $exFields);
        }


        return $arr;
    }
}
