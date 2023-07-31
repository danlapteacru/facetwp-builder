<?php

declare(strict_types=1);

namespace DanLapteacru\FacetWpBuilder\Traits;

trait Helpers
{
    /**
     * Create a facet label based on the facet's name. Generates title case.
     *
     * @return string label
     */
    protected function generateLabel(string $name): string
    {
        return ucwords(str_replace('_', ' ', $name));
    }

    /**
     * Generates a snaked cased name.
     */
    protected function generateName(string $name): string
    {
        return strtolower(str_replace(' ', '_', $name));
    }

    /**
     * Converts a string from camelCase to snake_case.
     */
    protected function camelCaseToSnakeCase(string $string): string
    {
        if (ctype_lower($string)) {
            return $string;
        }

        $value = preg_replace('/\s+/u', '', ucwords($string));
        return strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1_', $value));
    }

    /**
     * Tests if an array is multidimensional.
     */
    public static function isMultidimensionalArray(array $array): bool
    {
        foreach ($array as $value) {
            if (is_array($value)) {
                return true;
            }
        }
        return false;
    }
}
