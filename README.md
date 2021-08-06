# PHPXC

CLI to manage PHP project creation 📦

There are a lot of tools nowadays to setup your very first project 
such as configuring linters, static analyzers, testing, preparing composer configuration,
CI, CD, containerization...

PHPXC is a CLI that helps you manage all that stuff.

Highly inspired of [TSDX](https://tsdx.io/)

![Promo](./resources/promo.gif)

## Why not just create a template on GitHub?

1) You need to keep up to date your dependencies
2) You will probably need to remove some tools you are not needed for a specific project
3) You will create a plenty of repositories to cover basic use-cases

## What you can do with a PHPXC?

1) Create a specific project which meets your needs
2) Create [custom template](./resources/doc/template.md), reuse it and share
3) Automate creation with a commands and cover with validations
4) Be up to date with the latest version and get most actual and hype
   technologies without any effort

## Requirements

* UNIX (as console rendering depends on `stty` tool)
* PHP 8.0 + yarn extension

## Installation

```shell
composer global require lsbproject/phpxc
```

or use docker

```shell
docker run -v "$PWD":/home/phpxc -it 22116/phpxc
```

## Usage

There is a main command `create` to build a template. (Also there are several 
developing helper commands which this documentation will not cover)

```shell
phpxc create <project-path>
```

This will trigger default `standard` template to be asked. You can also change this behaviour
specifying template option:

```shell
phpxc create -t <template-path/saved-template-name/repository-url> <project-path>
```

Pass all questions and chill.

## ToDo

* Improve `standard` template with a more options
* Make `standard` template review. Probably it should be split
  with several templates (cli / web / library / microservice...),
  because of anarchy in the code right now
* Add more templates
* Remove `stty` required dependency
* (Might not be) Consider to make template inheritance
