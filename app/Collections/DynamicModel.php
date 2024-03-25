<?php
namespace App\Collections;

use Illuminate\Database\Eloquent\Model;

class DynamicModel extends Model
{
    public function loadRelation($relationName)
    {
        // Check if the relationship exists
        if (method_exists($this, $relationName)) {
            // Load the relationship
            return $this->load($relationName);
        } else {
            // Handle the case where the relationship doesn't exist
            throw new InvalidArgumentException("Relationship '$relationName' does not exist.");
        }
    }
}
