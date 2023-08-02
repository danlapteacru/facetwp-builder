<?php

declare(strict_types=1);

namespace DanLapteacru\FacetWpBuilder;

use DanLapteacru\FacetWpBuilder\Abstracts\ParentDelegationBuilder;
use DanLapteacru\FacetWpBuilder\Interfaces\Builder;
use DanLapteacru\FacetWpBuilder\Interfaces\NamedBuilder;
use DanLapteacru\FacetWpBuilder\Traits\Helpers;

/**
 * Builds configurations for FaceWP templates.
 *
 * @see https://facetwp.com/help-center/developers/hooks/advanced-hooks/facetwp_templates/
 */
class TemplatesBuilder extends ParentDelegationBuilder implements NamedBuilder
{
    use Helpers;

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
     * Template Name
     */
    protected string $name;

    /**
     * @param string $name templates group name
     */
    public function __construct(string $name = 'default')
    {
        $this->templateManager = new TemplateManager();
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
     * @return array Final facet config
     */
    public function build(bool $addTemplatesToWpHook = true): array
    {
        $facets = $this->buildTemplates();
        if (function_exists('apply_filters')) {
            $facets = apply_filters(
                'danlapteacru/facetwp-builder/templates',
                $facets,
                $this,
            );
        }

        if ($addTemplatesToWpHook) {
            static::addFacetWpHook($facets);
        }

        return $facets;
    }

    /**
     * Add the templates to FacetWP via the "facetwp_templates" filter.
     *
     * @param array $templates
     */
    public static function addFacetWpHook(array $templates = []): void
    {
        if (empty($templates) || ! function_exists('add_filter')) {
            return;
        }

        if (! static::isMultidimensionalArray($templates)) {
            $templates = [$templates];
        }

        add_filter(
            'facetwp_templates',
            fn (array $facetWpTemplates): array => array_merge($facetWpTemplates, $templates)
        );
    }

    /**
     * Return a facets config array
     *
     * @return array
     */
    private function buildTemplates(): array
    {
        return array_map(
            fn (array|Builder $facet): array => ($facet instanceof Builder) ? $facet->build() : $facet,
            $this->getTemplates(),
        );
    }

    /**
     * Add multiple facets either via an array or from another builder
     *
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
     * @param array  $args facet configuration
     * @throws FacetNameCollisionException If the template name already exists.
     */
    public function addTemplate(string $name, array $args = []): TemplateBuilder
    {
        return $this->initializeFacet(new TemplateBuilder($name, $args));
    }

    /**
     * Initialize the TemplateBuilder, add to TemplateManager, and return the TemplateBuilder
     *
     * @throws FacetNameCollisionException If the template name already exists.
     */
    protected function initializeFacet(TemplateBuilder $template): TemplateBuilder
    {
        $template->setParentContext($this);
        $this->getTemplateManager()->pushFacet($template);
        return $template;
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
     * Get a Template by name
     *
     * @throws FacetNotFoundException If the Template does not exist.
     */
    public function getTemplate(string $name): TemplateBuilder
    {
        return $this->getTemplateManager()->getFacet($name);
    }

    /**
     * Check if a template exists
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
