<?php

declare(strict_types=1);

namespace Itineris\FacetWpBuilder\Facets;

use Itineris\FacetWpBuilder\Abstracts\Facet;

/**
 * Dropdown Facet type.
 *
 * @see https://facetwp.com/help-center/facets/facet-types/dropdown/
 */
class Dropdown extends Facet
{
    public const TYPE = 'dropdown';
}
