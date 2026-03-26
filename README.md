# FacetWP Builder

Create, register, and reuse [FacetWP](https://facetwp.com/) plugin facets/templates using PHP, and keep them in your source code repository. To read more about registering FacetWP facets and templates via PHP, go here: [facets documentation](https://facetwp.com/help-center/developers/hooks/advanced-hooks/facetwp_facets/) and [templates documentation](https://facetwp.com/help-center/developers/hooks/advanced-hooks/facetwp_templates/).

[![Packagist Version](https://img.shields.io/packagist/v/danlapteacru/facetwp-builder.svg?label=release&style=flat-square)](https://packagist.org/packages/danlapteacru/facetwp-builder)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/danlapteacru/facetwp-builder.svg?style=flat-square)](https://packagist.org/packages/danlapteacru/facetwp-builder)
[![Packagist Downloads](https://img.shields.io/packagist/dt/danlapteacru/facetwp-builder.svg?label=packagist%20downloads&style=flat-square)](https://packagist.org/packages/danlapteacru/facetwp-builder/stats)
[![GitHub License](https://img.shields.io/github/license/danlapteacru/facetwp-builder.svg?style=flat-square)](https://github.com/danlapteacru/facetwp-builder/blob/master/LICENSE)

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->

- [Minimum Requirements](#minimum-requirements)
- [Installation](#installation)
- [Adding/Removing FacetWP Facets and Templates with the Builder](#addingremoving-facetwp-facets-and-templates-with-the-builder)
- [Composing Custom/3rd Party Addon Facets](#composing-custom3rd-party-addon-facets)
- [Hooks](#hooks)
- [Examples](#examples)
- [Credits](#credits)
- [License](#license)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Minimum Requirements

- PHP v8.1
- WordPress v6.1
- [FacetWP](https://facetwp.com) v4.0

## Installation

```bash
composer require danlapteacru/facetwp-builder
```

If your project isn't using composer, you can require the `autoload.php` file.

# Adding/Removing FacetWP Facets and Templates with the Builder

## Table of Contents

| [Facets](#facets)                   | [Templates](#templates)            |
|:------------------------------------|:-----------------------------------|
| [Autocomplete](#autocomplete)       | [Add a template](#add-a-template)  |
| [Checkbox](#checkbox)               |                                    |
| [Date Range](#date-range)           |                                    |
| [Dropdown](#dropdown)               |                                    |
| [fSelect](#fselect)                 |                                    |
| [Hierarchy](#hierarchy)             |                                    |
| [Number Range](#number-range)       |                                    |
| [Pager](#pager)                     |                                    |
| [Proximity](#proximity)             |                                    |
| [Radio](#radio)                     |                                    |
| [Reset](#reset)                     |                                    |
| [Search](#search)                   |                                    |
| [Slider](#slider)                   |                                    |
| [Sort](#sort)                       |                                    |
| [Star Rating](#star-rating)         |                                    |
| [User Selections](#user-selections) |                                    |

### Facet Types

You can find a full reference of available facets on the [official FacetWP documentation](https://facetwp.com/help-center/facets/facet-types/).

#### Autocomplete
```php
$builder->addAutocomplete('autocomplete', [
    'label' => 'Autocomplete',
    'source' => 'post_title',
    'placeholder' => 'Placeholder',
]);
```
[Official Documentation](https://facetwp.com/help-center/facets/facet-types/autocomplete/)

#### Checkboxes
```php
$builder->addCheckbox('checkbox', [
    'label' => 'Categories',
    'source' => 'tax/category',
    'parent_term' => '',
    'hierarchical' => 'no',
    'show_expanded' => 'no',
    'ghosts' => 'no',
    'preserve_ghosts' => 'no',
    'operator' => 'and',
    'orderby' => 'count',
    'count' => '10',
    'soft_limit' => '5',
]);
```
[Official Documentation](https://facetwp.com/help-center/facets/facet-types/checkboxes/)

#### Date Range
```php
$builder->addDateRange('date_range', [
    'label' => 'Date Range',
    'source' => 'post_date',
    'compare_type' => '',
    'fields' => 'both',
    'format' => '',
]);
```
[Official Documentation](https://facetwp.com/help-center/facets/facet-types/date-range/)

#### Dropdown
```php
$builder->addDropdown('dropdown', [
    'label' => 'Dropdown',
    'source' => 'tax/category',
    'label_any' => 'Any',
    'parent_term' => '',
    'modifier_type' => 'off',
    'modifier_values' => '',
    'hierarchical' => 'no',
    'orderby' => 'count',
    'count' => '10',
]);
```
[Official Documentation](https://facetwp.com/help-center/facets/facet-types/dropdown/)

#### fSelect
```php
$builder->addFselect('fselect', [
    'label' => 'fSelect',
    'source' => 'tax/category',
    'label_any' => 'Any',
    'parent_term' => '',
    'modifier_type' => 'off',
    'modifier_values' => '',
    'hierarchical' => 'no',
    'multiple' => 'no',
    'ghosts' => 'no',
    'preserve_ghosts' => 'no',
    'operator' => 'and',
    'orderby' => 'count',
    'count' => '10',
]);
```
[Official Documentation](https://facetwp.com/help-center/facets/facet-types/fselect/)

#### Hierarchy
```php
$builder->addHierarchy('hierarchy', [
    'label' => 'Hierarchy',
    'source' => 'tax/category',
    'label_any' => 'Any',
    'modifier_type' => 'off',
    'modifier_values' => '',
    'orderby' => 'count',
    'soft_limit' => '5',
]);
```
[Official Documentation](https://facetwp.com/help-center/facets/facet-types/hierarchy/)

#### Number Range
```php
$builder->addNumberRange('number_range', [
    'label' => 'Number Range',
    'source' => 'post_meta/price',
    'compare_type' => '',
    'fields' => 'both',
]);
```
[Official Documentation](https://facetwp.com/help-center/facets/facet-types/number-range/)

#### Pager
```php
$builder->addPager('pager', [
    'label' => 'Pager',
    'pager_type' => 'numbers',
    'inner_size' => '2',
    'dots_label' => '…',
    'prev_label' => '« Prev',
    'next_label' => 'Next »',
    'count_text_plural' => '[lower] - [upper] of [total] results',
    'count_text_singular' => '1 result',
    'count_text_none' => 'No results',
    'load_more_text' => 'Load more',
    'loading_text' => 'Loading...',
    'default_label' => 'Per page',
    'per_page_options' => '10, 25, 50, 100',
]);
```
[Official Documentation](https://facetwp.com/help-center/facets/facet-types/pager/)

#### Proximity
```php
$builder->addProximity('proximity', [
    'label' => 'Proximity',
    'source' => 'post_meta/location',
    'unit' => 'mi',
    'radius_ui' => 'dropdown',
    'radius_options' => '10, 25, 50, 100, 250',
    'radius_min' => '1',
    'radius_max' => '50',
    'radius_default' => '25',
    'placeholder' => '',
]);
```
[Official Documentation](https://facetwp.com/help-center/facets/facet-types/proximity/)

#### Radio
```php
$builder->addRadio('radio', [
    'label' => 'Radio',
    'source' => 'tax/category',
    'label_any' => 'Any',
    'parent_term' => '',
    'modifier_type' => 'off',
    'modifier_values' => '',
    'ghosts' => 'no',
    'preserve_ghosts' => 'no',
    'orderby' => 'count',
    'count' => '10',
]);
```
[Official Documentation](https://facetwp.com/help-center/facets/facet-types/radio/)

#### Reset
```php
$builder->addReset('reset', [
    'label' => 'Reset',
    'reset_ui' => 'button',
    'reset_text' => 'Reset',
    'reset_mode' => 'off',
    'auto_hide' => 'no',
    'reset_facets' => [],
]);
```
[Official Documentation](https://facetwp.com/help-center/facets/facet-types/reset/)

#### Search
```php
$builder->addSearch('search', [
    'label' => 'Search',
    'search_engine' => '',
    'placeholder' => '',
    'auto_refresh' => 'no',
]);
```
[Official Documentation](https://facetwp.com/help-center/facets/facet-types/search/)

#### Slider
```php
$builder->addSlider('slider', [
    'label' => 'Slider',
    'source' => 'post_meta/price',
    'compare_type' => '',
    'prefix' => '',
    'suffix' => '',
    'reset_text' => 'Reset',
    'format' => '0,0',
    'step' => '1',
]);
```
[Official Documentation](https://facetwp.com/help-center/facets/facet-types/slider/)

#### Sort
```php
$builder->addSort('sort', [
    'label' => 'Sort',
    'default_label' => 'Sort by',
    'sort_options' => [
        [
            'label' => 'Title (A-Z)',
            'name' => 'title_asc',
            'orderby' => [
                [
                    'key' => 'title',
                    'order' => 'ASC',
                    'type' => 'CHAR',
                ],
            ],
        ],
    ],
]);
```
[Official Documentation](https://facetwp.com/help-center/facets/facet-types/sort/)

#### Star Rating
```php
$builder->addRating('star_rating', [
    'label' => 'Star Rating',
    'source' => 'post_meta/rating',
]);
```
[Official Documentation](https://facetwp.com/help-center/facets/facet-types/rating/)

#### User Selections
```php
$builder->addUserSelections('user_selections', [
    'label' => 'User Selections',
]);
```
[Official Documentation](https://facetwp.com/help-center/facets/facet-types/user-selections/)

### Facet shortcut methods

Instead of passing all options as an array to the add method, you can chain setter methods on the returned `FacetBuilder`. All setters transform values automatically (booleans become `'yes'`/`'no'` strings).

```php
setName(string $name)
setLabel(string $label)
setSource(string $source)
setOperator(string $operator)
setOrderby(string $orderby)
setCount(int $count)
setHierarchical(bool $hierarchical)
setShowExpanded(bool $show_expanded)
setGhosts(bool $ghosts)
setPreserveGhosts(bool $preserve_ghosts)
setSoftLimit(int $soft_limit)
setLabelAny(string $label_any)
setMultiple(bool $multiple)
setSearchEngine(string $search_engine)
setPlaceholder(string $placeholder)
setAutoRefresh(bool $auto_refresh)
setStep(int $step)
setPrefix(string $prefix)
setSuffix(string $suffix)
setCompareType(string $compare_type)
setFormat(string $format)
setSourceOther(string $source_other)
```

For custom/arbitrary attributes not in the list above, use `setAttr(string $name, mixed $value)` directly.

### Managing facets

`FacetsBuilder` exposes the following methods for working with its facet collection:

```php
// Add all facets from another FacetsBuilder or a plain array
$builder->addFacets(array|FacetsBuilder $facets): static

// Retrieve facets
$builder->getFacets(): FacetBuilder[]
$builder->getFacet(string $name): FacetBuilder   // throws FacetNotFoundException

// Check existence
$builder->facetExists(string $name): bool
```

### Building and registering

Calling `build()` on the `FacetsBuilder` compiles the config and — by default — registers facets with FacetWP via the `facetwp_facets` WordPress filter.

```php
// Register with FacetWP (default)
$builder->build();

// Only build the array, skip WP hook registration
$builder->build(addArrayToWpHook: false);

// Register a pre-built array manually
FacetsBuilder::addFacetWpHook(array $facets): void
```

**Note:** calling `build()` on the `FacetBuilder` returned by `addSearch()` / `addCheckbox()` / etc. builds only that single facet's config array and does **not** register anything with WordPress. Always call `$builder->build()` on the `FacetsBuilder` instance to register.

### Templates

You can find a full reference of how to add a template with PHP on the [official FacetWP documentation](https://facetwp.com/help-center/developers/hooks/advanced-hooks/facetwp_templates/).

#### Add a template

Use `addTemplate(string $name, array $args = [])` to add a template. It returns a `TemplateBuilder` for further configuration.

Example using the array form:

```php
$builder->addTemplate('course', [
    'label' => 'Course',
    'query_array' => [
        'post_type' => 'course',
        'post_status' => 'publish',
        'posts_per_page' => 10,
        'orderby' => 'title',
        'order' => 'ASC',
    ],
    'modes' => [
        'display' => 'visual',
        'query' => 'advanced',
    ],
]);
```

**Attention!** The `query` key must contain a PHP code string. Use the `setQuery()` helper instead to pass a plain array and have it converted automatically.

#### Template shortcut methods

```php
setName(string $name)
setLabel(string $label)
setQuery(array $query)       // converts array to PHP string automatically
setQueryObj(array $query)
setLayout(array $layout)
setModes(array $modes)
setPostType(string $postType)       // throws Exception if post type not found
setPostsPerPage(int $postsPerPage)
```

Example using chainable setters:

```php
$builder
    ->addTemplate('course')
    ->setLabel('Course')
    ->setQuery([
        'post_type' => 'course',
        'post_status' => 'publish',
        'posts_per_page' => 10,
        'orderby' => 'title',
        'order' => 'ASC',
    ])
    ->setModes([
        'display' => 'visual',
        'query' => 'advanced',
    ]);
$builder->build();
```

`setPostType()` and `setPostsPerPage()` are convenience helpers that update both `query` and `query_obj` in one call:

```php
$builder
    ->addTemplate('course')
    ->setPostType('course')
    ->setPostsPerPage(9);
$builder->build();
```

##### Default label
If `setLabel()` is not called and no `label` key is passed to `addTemplate()`, the label is auto-generated from the template name.

##### Default modes
If `setModes()` is not called and no `modes` key is passed, the following defaults are used:

```php
[
    'display' => 'visual',
    'query' => 'advanced',
]
```

### Managing templates

`TemplatesBuilder` exposes the following methods for working with its template collection:

```php
// Add all templates from another TemplatesBuilder or a plain array
$builder->addTemplates(array|TemplatesBuilder $templates): static

// Retrieve templates
$builder->getTemplates(): TemplateBuilder[]
$builder->getTemplate(string $name): TemplateBuilder   // throws FacetNotFoundException

// Check existence
$builder->templateExists(string $name): bool
```

### Building and registering templates

```php
// Register with FacetWP (default)
$builder->build();

// Only build the array, skip WP hook registration
$builder->build(addTemplatesToWpHook: false);

// Register a pre-built array manually
TemplatesBuilder::addFacetWpHook(array $templates): void
```

## Composing Custom/3rd Party Addon Facets

Use `addFacet(string $name, string $type, array $args = [])` to add a facet with an arbitrary type string.

```php
$builder->addFacet('my_facet', 'checkbox', [
    'label' => 'My Facet Label',
]);
```

To use a type not in the built-in [`ALLOWED_FACET_TYPES`](https://github.com/danlapteacru/facetwp-builder/blob/main/src/FacetsBuilder.php#L66) constant, register it via the [`danlapteacru/facetwp-builder/allowed_facet_types`](#danlapteacrufacetwp-builderallowed_facet_types) filter hook.

## Hooks

### `danlapteacru/facetwp-builder/allowed_facet_types`

Filter the list of allowed facet types. Use this to add support for custom or 3rd-party addon types.

```php
add_filter('danlapteacru/facetwp-builder/allowed_facet_types', function (array $types): array {
    $types[] = 'my_custom_type';
    return $types;
});
```

### `danlapteacru/facetwp-builder/facets`

Filter the compiled facets array before it is returned by `FacetsBuilder::build()`.

### `danlapteacru/facetwp-builder/facet_key`

Filter the resolved facet type key before it is validated inside `FacetsBuilder::__call()`. Useful for aliasing method names to custom type strings.

### `danlapteacru/facetwp-builder/templates`

Filter the compiled templates array before it is returned by `TemplatesBuilder::build()`.

## Examples

### Table of Contents

| Examples                                  |
|:------------------------------------------|
| [Add Facets](#add-facets)                 |
| [Add a custom facet](#add-a-custom-facet) |
| [Add Template](#add-template)             |

### Add Facets

```php
use DanLapteacru\FacetWpBuilder\FacetsBuilder;

$builder = new FacetsBuilder();
$builder
    ->addSearch('search')
    ->setLabel('Search')
    ->setPlaceholder('Search placeholder')
    ->setAutoRefresh(true);
$builder->build();
```

### Add a custom facet

```php
use DanLapteacru\FacetWpBuilder\FacetBuilder;
use DanLapteacru\FacetWpBuilder\Facets\Checkbox;
use DanLapteacru\FacetWpBuilder\FacetsBuilder;

$facet = new FacetBuilder('my_facet', Checkbox::TYPE);
$facet
    ->setLabel('Categories')
    ->setSource('tax/category');
$facetArray = $facet->build();

FacetsBuilder::addFacetWpHook($facetArray);
```

### Add Template

```php
use DanLapteacru\FacetWpBuilder\TemplatesBuilder;

$builder = new TemplatesBuilder();
$builder
    ->addTemplate('course')
    ->setLabel('Courses')
    ->setQuery([
        'post_type' => 'course',
        'post_status' => 'publish',
        'posts_per_page' => 8,
        'orderby' => 'title',
        'order' => 'ASC',
    ]);
$builder->build();
```

## Credits

[FacetWP Builder](https://github.com/danlapteacru/facetwp-builder) is created and maintained by [Dan Lapteacru](https://github.com/danlapteacru).

Full list of contributors can be found [here](https://github.com/danlapteacru/facetwp-builder/graphs/contributors).

## License

[FacetWP Builder](https://github.com/danlapteacru/facetwp-builder) is released under the [MIT License](https://opensource.org/licenses/MIT).
