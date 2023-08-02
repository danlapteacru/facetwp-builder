# FacetWP Builder

Create, register, and reuse [FacetWP](https://facetwp.com/) plugin facets/templates using PHP, and keep them in your source code repository. To read more about registering FacetWP facets and templates via PHP, go here: [facets documentation](https://facetwp.com/help-center/developers/hooks/advanced-hooks/facetwp_facets/) and [templates documentation](https://facetwp.com/help-center/developers/hooks/advanced-hooks/facetwp_templates/).

[![Packagist Version](https://img.shields.io/packagist/v/danlapteacru/facetwp-builder.svg?label=release&style=flat-square)](https://packagist.org/packages/danlapteacru/facetwp-builder)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/danlapteacru/facetwp-builder.svg?style=flat-square)](https://packagist.org/packages/danlapteacru/facetwp-builder)
[![Packagist Downloads](https://img.shields.io/packagist/dt/danlapteacru/facetwp-builder.svg?label=packagist%20downloads&style=flat-square)](https://packagist.org/packages/danlapteacru/facetwp-builder/stats)
[![GitHub License](https://img.shields.io/github/license/danlapteacru/facetwp-builder.svg?style=flat-square)](https://github.com/danlapteacru/facetwp-builder/blob/master/LICENSE)
[![Hire Me](https://img.shields.io/badge/Hire-Me-ff69b4.svg?style=flat-square)](danlapteacru@gmail.com)

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
| [fSelect](#f-select)                |                                    |
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
$builder
    ->addAutocomplete('autocomplete', [
        'label' => 'Autocomplete',
        'source' => 'post_title',
        'placeholder' => 'Placeholder',
  ]);
```
[Official Documentation](https://facetwp.com/help-center/facets/facet-types/autocomplete/)

#### Checkboxes
```php
$builder
    ->addCheckbox('checkbox', [
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
$builder
    ->addDateRange('date_range', [
        'label' => 'Date Range',
        'source' => 'post_type',
        'compare_type' => '',
        'fields' => 'both',
        'format' => '',
  ]);
```
[Official Documentation](https://facetwp.com/help-center/facets/facet-types/date-range/)

#### Dropdown
```php
$builder
    ->addDropdown('dropdown', [
        'label' => 'Dropdown',
        'source' => 'post_type',
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
$builder
    ->addFselect('fselect', [
        'label' => 'fSelect',
        'source' => 'post_type',
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
$builder
    ->addHierarchy('hierarchy', [
        'label' => 'Hierarchy',
        'source' => 'post_type',
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
$builder
    ->addNumberRange('number_range', [
        'label' => 'Number Range',
        'source' => 'post_type',
        'compare_type' => '',
        'fields' => 'both',
  ]);
```
[Official Documentation](https://facetwp.com/help-center/facets/facet-types/number-range/)

#### Pager
```php
$builder
    ->addPager('pager', [
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
$builder
    ->addProximity('proximity', [
        'label' => 'Proximity',
        'source' => 'post_type',
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
$builder
    ->addRadio('radio', [
        'label' => 'Radio',
        'source' => 'post_type',
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
$builder
    ->addReset('reset', [
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
$builder
    ->addSearch('search', [
        'label' => 'Search',
        'search_engine' => '',
        'placeholder' => '',
        'auto_refresh' => 'no',
  ]);
```
[Official Documentation](https://facetwp.com/help-center/facets/facet-types/search/)

#### Slider
```php
$builder
    ->addSlider('slider', [
        'label' => 'Slider',
        'source' => 'post_type',
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
$builder
    ->addSort('sort', [
        'label' => 'Sort',
        'type' => 'sort',
        'default_label' => 'Sort by',
        'sort_options' => [
            [
                'label' => 'post_title',
                'name' => 'post_title',
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
$builder
    ->addRating('star_rating', [
        'label' => 'Star Rating',
        'source' => 'post_type',
  ]);
```
[Official Documentation](https://facetwp.com/help-center/facets/facet-types/rating/)

#### User Selections
```php
$builder
    ->addUserSelections('user_selections', [
        'label' => 'User Selections',
  ]);
```
TODO: Add available options.

[Official Documentation](https://facetwp.com/help-center/facets/facet-types/user-selections/)

### Shortcut functions
If you don't want to use the second parameter of the add method, you can use the following shortcut functions:

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

### Templates

You can find a full reference of how to add a template with PHP on the [official FacetWP documentation](https://facetwp.com/help-center/developers/hooks/advanced-hooks/facetwp_templates/).

#### Add a template

You can add a template by using the `addTemplate` method.

Example:

```php
$builder
    ->addTemplate('course', [
        'name' => 'course',
        'label' => 'Course',
        'type' => 'course',
        'query_array' => [
            'post_type' => 'course',
            'post_status' => 'publish',
            'posts_per_page' => 10,
            'orderby' => 'title',
            'order' => 'asc'
        ],
        'query' => '<?php
return [
  \'post_type\' => \'course\',
  \'post_status\' => \'publish\',
  \'posts_per_page\' => 10,
  \'orderby\' => \'title\',
  \'order\' => \'asc\',
];',
        'modes' => [
            'display' => 'visual',
            'query' => 'advanced'
        ],
        '_code' => true
    ],
  ]);
```

**Attention!** The `query` key should contain a PHP code string. If you prefer to use a PHP array, utilize the `query_obj` key instead.

Here are some available declarative shortcut functions for the `addTemplate` method:

```php
$builder
    ->addTemplate('course')
    ->setLabel('Course')
    ->setQuery([
      'post_type' => 'course',
      'post_status' => 'publish',
      'posts_per_page' => 10,
      'orderby' => 'title',
      'order' => 'asc',
    ])
    ->setQueryObj([
      'post_type' => 'course',
    ])
    ->setLayout([])
    ->setModes([
      'display' => 'visual',
      'query' => 'advanced',
    ])
```

If you dont want to specify the `query` or `query_obj` keys, you can use the `setPostType` and `setPostsPerPage` methods to define the `post_type` and `posts_per_page` arguments.

Example:

```php
$builder
    ->addTemplate('course')
    ->setPostType('course')
    ->setPostsPerPage(23)
```

##### Default Label
If `setLabel` is not set, or the `addTemplate` arguments do not contain the `label` key, then the label will be generated from the template name/key.

##### Default Modes
If `setModes` is not set, or the `addTemplate` arguments do not contain the `modes` key, then the default `modes` will be used:

```php
[
    'display' => 'visual',
    'query' => 'advanced',
]
```

## Composing Custom/3rd Party Addon Facets

You can use the `addFacet` method to add a custom/3rd party addon facet.

`addFacet(string $name, string $type, array $args = [])`

Example:

```php
$builder
    ->addFacet('myFacetName', 'checkbox', [
      'label' => 'My Facet Label',
    ]);
```

If you want to use a facet type which is not defined in the [ALLOWED_CONFIG_KEYS](https://github.com/danlapteacru/facetwp-builder/blob/main/src/FacetBuilder.php#L48) constant, you can use the `addAllowedFacetType` method or [danlapteacru/facetwp-builder/allowed_facet_types](#danlapteacrufacetwp-builderallowedfacettypes) hook to add it.

## Hooks

You can use the following hooks to modify the FacetWP Builder:

### `danlapteacru/facetwp-builder/allowed_facet_types`

You can use this hook to add custom facet types to the FacetWP Builder.

### `danlapteacru/facetwp-builder/facets`

You can use this hook to modify the facets array before it is returned.

### `danlapteacru/facetwp-builder/facet_key`

You can use this hook to modify the facet key before it is used to check if facet type exists.

### `danlapteacru/facetwp-builder/templates`

You can use this hook to modify the templates array before it is returned.

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
    ->setAutoRefresh(true)
    ->build();
```

### Add a custom facet

```php
use DanLapteacru\FacetWpBuilder\FacetBuilder;
use DanLapteacru\FacetWpBuilder\Facets\Checkbox;
use DanLapteacru\FacetWpBuilder\FacetsBuilder;

$facet = new FacetBuilder(static::FACET_NAME, Checkbox::TYPE);
$facet
    ->setLabel('Search')
    ->setPlaceholder('Search placeholder')
    ->setAutoRefresh(true);
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
    ])
    ->build();
```

## Credits

[FacetWP Builder](https://github.com/danlapteacru/facetwp-builder) is created by [Dan Lapteacru](https://github.com/danlapteacru).

Full list of contributors can be found [here](https://github.com/danlapteacru/facetwp-builder/graphs/contributors).

## License

[FacetWP Builder](https://github.com/danlapteacru/facetwp-builder) is released under the [MIT License](https://opensource.org/licenses/MIT).
