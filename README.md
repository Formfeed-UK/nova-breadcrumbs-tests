## Nova Breadcrumbs Tests

Repository to hold the Tests for the [Nova Breadcrumbs](https://github.com/Formfeed-UK/nova-breadcrumbs) package.

This repository includes a devcontainer which will configure an environment to run the Tests for this package. It can be used locally in Docker and VSCode or through GitHub Codespaces.

You will need to use your nova credentials in the container to install nova, if you don't have a codespaces secret set up for `COMPOSER_AUTH`

After the postInstallScript is complete, simply run `php artisan test` to run the tests.

PR's for missing test cases are always appreciated.
