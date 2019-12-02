# Advanced Custom Fields: IcoMoon #

## Description ##

This adds an IcoMoon icon select field to ACF.

## Important to know ##

In case you want to include this small plugin to your project running composer you can add this line to your composer.json :

```json
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/jameelmoses/acf-icomoon"
    }
  ]
```

then run the command :

```shell
composer require jameelmoses/acf-icomoon
```

## Tips ##

### Using this with your own font icon in your own theme ###

Font family name, font files dir path and font files URL are filterable.

```php
/**
 * Update icon file css path.
 *
 * @return string
 */
function override_acf_icomoon_filepath() {
	return get_stylesheet_directory() . '/assets/css/icons.css';
}
add_filter( 'icomoon_filepath', 'override_acf_icomoon_filepath' );

/**
 * Update icon file css url
 *
 * @return string
 */
function override_acf_icomoon_fileurl() {
	return get_stylesheet_directory_uri() . '/assets/css/icons.css';
}
add_filter( 'icomoon_fileurl', 'override_acf_icomoon_fileurl' );

/**
 * Update icon files.
 *
 * @return array
 */
function override_acf_icomoon_fonts() {
	return array(
    'woff2' => get_stylesheet_directory_uri() . '/assets/fonts/icomoon.woff?ousyjt',
    'ttf'  => get_stylesheet_directory_uri() . '/assets/fonts/icomoon.ttf?ousyjt',
    'woff' => get_stylesheet_directory_uri() . '/assets/fonts/icomoon.woff?ousyjt',
    'svg'  => get_stylesheet_directory_uri() . '/assets/fonts/icomoon.svg?ousyjt#icomoon'
	);
}
add_filter( 'icomoon_fonts', 'override_acf_icomoon_fonts' );

/**
 * font family for theme
 */
function override_acf_icomoon_font_family() {
    return 'icomoon';
}
add_filter( 'icomoon_font_family_name', 'override_acf_icomoon_font_family' );
```
