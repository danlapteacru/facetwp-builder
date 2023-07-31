<?php

declare(strict_types=1);

namespace DanLapteacru\FacetWpBuilder;

use BadMethodCallException;
use DanLapteacru\FacetWpBuilder\Abstracts\ParentDelegationBuilder;
use DanLapteacru\FacetWpBuilder\Facets\Autocomplete;
use DanLapteacru\FacetWpBuilder\Facets\Checkbox;
use DanLapteacru\FacetWpBuilder\Facets\DateRange;
use DanLapteacru\FacetWpBuilder\Facets\Dropdown;
use DanLapteacru\FacetWpBuilder\Facets\FSelect;
use DanLapteacru\FacetWpBuilder\Facets\Hierarchy;
use DanLapteacru\FacetWpBuilder\Facets\NumberRange;
use DanLapteacru\FacetWpBuilder\Facets\Pager;
use DanLapteacru\FacetWpBuilder\Facets\Proximity;
use DanLapteacru\FacetWpBuilder\Facets\Radio;
use DanLapteacru\FacetWpBuilder\Facets\Reset;
use DanLapteacru\FacetWpBuilder\Facets\Search;
use DanLapteacru\FacetWpBuilder\Facets\Slider;
use DanLapteacru\FacetWpBuilder\Facets\Sort;
use DanLapteacru\FacetWpBuilder\Facets\StarRating;
use DanLapteacru\FacetWpBuilder\Facets\UserSelections;
use DanLapteacru\FacetWpBuilder\Interfaces\Builder;
use DanLapteacru\FacetWpBuilder\Interfaces\NamedBuilder;
use DanLapteacru\FacetWpBuilder\Traits\Helpers;

/**
 * Builds configurations for FaceWP facets
 *
 * @see https://facetwp.com/documentation/facet-types/
 *
 * @warning All the methods are generated with the __call() magic method.
 *
 * @method FacetsBuilder addAutocomplete(string $name, array $args = [])
 * @method FacetsBuilder addCheckbox(string $name, array $args = [])
 * @method FacetsBuilder addDateRange(string $name, array $args = [])
 * @method FacetsBuilder addDropdown(string $name, array $args = [])
 * @method FacetsBuilder addHierarchy(string $name, array $args = [])
 * @method FacetsBuilder addFSelect(string $name, array $args = [])
 * @method FacetsBuilder addNumberRange(string $name, array $args = [])
 * @method FacetsBuilder addSearch(string $name, array $args = [])
 * @method FacetsBuilder addSlider(string $name, array $args = [])
 * @method FacetsBuilder addSort(string $name, array $args = [])
 * @method FacetsBuilder addStarRating(string $name, array $args = [])
 * @method FacetsBuilder addPager(string $name, array $args = [])
 * @method FacetsBuilder addProximity(string $name, array $args = [])
 * @method FacetsBuilder addRadio(string $name, array $args = [])
 * @method FacetsBuilder addReset(string $name, array $args = [])
 * @method FacetsBuilder addUserSelections(string $name, array $args = [])
 *
 * @information To add a custom facet type, you can use the addFacet() method or use the
 * "danlapteacru/facetwp-builder/facets" WP filter.
 */
class FacetsBuilder extends ParentDelegationBuilder implements NamedBuilder
{
    use Helpers;

    /**
     * Allowed Facet Types
     * You can see the full list of allowed types here: https://facetwp.com/help-center/facets/facet-types/
     *
     * @var array
     */
    public const ALLOWED_FACET_TYPES = [
        Autocomplete::TYPE,
        Checkbox::TYPE,
        DateRange::TYPE,
        Dropdown::TYPE,
        Hierarchy::TYPE,
        FSelect::TYPE,
        NumberRange::TYPE,
        Search::TYPE,
        Slider::TYPE,
        Sort::TYPE,
        StarRating::TYPE,
        Pager::TYPE,
        Proximity::TYPE,
        Radio::TYPE,
        Reset::TYPE,
        UserSelections::TYPE,
    ];

    /**
     * Facet Group Configuration
     *
     * @var array
     */
    protected array $config = [];

    /**
     * Manages the Facet Configurations
     */
    protected FacetManager $facetManager;

    /**
     * Facet Group Name
     */
    protected string $name;

    /**
     * @param string $name Facet Group name
     */
    public function __construct(string $name)
    {
        $this->facetManager = new FacetManager();
        $this->name = $name;
        $this->setConfig('name', $name);
        $this->setConfig('label', $this->generateLabel($name));
    }

