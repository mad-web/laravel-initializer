# Changelog

All Notable changes to `laravel-initializer` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## 3.3.2 - Under Development

Laravel 9 support

## 3.3.1 - 2020-12-20

Fixed earlier Laravel versions support

## 3.3.0 - 2020-12-19

- PHP 8 support
- dropped PHP 7.2 support

## 3.2.0 - 2020-09-16

Laravel 8 support

## 3.1.1 - 2020-04-18

Fixed commands crash, when failed action hasn't provide an error message

## 3.1.0 - 2020-03-17

No longer required to return `Runner` class instance

## 3.0.0 - 2020-03-04

- Laravel 7 support
- Dropped support for Laravel 5.5 and 5.8
- Minimum required PHP version 7.2.5

## 2.0.2 - 2020-01-09

Now Initializer returns appropriate exit codes

## 2.0.1 - 2019-10-21

Fixed typo in commands title

## 2.0.0 - 2019-10-21

It's major release with code polishing, beautified output and several nice features.

`app:install` and `app:update` commands output now much more expressive. You can check out new output in the [README](README.md) demo. Made with [nunomaduro/laravel-console-task](https://github.com/nunomaduro/laravel-console-task).

- Commands output are hidden by default
- Output details of execution could be viewed in verbosity mode
- Ability to publish multiple tags for one provider
- Ability to publish by tags only
- Replaced `make:initializers` command by publishing `initializers` tag
- Updated default initializer stubs

## 1.4.0 - 2019-09-06

- Laravel 6.0 support
- Minimum required PHP version upped to 7.2
- Dropped support of unsupported Laravel versions

## 1.3.0 - 2019-03-13

Laravel 5.8 support

## 1.2.1 - 2018-10-22

Improved default stubs

## 1.2.0 - 2018-10-21

### Added

- Ability to force publish
- `composer install` to default commands chain in stubs

## 1.1.0 - 2018-09-23

### Added

- Laravel 5.7 support

## 1.0.1 - 2018-04-24

### Removed

- deprecated linting option from styleci config

## 1.0.0 - 2018-03-03

This version contains two breaking changes, please see [UPGRADING](UPGRADING.md) for details.

### Added

- `app:update` command which runs defined commands for updating your application
- documentation improved

### Changed

- default name of `project.installer` class changed from `InstallerConfig` to `Install`
- constructor parameter signature for `Executor` contract changed from `$installCommand` to `$artisanCommand`

## 0.4.0 - 2018-03-02

### Added

- test cases
- `MakeEchoServerConfig` job updated with latest version of `laravel-echo-server` configuration
- ability to pass publishable providers as string

### Changed

- `laravel/framework` is now required for use `MakeSocketSupervisorConfig`, `MakeQueueSupervisorConfig`, `MakeCronTask`, `MakeEchoServerConfig` jobs
- laravel `files` service usage replaced by simple `file_put_contents` function
- Now command `external('ls -la')` doesn't cast 1st param into array, just passes as string

### Fixed

- conflict for Laravel 5.5 and `symfony/process:~4.0`, Laravel 5.5 uses `~3.0` version. Laravel Initializer now support `symfony/process:~3.0|~4.0`
- Fixed overriding default config for `MakeEchoServerConfig`, now it uses `array_replace_recursive()` function

### Removed

- TravisCI PHP tests on 7.0

## 0.3.0 - 2018-02-15

- Add compatiblity for Laravel 5.6
- Make compatible with `symfony/process:~4.0`

## 0.2.1 - 2017-10-18

- Fixed config jobs
- Added `publish` command type for publishing assets

## 0.2.0 - 2017-10-03

- Add compatiblity for Laravel 5.5
