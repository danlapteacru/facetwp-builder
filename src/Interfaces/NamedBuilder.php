<?php

declare(strict_types=1);

namespace DanLapteacru\FacetWpBuilder\Interfaces;

/**
 * Builder with a name
 */
interface NamedBuilder extends Builder
{
    /**
     * Returns the name of the builder
     *
     * @return string name
     */
    public function getName(): string;
}
