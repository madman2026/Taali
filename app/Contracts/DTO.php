<?php

namespace App\Contracts;

class DTO
{
    protected array $data;

    public function tryFrom(array $data)
    {
        try {
            $this->data = $data;

            return $this;
        } catch (\Exception $e) {

        }
    }

    public function __get(string $attribute)
    {
        return $this->data[$attribute] ?? null;
    }

    public function __set(string $attribute, $value)
    {
        $this->data[$attribute] = $value;
    }

    public function __isset(string $attribute)
    {
        return isset($this->data[$attribute]);
    }

    public function toArray()
    {
        return (array) $this->data;
    }
}
