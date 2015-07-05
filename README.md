# Dashboard
[![Build Status](https://img.shields.io/travis/odotmedia/dashboard.svg)](https://travis-ci.org/odotmedia/dashboard)
[![Github Release](https://img.shields.io/github/release/odotmedia/dashboard.svg)](https://packagist.org/packages/odotmedia/dashboard)
[![Packagist](https://img.shields.io/packagist/dt/odotmedia/dashboard.svg)](https://packagist.org/packages/odotmedia/dashboard)
[![License](https://img.shields.io/github/license/odotmedia/dashboard.svg)](https://packagist.org/packages/odotmedia/dashboard)

A Laravel 5.1 (LTS) modern admin dashboard package. This is a base package to use to quickly start a project. Functionality and workflow for events, emails, listeners have all been left out of this package so you can do whatever fits your project.

## Features
- **Clean Admin** - Based on Bootstrap 3 + SB Admin 2
- **Clean Preconfigured** - It has default users and models you need.
- **Powerful** - Utilizes Cartalyst Sentinel for Authorization and Authentication.
- **Sentinel** - Authorization, Activations, Roles, Permissions all ready to use.

## Setup
### Installation
Odot Media packages utilize [Composer](http://getcomposer.org/), for more information on how to install Composer please read the [Composer Documentation](https://getcomposer.org/doc/00-intro.md).

#### Preperation
---
Open your `composer.json` file and add the following to the `require` array:

```
"odotmedia/dashboard": "1.0.*"
```

> **Note:** Make sure that after the required changes your `composer.json` file is valid running `composer validate`.

### Install the dependencies

Run Composer to install or update the new requirement.

```bash
$ composer install
```

or

```bash
$ composer update
```

## Documentation

Check out the official [Wiki](https://github.com/odotmedia/dashboard/wiki) page.

## Credits
- [SB Admin 2](http://startbootstrap.com/template-overviews/sb-admin-2/) - Admin Dashboard Template
- [Sentinel](https://cartalyst.com/manual/sentinel/2.0) - Authorization & Authentication Package