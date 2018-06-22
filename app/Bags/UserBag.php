<?php
/**
 * Created by PhpStorm.
 * User: pixeledge
 * Date: 01/05/2018
 * Time: 20:11
 */

namespace App\Bags;


use Illuminate\Support\Facades\Hash;

class UserBag
{
    private $attributes;

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function attributes(): array
    {
        $this->setPassword()
            ->setNames()
            ->setGender();

        return $this->attributes;
    }

    private function setPassword()
    {
        $this->attributes['password'] = Hash::make($this->attributes['password']);

        return $this;
    }

    private function setNames()
    {
        $this->attributes['name'] = ucwords(strtolower($this->attributes['name']));

        return $this;
    }

    private function setGender()
    {
        $this->attributes['gender'] = strtoupper($this->attributes['gender']);

        return $this;
    }
}