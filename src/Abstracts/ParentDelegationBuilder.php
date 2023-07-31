<?php

declare(strict_types=1);

namespace DanLapteacru\FacetWpBuilder\Abstracts;

use DanLapteacru\FacetWpBuilder\Interfaces\Builder;

/**
 * Builds a configuration.
 * Can have parent contexts to delegate missing methods to.
 */
abstract class ParentDelegationBuilder implements Builder
{
    /**
     * The parent Builder, if this is a child Builder
     */
    private Builder $parentContext;

    /**
     * Builds the configuration
     *
     * @return array configuration
     */
    abstract public function build(): array;

    public function setParentContext(Builder $builder): void
    {
        $this->parentContext = $builder;
    }

    public function getParentContext(): Builder
    {
        return $this->parentContext;
    }
}
