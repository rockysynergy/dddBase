<?php

namespace Orq\DddBase;

class Validator
{
    public function minStrLen($str, $limit, $errorMsg, $errorCode):void
    {
        if (mb_strlen($str) < $limit) {
            throw new IllegalArgumentException($errorMsg, $errorCode);
        }
    }

    public function isNumeric($val, $errorMsg, $errorCode):void
    {
        if (!is_numeric($val)) {
            throw new IllegalArgumentException($errorMsg, $errorCode);
        }
    }

    public function maxStrLen($str, $limit, $errorMsg, $errorCode):void
    {
        if (mb_strlen($str) > $limit) {
            throw new IllegalArgumentException($errorMsg, $errorCode);
        }
    }

    public function inList($item, $aList, $errorMsg, $errorCode):void
    {
        $aList = \explode(',', $aList);
        if (!in_array($item, $aList)) {
            throw new IllegalArgumentException($errorMsg, $errorCode);
        }
    }

    public function validId($id, $errorMsg, $errorCode):void
    {
        $id = (int) $id;
        if (!is_int($id) || $id < 0) {
            throw new IllegalArgumentException($errorMsg, $errorCode);
        }
    }

    public function positiveNumber($number, $errorMsg, $errorCode):void
    {
        if ($number < 0) {
            throw new IllegalArgumentException($errorMsg, $errorCode);
        }

    }

    public function validTimestamp($stamp, $errorMsg, $errorCode):void
    {
        if (!is_numeric($stamp)) {
                throw new IllegalArgumentException($errorMsg, $errorCode);
            }

    }

    public function validInteger($num, $errorMsg, $errorCode):void
    {
        if (!is_int($num)) {
            throw new IllegalArgumentException($errorMsg, $errorCode);
        }
    }
}
