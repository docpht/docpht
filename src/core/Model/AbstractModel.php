<?php

namespace Instant\Core\Model;

abstract class AbstractModel
{

    public static function filter($column, $value)
    {
        // Find the row in the database
        foreach (static::$data as $row) {

            // If this is the row...
            if ($row[$column] == $value) {

                // Create a new instance of the actual class
                $instance = new static;

                // Hydrate the instance with the row contents
                foreach ($row as $key => $value) {
                    $instance->{$key} = $value;
                }

                // Return the new instance
                return $instance;
            }
        }
        return false;
    }

}
