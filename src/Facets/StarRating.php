<?php

declare(strict_types=1);

namespace Itineris\FacetWpBuilder\Facets;

use Itineris\FacetWpBuilder\Abstracts\Facet;

/**
 * Star Rating Facet type.
 *
 * @see https://facetwp.com/help-center/facets/facet-types/rating/
 */
class StarRating extends Facet
{
    public const TYPE = 'rating';
}
