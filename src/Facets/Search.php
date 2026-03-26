<?php

declare(strict_types=1);

namespace DanLapteacru\FacetWpBuilder\Facets;

use DanLapteacru\FacetWpBuilder\Abstracts\Facet;

/**
 * Search Facet type.
 *
 * @see https://facetwp.com/help-center/facets/facet-types/search/
 */
class Search extends Facet
{
    public const TYPE = 'search';
}
