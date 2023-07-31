<?php

declare(strict_types=1);

namespace DanLapteacru\FacetWpBuilder\Abstracts;

use DanLapteacru\FacetWpBuilder\Exceptions\FacetNameCollisionException;
use DanLapteacru\FacetWpBuilder\Exceptions\FacetNotFoundException;
use DanLapteacru\FacetWpBuilder\FacetBuilder;
use DanLapteacru\FacetWpBuilder\TemplateBuilder;
use OutOfRangeException;

/**
 * Manages an array of facet configs
 */
abstract class FacetWpManager
{
    /**
     * Array of the facets
     *
     * @var array
     */
    private array $items;

    /**
     * @param array $facetWpItems optional default array of facet configs
     */
    public function __construct(array $facetWpItems = [])
    {
        $this->items = $facetWpItems;
    }

    /**
     * @return FacetBuilder[]|TemplateBuilder[] facet configs
     */
    public function getFacets(): array
    {
        return $this->items;
    }

    /**
     * Return int of facets
     *
     * @return int facet count
     */
    public function getCount(): int
    {
        return count($this->getFacets());
    }

    /**
     * Add facet to end of array
     *
     * @param FacetBuilder|TemplateBuilder $facetWpItem Facet array config or Builder
     * @throws FacetNameCollisionException If the facet name already exists.
     */
    public function pushFacet(FacetBuilder|TemplateBuilder $facetWpItem): void
    {
        $this->insertFacets($facetWpItem, $this->getCount());
    }

    /**
     * Remove last facet from end of array
     *
     * @throws OutOfRangeException If array is empty.
     * @return FacetBuilder Facet array config or Builder
     */
    public function popFacet(): FacetBuilder
    {
        if ($this->getCount() > 0) {
            $facetWpItems = $this->removeFacetAtIndex($this->getCount() - 1);
            return $facetWpItems[0];
        }

        throw new OutOfRangeException("Can't call popFacet when the facet count is 0");
    }

    /**
     * Insert of facet at a specific index
     *
     * @param FacetBuilder|FacetBuilder[] $facetWpItems a single facet or an array of facets
     * @param int                         $index insertion point
     * @throws FacetNameCollisionException If the facet name already exists.
     */
    public function insertFacets(array|FacetBuilder|TemplateBuilder $facetWpItems, int $index): void
    {
        if (
            (
                ! $facetWpItems instanceof FacetBuilder
                && ! $facetWpItems instanceof TemplateBuilder
                && ! is_array($facetWpItems)
            ) // TODO: test this.
            || empty($facetWpItems)
        ) {
            return;
        }

        // If a singular item config, put into an array of facets.
        if (! is_array($facetWpItems)) {
            $facetWpItems = [$facetWpItems];
        }

        foreach ($facetWpItems as $i => $facetWpItem) {
            if ($this->validateFacet($facetWpItem)) {
                array_splice($this->items, $index + $i, 0, [$facetWpItem]);
            }
        }
    }

    /**
     * Remove a facet at a specific index
     *
     * @return array removed facet
     */
    private function removeFacetAtIndex(int $index): array
    {
        return array_splice($this->items, $index, 1);
    }

    /**
     * Remove a specific facet by name
     *
     * @param string $name name of the facet
     * @throws FacetNotFoundException If the facet doesn't exist.
     */
    public function removeFacet(string $name): void
    {
        $index = $this->getFacetIndex($name);
        $this->removeFacetAtIndex($index);
    }

    /**
     * Replace a facet with a single facet or array of facets
     *
     * @param string                                                      $name name of facet to replace
     * @param FacetBuilder|FacetBuilder[]|TemplateBuilder|TemplateBuilder[] $facetWpItem single or array of facets
     * @throws FacetNotFoundException|FacetNameCollisionException If the facet name doesn't exist.
     */
    public function replaceFacet(string $name, array|FacetBuilder|TemplateBuilder $facetWpItem): void
    {
        $index = $this->getFacetIndex($name);
        $this->removeFacetAtIndex($index);
        $this->insertFacets($facetWpItem, $index);
    }

    /**
     * Check to see if a facet name already exists
     *
     * @param string $name facet name
     */
    public function facetNameExists(string $name): bool
    {
        try {
            $this->getFacetIndex($name);
        } catch (FacetNotFoundException $e) {
            return false;
        }

        return true;
    }

    /**
     * Return a facet by name
     *
     * @param string $name facet name
     * @throws FacetNotFoundException If the facet doesn't exist.
     */
    public function getFacet(string $name): FacetBuilder|TemplateBuilder
    {
        return $this->items[$this->getFacetIndex($name)];
    }

    /**
     * Modify the configuration of a facet
     *
     * @param string $name facet name
     * @param array  $modifications facet configuration
     * @throws FacetNotFoundException|FacetNameCollisionException If the facet or facet name doesn't exist.
     */
    public function modifyFacet(string $name, array $modifications): void
    {
        $facetWpItem = $this->getFacet($name)->updateConfig($modifications);
        $this->replaceFacet($name, $facetWpItem);
    }

    /**
     * Validate a facet
     *
     * @throws FacetNameCollisionException When the name already exists.
     */
    private function validateFacet(FacetBuilder|TemplateBuilder $facetWpItem): bool
    {
        return $this->validateFacetName($facetWpItem);
    }

    /**
     * Validates that a facet's name doesn't already exist
     *
     * @throws FacetNameCollisionException When the name already exists.
     */
    private function validateFacetName(FacetBuilder|TemplateBuilder $facetWpItem): bool
    {
        $facetWpItemName = $facetWpItem->getName();
        if (!$facetWpItemName || $this->facetNameExists($facetWpItemName)) {
            $itemType = $facetWpItem instanceof FacetBuilder ? 'facet' : 'listing';
            throw new FacetNameCollisionException("FacetWP {$itemType} : `{$facetWpItemName}` already exists.");
        }

        return true;
    }

    /**
     * Return the index in the $this->items array looked up by the facet's name
     *
     * @param string $name Facet Name.
     * @return int Facet Index
     * @throws FacetNotFoundException If the facet name doesn't exist.
     */
    public function getFacetIndex(string $name): int
    {
        foreach ($this->getFacets() as $index => $facetWpItem) {
            if ($facetWpItem->getName() === $name) {
                return $index;
            }
        }

        throw new FacetNotFoundException("Facet `{$name}` not found.");
    }
}
