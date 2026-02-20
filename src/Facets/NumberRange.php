<?php

declare(strict_types=1);

namespace Itineris\FacetWpBuilder\Facets;

use Itineris\FacetWpBuilder\Abstracts\Facet;

/**
 * Number Range Facet type.
 *
 * @see https://facetwp.com/help-center/facets/facet-types/number-range/
 */
class NumberRange extends Facet
{
    public const TYPE = 'number_range';
}
