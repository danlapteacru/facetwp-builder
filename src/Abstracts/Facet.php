<?php

declare(strict_types=1);

namespace DanLapteacru\FacetWpBuilder\Abstracts;

/**
 * Facet type.
 */
abstract class Facet
{
    public const TYPE = '';

    public static function getType(): string
    {
        return static::TYPE;
    }

    public static function availableMethodsPerFacet(): ?array
    {
        // TODO: Implement availableMethodsPerFacet() method.
        return null;
    }
}
