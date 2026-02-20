<?php

declare(strict_types=1);

namespace Itineris\FacetWpBuilder\Facets;

use Itineris\FacetWpBuilder\Abstracts\Facet;

/**
 * Date Range Facet type.
 *
 * @see https://facetwp.com/help-center/facets/facet-types/date-range/
 */
class DateRange extends Facet
{
    public const TYPE = 'date_range';
}
