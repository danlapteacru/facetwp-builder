<?php

declare(strict_types=1);

namespace DanLapteacru\FacetWpBuilder\Facets;

use DanLapteacru\FacetWpBuilder\Abstracts\Facet;

/**
 * Date Range Facet type.
 *
 * @see https://facetwp.com/help-center/facets/facet-types/date-range/
 */
class DateRange extends Facet
{
    public const TYPE = 'date_range';
}
