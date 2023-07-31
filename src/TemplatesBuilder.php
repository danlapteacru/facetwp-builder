<?php

declare(strict_types=1);

namespace DanLapteacru\FacetWpBuilder;

use BadMethodCallException;
use DanLapteacru\FacetWpBuilder\Abstracts\ParentDelegationBuilder;
use DanLapteacru\FacetWpBuilder\Exceptions\FacetNameCollisionException;
use DanLapteacru\FacetWpBuilder\Exceptions\FacetNotFoundException;
use DanLapteacru\FacetWpBuilder\Interfaces\Builder;
use DanLapteacru\FacetWpBuilder\Interfaces\NamedBuilder;
use DanLapteacru\FacetWpBuilder\Traits\Helpers;

/**
 * Builds configurations for FaceWP templates.
 */
class TemplatesBuilder extends ParentDelegationBuilder implements NamedBuilder
{
    use Helpers;

    /**
     * Allowed Facet Types
     * You can see the full list of allowed types here: https://facetwp.com/help-center/facets/facet-types/
     *
     * @var array
     */
    public const ALLOWED_FACET_TYPES = [
        'autocomplete',
        'checkbox',
        'date_range',
        'dropdown',
        'hierarchy',
        'fselect',
        'number_range',
        'search',
        'slider',
        'sort',
        'star_rating',
        'pager',
        'proximity',
        'radio',
        'reset',
        'user_selection',
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
    protected TemplateManager $templateManager;

    /**
     * Facet Group Name
     */
    protected string $name;

    /**
     * @param string $name Facet Group name
     * @param array  $groupConfig Facet Group configuration
     */
    public function __construct(string $name, array $groupConfig = [])
    {
        $this->templateManager = new TemplateManager();
        $this->name = $name;
        $this->setGroupConfig('key', $name);
        $this->setGroupConfig('title', $this->generateLabel($name));

        $this->config = array_merge($this->config, $groupConfig);
    }

    /**
     * Set a value for a particular key in the group config
     *
     * @return $this
     */
    public function setGroupConfig(string $key, mixed $value): static
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
     * @param bool $returnOnlyTemplatesArray Whether to return the facets array or not.
     * @return array Final facet config
     */
    public function build(bool $returnOnlyTemplatesArray = false): array
    {
        $facets = $this->buildFacets();
        if (function_exists('apply_filters')) {
            $facets = apply_filters(
                'itineris/facetwp-builder/templates',
                $facets,
                $this
            );
        }

        if (! $returnOnlyTemplatesArray) {
            $this->addTemplateWpHook($facets);
        }

        return $facets;
    }

    public function addTemplateWpHook(array $templates): void
    {
        if (empty($templates) || ! function_exists('add_filter')) {
            return;
        }

        add_filter('facetwp_templates', fn (array $facetWpTemplates): array => array_merge($facetWpTemplates, $facets));
    }

    /**
     * Return a facets config array
     *
     * @return array
     */
    private function buildFacets(): array
    {
        $facets = array_map(
            fn (array|Builder $facet): array => ($facet instanceof Builder) ? $facet->build() : $facet,
            $this->getTemplates(),
        );

        return $this->transformFacets($facets);
    }

    /**
     * Apply facet transforms
     *
     * @param array $facets
     * @return array Transformed facets config
     */
    private function transformFacets(array $facets): array
    {
        return $facets;
    }

    /**
     * Add multiple facets either via an array or from another builder
     * @throws FacetNameCollisionException If the facet name already exists.
     */
    public function addTemplates(array|FacetsBuilder $facets): static
    {
        if ($facets instanceof FacetsBuilder) {
            $builder = clone $facets;
            $facets = $builder->getFacets();
        }

        foreach ($facets as $facet) {
            $this->getTemplateManager()->pushFacet($facet);
        }

        return $this;
    }

    /**
     * Add a facet of a specific type
     *
     * @param string $name facet name
     * @param string $type facet type
     * @param array  $args facet configuration
     */
    public function addTemplate(string $name, string $type, array $args = []): TemplateBuilder
    {
        return $this->initializeFacet(new TemplateBuilder($name, $type, $args));
    }

    /**
     * Initialize the TemplateBuilder, add to TemplateManager, and return the TemplateBuilder
     */
    protected function initializeFacet(TemplateBuilder $facet): TemplateBuilder
    {
        $facet->setParentContext($this);
        $this->getTemplateManager()->pushFacet($facet);
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
                'itineris/facetwp-builder/facet_key',
                $keyName,
                $methodName,
                $method,
                $args,
                $this
            );

            $allowedFacetTypes = apply_filters(
                'itineris/facetwp-builder/allowed_facet_types',
                $allowedFacetTypes,
                $keyName,
                $methodName,
                $method,
                $args,
                $this
            );
        }

        if (! in_array($keyName, $allowedFacetTypes, true)) {
            throw new BadMethodCallException("Undefined method: '$method'");
        }

        $value = (array) ($args[1] ?? []);

        return $this->addTemplate($name, $keyName, $value);
    }

    protected function getTemplateManager(): TemplateManager
    {
        return $this->templateManager;
    }

    /**
     * @return TemplateBuilder[]
     */
    public function getTemplates(): array
    {
        return $this->getTemplateManager()->getFacets();
    }

    /**
     * Get a facet by name
     * @throws FacetNotFoundException If the facet does not exist.
     */
    public function getTemplate(string $name): TemplateBuilder
    {
        return $this->getTemplateManager()->getFacet($name);
    }

    /**
     * Check if a facet exists
     */
    public function templateExists(string $name): bool
    {
        return $this->getTemplateManager()->facetNameExists($name);
    }

    public function __clone()
    {
        $this->templateManager = clone $this->templateManager;
    }
}
