# A Composer installer for Moodle

This Composer plugin allows Moodle plugins to be installed into the correct locations within the Moodle directory.

It is compatible with Moodle versions 5.1 and up.

## Usage

## As a package maintainer

Your plugin should have a `composer.json` which defines the following fields:

- `name` in the format `moodle-[plugintype]_[pluginname]`
- `type` of `moodle-[plugintype]`.

## As a site administrator

You should depend upon this plugin:

```sh
composer require moodle/composer-installer
```

For an example, see the [Moodle Seed](https://github.com/moodle/seed) project.

## As the developer of a Moodle plugin

This plugin can be used to help you install Moodle plugins using Composer on Moodle versions 5.1 and up.

If you have written a Moodle plugin, we recommend that you add `moodle/composer-installer` as a dependency and do not pin the version:

```sh
composer require moodle/composer-installer:"*"
```

We also recommend that you set `moodle/moodle` as a dependency set to the minimum major version of Moodle that you support, for example:

```sh
composer require moodle/moodle:^5.1
```

Note: This will install Moodle into the `/moodle` directory in your repository. We recommend also adding this to your `.gitignore`.
