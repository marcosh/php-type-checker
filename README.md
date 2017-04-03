# Php return type checker

[![Build Status](https://travis-ci.org/marcosh/php-type-checker.svg?branch=master)](https://travis-ci.org/marcosh/php-type-checker)
[![Code Climate](https://codeclimate.com/github/marcosh/php-type-checker/badges/gpa.svg)](https://codeclimate.com/github/marcosh/php-type-checker)
[![Coverage Status](https://coveralls.io/repos/github/marcosh/php-type-checker/badge.svg?branch=master)](https://coveralls.io/github/marcosh/php-type-checker?branch=master)
[![Code Quality](https://api.codacy.com/project/badge/grade/ff95c3e5360649638c61f2834bffd8b2)](https://www.codacy.com/app/marcosh/php-type-checker/dashboard)

Checks if type hints are present and coherent with doc block declarations

## Install

Install using [Composer](https://getcomposer.org).

Add 

```
{
    "url": "git@github.com:marcosh/php-return-type-checker.git",
    "type": "git"
}
```

among the repositories of your `composer.json` and then use

```
composer require marcosh/php-return-type-checker
```

## Usage

To scan the content of a directory `$PATH`,

```
vendor/bin/ptc check $PATH
```
