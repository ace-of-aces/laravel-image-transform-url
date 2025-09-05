# CONTRIBUTING

Contributions are welcome, and are accepted via pull requests.
Please review these guidelines before submitting any pull requests.

## Process

1. Fork the project
1. Create a new branch
1. Code, test, commit and push
1. Open a pull request detailing your changes.

## Guidelines

* Please ensure the coding style running `composer lint`.
* Send a coherent commit history, making sure each individual commit in your pull request is meaningful.
* You may need to [rebase](https://git-scm.com/book/en/v2/Git-Branching-Rebasing) to avoid merge conflicts.
* Please remember that we follow [SemVer](http://semver.org/).

## 1. Package Development

> ![CAUTION]
> For package testing, both `GD` and `Imagick` drivers must be installed and enabled.

### Setup

Clone your fork, then install the dev dependencies:
```bash
composer install
```


Build workbench:
```bash
composer build
```

### Playground

You can visit a test application via [Workbench](https://github.com/orchestral/workbench):
```bash
composer serve
```

### Lint

Lint your code:
```bash
composer lint
```
### Tests

Run all tests:
```bash
composer test
```

## 2. Documentation

The documentation is built using [Vitepress](https://vitepress.dev/).

We use [pnpm](https://pnpm.io/) for package management.

To run the site locally, run:
```bash
cd docs
pnpm i
pnpm dev
```
