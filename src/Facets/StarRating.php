<?php

declare(strict_types=1);

namespace DanLapteacru\FacetWpBuilder\Facets;

use DanLapteacru\FacetWpBuilder\Abstracts\Facet;

/**
 * Star Rating Facet type.
 *
 * @see https://facetwp.com/help-center/facets/facet-types/rating/
 */
class StarRating extends Facet
{
    public const TYPE = 'rating';
}
