<?php

declare(strict_types=1);

namespace Itineris\FacetWpBuilder\Facets;

use Itineris\FacetWpBuilder\Abstracts\Facet;

/**
 * Autocomplete Facet type.
 *
 * @see https://facetwp.com/help-center/facets/facet-types/autocomplete/
 */
class Autocomplete extends Facet
{
    public const TYPE = 'autocomplete';
}
