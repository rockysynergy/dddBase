<?php
namespace Orq\DddBase;

class DomainException extends \Exception
{
    public function log()
    {
        return 'Code: '.$this->code.' Msg: '.$this->message. ' At: '.$this->getLine(). ' In: '.$this->getFile();
    }
}
