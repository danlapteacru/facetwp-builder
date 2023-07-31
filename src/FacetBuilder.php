<?php

declare(strict_types=1);

namespace DanLapteacru\FacetWpBuilder;

use BadMethodCallException;
use DanLapteacru\FacetWpBuilder\Abstracts\ParentDelegationBuilder;
use DanLapteacru\FacetWpBuilder\Interfaces\Builder;
use DanLapteacru\FacetWpBuilder\Interfaces\NamedBuilder;
use DanLapteacru\FacetWpBuilder\Traits\Builder as BuilderTrait;
use DanLapteacru\FacetWpBuilder\Traits\Helpers;

/**
 * Builds configurations for an FacetWP facet.
 *
 * @method $this setName(string $name)
 * @method $this setLabel(string $label)
 * @method $this setSource(string $source)
 * @method $this setOperator(string $operator)
 * @method $this setOrderby(string $orderby)
 * @method $this setCount(int $count)
 * @method $this setHierarchical(bool $hierarchical)
 * @method $this setShowExpanded(bool $show_expanded)
 * @method $this setGhosts(bool $ghosts)
 * @method $this setPreserveGhosts(bool $preserve_ghosts)
 * @method $this setSoftLimit(int $soft_limit)
 * @method $this setLabelAny(string $label_any)
 * @method $this setMultiple(bool $multiple)
 * @method $this setSearchEngine(string $search_engine)
 * @method $this setPlaceholder(string $placeholder)
 * @method $this setAutoRefresh(bool $auto_refresh)
 * @method $this setStep(int $step)
 * @method $this setPrefix(string $prefix)
 * @method $this setSuffix(string $suffix)
 * @method $this setCompareType(string $compare_type)
 * @method $this setFormat(string $format)
 * @method $this setSourceOther(string $source_other)
 *
 * @warning All methods starting with 'set' are generated dynamically by __call() magic method.
 * @information If you want to add a custom attribute, use setAttr() method.
 */
class FacetBuilder extends ParentDelegationBuilder implements NamedBuilder
{
    use BuilderTrait;
    use Helpers;

    public const ALLOWED_CONFIG_KEYS = [
        'name',
        'label',
        'source',
        'operator',
        'orderby',
        'count',
        'hierarchical',
        'show_expanded',
        'ghosts',
        'preserve_ghosts',
        'soft_limit',
        'label_any',
        'multiple',
        'search_engine',
        'placeholder',
        'auto_refresh',
        'step',
        'prefix',
        'suffix',
        'compare_type',
        'format',
        'source_other',
    ];

    /**
     * Field Type
     */
    private string $type;

    /**
     * Additional Field Configuration
     *
     * @var array
     */
    private array $config;

    /**
     * @param string $name Field Name, conventionally 'snake_case'.
     * @param string $type Field Type.
     * @param array  $config Additional Field Configuration.
     * @throws BadMethodCallException If the specified type is not allowed.
     */
    public function __construct(string $name, string $type, array $config = [])
    {
        $allowedFacetTypes = FacetsBuilder::getAllowedFacetTypes();
        if (! in_array($type, $allowedFacetTypes, true)) {
            throw new BadMethodCallException("Undefined facet type: '$type'");
        }

        $this->config = [
            'name' => $name,
            'label' => $this->generateLabel($name),
        ];

        $this->type = $type;
        $this->setKey($name);
        $this->updateConfig($config);
    }

    /**
     * Set specified Attr of a Wrapper container
     *
     * @param string      $name Attribute name, ex. 'source'.
     * @param string|null $value Attribute value, ex. 'post-type'.
     */
    public function setAttr(string $name, mixed $value = null): Builder
    {
        if (is_null($value)) {
            return $this;
        }

        $value = $this->transformOptionValue($value);

        return $this->setConfig($name, $value);
    }

    /**
     * Build the field configuration array
     *
     * @return array Field configuration array
     */
    public function build(): array
    {
        $config = array_merge([
            'type' => $this->type,
        ], $this->getConfig());

        foreach ($config as $key => $value) {
            if ($value instanceof Builder) {
                $config[$key] = $value->build();
            }
        }

        return $config;
    }

    public function __call(string $method, array $args): Builder
    {
        if (! str_starts_with($method, 'set') || count($args) !== 1) {
            return $this;
        }

        $methodName = lcfirst(substr($method, 3));
        $keyName = $this->camelCaseToSnakeCase($methodName);

        if (! in_array($keyName, static::ALLOWED_CONFIG_KEYS, true)) {
            throw new BadMethodCallException("Undefined method: '$method'");
        }

        return $this->setAttr($keyName, $args[0]);
    }
}
