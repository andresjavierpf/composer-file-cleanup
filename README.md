# Composer File Cleanup

A Composer plugin to clean up unnecessary files from installed dependencies.

## Installation

The plugin can be installed using Composer:

```shell
composer require andresjavierpf/composer-file-cleanup
```

## Usage

This plugin helps to remove unnecessary files from the installed Composer packages. By default, it excludes files like `README`, `CHANGELOG`, and `LICENSE`.

To customize the files to be excluded, you can define them in the root `composer.json` under the extra section. The list of paths must be relative to the vendor directory.

###### Example: Exclude files README, CHANGELOG, LICENSE from all dependencies and SECURITY.md from Google Apiclient Services

```json
{
	"require": {
		"andresjavierpf/composer-file-cleanup": "^0.1"
	},
	"extra": {
		"exclude-files": [
			"README.md",
			"CHANGELOG.md",
			"LICENSE",
			"google/apiclient-services/SECURITY.md"
		]
	}
}
```

This plugin will automatically run before Composer's autoloader is generated, ensuring that the specified files are removed from the autoload map. Please note that this plugin only operates on the root `composer.json`.

## License

This library is licensed under the MIT License.
