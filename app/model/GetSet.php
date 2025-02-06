<?php
namespace App\Model;
use Exception;
class GetSet 
{
    public function getAttributes($attributes)
    {
        $results = [];
        if (is_string($attributes)) {
            $attributes = [$attributes];
        }
        foreach ($attributes as $attr) {
            if (property_exists($this, $attr)) {
                $results[$attr] = $this->$attr;
            } else {
                throw new Exception("Property does not exist: " . $attr);
            }
        }
        return count($results) === 1 ? reset($results) : $results;
    }

    public function setAttributes(array $attributes)
    {
        foreach ($attributes as $attr => $value) {
            if (property_exists($this, $attr)) {
                $this->$attr = $value;
            } else {
                throw new Exception("Property does not exist: " . $attr);
            }
        }
    }
}
