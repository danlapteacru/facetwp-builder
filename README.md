# FacetWP Builder

[![Packagist Version](https://img.shields.io/packagist/v/itinerisltd/facetwp-builder.svg?label=release&style=flat-square)](https://packagist.org/packages/itinerisltd/post-types)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/itinerisltd/facetwp-builder.svg?style=flat-square)](https://packagist.org/packages/itinerisltd/post-types)
[![Packagist Downloads](https://img.shields.io/packagist/dt/itinerisltd/facetwp-builder.svg?label=packagist%20downloads&style=flat-square)](https://packagist.org/packages/itinerisltd/post-types/stats)
[![GitHub License](https://img.shields.io/github/license/itinerisltd/facetwp-builder.svg?style=flat-square)](https://github.com/ItinerisLtd/post-types/blob/master/LICENSE)
[![Hire Itineris](https://img.shields.io/badge/Hire-Itineris-ff69b4.svg?style=flat-square)](https://www.itineris.co.uk/contact/)
[![Twitter Follow @itineris_ltd](https://img.shields.io/twitter/follow/itineris_ltd?style=flat-square&color=1da1f2)](https://twitter.com/itineris_ltd)

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->

- [Minimum Requirements](#minimum-requirements)
- [Installation](#installation)
- [Adding/Removing FacetWP Listings or Facets with the Builder](#addingremoving-facetwp-listings-or-facets-with-the-builder)
- [Credits](#credits)
- [License](#license)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Minimum Requirements

- PHP v8.1
- WordPress v6.1
- Acorn v3 by [roots.io](https://roots.io/)

## Installation

```bash
composer require itinerisltd/facetwp-builder
```

You can publish the default config file with:

```shell
wp acorn vendor:publish --provider="Itineris\FacetWpBuilder\Providers\FacetWpBuilderServiceProvider"
```

This will copy the config file to your project e.g. `bedrock/web/app/themes/sage/config/postmate.php`

## Adding/Removing FacetWP Listings or Facets with the Builder

TODO: Add instructions for adding new FacetWP listings and facets with the builder.

## Credits

[FacetWP Builder](https://github.com/ItinerisLtd/facetwp-builder) is a [Itineris Limited](https://www.itineris.co.uk/) project created by [Dan Lapteacru](https://github.com/danlapteacru).

Full list of contributors can be found [here](https://github.com/ItinerisLtd/facetwp-builder/graphs/contributors).

## License

[FacetWP Builder](https://github.com/ItinerisLtd/facetwp-builder) is released under the [MIT License](https://opensource.org/licenses/MIT).
