<?php

declare(strict_types=1);

namespace Itineris\FacetWpBuilder\Facets;

use Itineris\FacetWpBuilder\Abstracts\Facet;

/**
 * Proximity Facet type.
 *
 * @see https://facetwp.com/help-center/facets/facet-types/proximity/
 */
class Proximity extends Facet
{
    public const TYPE = 'proximity';
}
