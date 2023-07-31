<?php

declare(strict_types=1);

namespace DanLapteacru\FacetWpBuilder;

use DanLapteacru\FacetWpBuilder\Abstracts\ParentDelegationBuilder;
use DanLapteacru\FacetWpBuilder\Interfaces\Builder;
use DanLapteacru\FacetWpBuilder\Interfaces\NamedBuilder;
use DanLapteacru\FacetWpBuilder\Traits\Builder as BuilderTrait;
use DanLapteacru\FacetWpBuilder\Traits\Helpers;
use Exception;
use WP_Post_Type;

/**
 * Builds configurations for an FacetWP template.
 */
class TemplateBuilder extends ParentDelegationBuilder implements NamedBuilder
{
    use BuilderTrait;
    use Helpers;

    /**
     * Additional Field Configuration
     *
     * @var array
     */
    private array $config;

    /**
     * @param string $name Field Name, conventionally 'snake_case'.
     * @param array  $config Additional Field Configuration.
     */
    public function __construct(string $name, array $config = [])
    {
        $this->config = [
            'name' => $name,
            'label' => $this->generateLabel($name),
        ];

        $this->setKey($name);
        $this->updateConfig($config);
    }

    /**
     * Set the template name.
     */
    public function setName(string $name): Builder
    {
        return $this->setAttr('name', $name);
    }

    /**
     * Set the label name.
     */
    public function setLabel(string $label): Builder
    {
        return $this->setAttr('label', $label);
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

        return $this->setConfig($name, $value);
    }

    /**
     * Set the template query.
     *
     * @param array $query
     */
    public function setQuery(array $query): Builder
    {
        $this->setAttr('query_array', $query);
        return $this->setAttr('query', $this->arrayToString($query));
    }

    /**
     * Convert an array to a string.
     * FacetWP requires the query to be a string.
     *
     * @param array $array
     */
    public function arrayToString(array $array, int $indent = 2): string
    {
        $output = '[' . PHP_EOL;

        foreach ($array as $key => $value) {
            $output .= str_repeat(' ', $indent) . "'$key' => ";

            if (is_array($value)) {
                $output .= $this->arrayToString($value, $indent + 2);
            } elseif (is_string($value)) {
                $output .= "'$value'";
            } else {
                $output .= $value;
            }

            $output .= ',' . PHP_EOL;
        }

        $output .= str_repeat(' ', $indent - 2) . ']';
        return '<?php' . PHP_EOL . 'return ' . $output . ';' . PHP_EOL;
    }

    /**
     * Set the template query Object.
     *
     * @param array $query
     */
    public function setQueryObj(array $query): Builder
    {
        return $this->setAttr('query_obj', $query);
    }

    /**
     * Set the template layout.
     *
     * @param array $layout
     */
    public function setLayout(array $layout): Builder
    {
        return $this->setAttr('layout', $layout);
    }

    /**
     * Set the template modes.
     *
     * @param array $modes
     */
    public function setModes(array $modes): Builder
    {
        return $this->setAttr('modes', $modes);
    }

    /**
     * Set the post type for the template query.
     *
     * @throws Exception If post type not found.
     */
    public function setPostType(string $postType): Builder
    {
        $postTypeObject = get_post_type_object($postType);
        if (! $postTypeObject instanceof WP_Post_Type) {
            throw new Exception("Post type {$postType} not found.");
        }

        $queryArray = $this->getOption('query_array', []);
        $queryArray['post_type'] = $postType;
        $this->setQuery($queryArray);

        $queryObj = $this->getOption('query_obj', []);
        $queryObj['post_type'] = [
            'value' => $postType,
            'label' => $postTypeObject->label,
        ];

        return $this->setAttr('query_obj', $queryObj);
    }

    /**
     * Set the posts per page for the template query.
     */
    public function setPostsPerPage(int $postsPerPage): Builder
    {
        $queryArray = $this->getOption('query_array', []);
        $queryArray['posts_per_page'] = $postsPerPage;
        $this->setQuery($queryArray);

        $queryObj = $this->getOption('query_obj', []);
        $queryObj['posts_per_page'] = $postsPerPage;

        return $this->setAttr('query_obj', $queryObj);
    }

    /**
     * Build the field configuration array
     *
     * @return array Field configuration array
     */
    public function build(): array
    {
        $config = $this->getConfig();

        foreach ($config as $key => $value) {
            if ($value instanceof Builder) {
                $config[$key] = $value->build();
            }
        }

        if (empty($config['modes'])) {
            $config['modes'] = [
                'display' => 'visual',
                'query' => 'advanced',
            ];
        }

        return $config;
    }
}