    /**
     * Set a value for a particular key in the group config
     *
     * @return $this
     */
    public function setConfig(string $key, mixed $value): static
    {
        $this->config[$key] = $value;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Build the final config array. Build any other builders that may exist
     * in the config.
     *
     * @return array Final facet config array, ready to be passed to FacetWP via the facetwp_facets filter
     */
    public function build(): array
    {
        $facets = $this->buildFacets();
        if (function_exists('apply_filters')) {
            $facets = apply_filters(
                'danlapteacru/facetwp-builder/facets',
                $facets,
                $this,
            );
        }

        return $facets;
    }

    /**
     * Add the facets to FacetWP via the "facetwp_facets" filter.
     *
     * @param array $facets
     */
    public function addFacetWpHook(array $facets = []): void
    {
        if (! function_exists('add_filter')) {
            return;
        }

        if (empty($facets)) {
            $facets = $this->buildFacets();
        }

        if (empty($facets)) {
            return;
        }

        add_filter('facetwp_facets', fn (array $facetWpFacets): array => array_merge($facetWpFacets, $facets));
    }

    /**
     * Return a facets config array
     *
     * @return array
     */
    private function buildFacets(): array
    {
        return array_map(
            fn (array|Builder $facet): array => ($facet instanceof Builder) ? $facet->build() : $facet,
            $this->getFacets(),
        );
    }

    /**
     * Add multiple facets either via an array or from another builder
     *
     * @throws FacetNameCollisionException If a facet name already exists.
     */
    public function addFacets(array|FacetsBuilder $facets): static
    {
        if ($facets instanceof FacetsBuilder) {
            $builder = clone $facets;
            $facets = $builder->getFacets();
        }

        foreach ($facets as $facet) {
            $this->getFacetManager()->pushFacet($facet);
        }

        return $this;
    }

    /**
     * Add a facet of a specific type
     *
     * @param string $name facet name
     * @param string $type facet type
     * @param array  $args facet configuration
     * @throws FacetNameCollisionException If a facet name already exists.
     */
    public function addFacet(string $name, string $type, array $args = []): FacetBuilder
    {
        return $this->initializeFacet(new FacetBuilder($name, $type, $args));
    }

    /**
     * Initialize the FacetBuilder, add to FacetManager, and return the FacetBuilder
     *
     * @throws FacetNameCollisionException If a facet name already exists.
     */
    protected function initializeFacet(FacetBuilder $facet): FacetBuilder
    {
        $facet->setParentContext($this);
        $this->getFacetManager()->pushFacet($facet);
        return $facet;
    }

    /**
     * Add the facets method to the builder
     *
     * @throws BadMethodCallException If the method is not allowed.
     */
    public function __call(string $method, array $args): Builder
    {
        $name = (string) ($args[0] ?? '');
        if (! str_starts_with($method, 'add') || empty($name)) {
            return $this;
        }

        $methodName = lcfirst(substr($method, 3));
        $keyName = $this->camelCaseToSnakeCase($methodName);
        $allowedFacetTypes = static::ALLOWED_FACET_TYPES;

        if (function_exists('apply_filters')) {
            $keyName = apply_filters(
                'danlapteacru/facetwp-builder/facet_key',
                $keyName,
                $methodName,
                $method,
                $args,
                $this,
            );

            $allowedFacetTypes = apply_filters(
                'danlapteacru/facetwp-builder/allowed_facet_types',
                $allowedFacetTypes,
                $keyName,
                $methodName,
                $method,
                $args,
                $this,
            );
        }

        if (! in_array($keyName, $allowedFacetTypes, true)) {
            throw new BadMethodCallException("Undefined method: '$method'");
        }

        $value = (array) ($args[1] ?? []);

        return $this->addFacet($name, $keyName, $value);
    }

    protected function getFacetManager(): FacetManager
    {
        return $this->facetManager;
    }

    /**
     * @return FacetBuilder[]
     */
    public function getFacets(): array
    {
        return $this->getFacetManager()->getFacets();
    }

    /**
     * Get a facet by name
     *
     * @throws FacetNotFoundException If the facet does not exist.
     */
    public function getFacet(string $name): FacetBuilder
    {
        return $this->getFacetManager()->getFacet($name);
    }

    /**
     * Check if a facet exists
     */
    public function facetExists(string $name): bool
    {
        return $this->getFacetManager()->facetNameExists($name);
    }

    public function __clone()
    {
        $this->facetManager = clone $this->facetManager;
    }
}
