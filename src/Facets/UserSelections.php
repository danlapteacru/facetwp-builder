<?php

declare(strict_types=1);

namespace DanLapteacru\FacetWpBuilder\Facets;

use DanLapteacru\FacetWpBuilder\Abstracts\Facet;

/**
 * User Selection Facet type.
 *
 * @see https://facetwp.com/help-center/facets/facet-types/user-selections/
 */
class UserSelections extends Facet
{
    public const TYPE = 'user_selections';
}
