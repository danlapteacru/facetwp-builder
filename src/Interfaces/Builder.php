<?php

declare(strict_types=1);

namespace DanLapteacru\FacetWpBuilder\Interfaces;

/**
 * Interface for Builder
 * Builds a configuration array
 */
interface Builder
{
    /**
     * Builds the configuration
     *
     * @return array configuration
     */
    public function build(): array;
}
