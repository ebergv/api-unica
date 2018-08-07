<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 28/04/17
 * Time: 14:03
 */

namespace Prominas\Service;

const CHARACTER_UPPER = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
const CHARACTER_LOWER = 'abcdefghijklmnopqrstuvwxyz';
const NUMBER = '1234567890';
const SYMBOL = '!@#$%*-';

class CodeBoletoService
{
    protected $Size = 8;
    protected $UpperLowerCase = true; // true = Maiuscula - false = Minuscula
    protected $Number = true;
    protected $Symbol = false;

    public function codeBoleto()
    {
        $result = '';
        $character = $this->setCharacteres();
        $len = strlen($character);

        for ($n = 1; $n <= $this->Size; $n++) {
            $rand = mt_rand(1, $len);
            $result .= $character[$rand-1];
        }

        return $result;
    }

    public function setSize($value)
    {
        $this->Size = (integer) $value;
        return $this;
    }

    public function setUpperLowerCase($value)
    {
        $this->UpperLowerCase = (boolean) $value;
        return $this;
    }

    public function setNumber($value)
    {
        $this->Number = (boolean) $value;
        return $this;
    }

    public function setSymbol($value)
    {
        $this->Symbol = (boolean) $value;
        return $this;
    }

    private function setCharacteres()
    {
        if($this->UpperLowerCase) {
            $character = CHARACTER_UPPER;
        }else {
            $character = CHARACTER_LOWER;
        }

        if($this->Number) {
            $character .= NUMBER;
        }

        if($this->Symbol) {
            $character .= SYMBOL;
        }

        return $character;

    }

}