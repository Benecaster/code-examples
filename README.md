# Benecaster Code Examples

PHP code examples for the [Benecaster](https://benecaster.com) WordPress plugin developer documentation.

Each file in this repository corresponds to a recipe page at [benecaster.com/docs](https://benecaster.com/docs). Recipe pages pull the code directly from this repository and display it inline, with a "View on GitHub →" link for history, forking, and Copilot context.

## Structure

Files are organized by add-on scope:

```
core/                        # Core plugin — no add-on required
  analytics/
  bridges/
  emails/
  episodes/
  feeds/
  fields/
  redirects/
  rest-api/
  support-mode/
  subscribers/
addon-migration-wizard/      # Requires the Migration Wizard add-on
addon-email-editor/          # Requires the Email Editor add-on
```

One `.php` file per recipe, named after the recipe slug (e.g. `core/support-mode/react-to-support-mode-lifecycle.php`).

## PHP Compatibility

Examples target **PHP 8.1+** and are validated against PHP 8.1, 8.2, and 8.3 via GitHub Actions on every push.

## Using the Examples

Copy the snippet into your plugin or theme's `functions.php`. Each file is self-contained — no Composer dependencies, no build step. Some snippets assume the Benecaster plugin is active; a few require a specific add-on (noted in the corresponding recipe page).

## Contributing

This repository is maintained by the Benecaster team. If you spot an error in an example — a typo, a deprecated API call, a broken hook name — please open an issue and we'll fix it. Pull requests for corrections are welcome.

New recipes are planned and written alongside plugin releases and are not accepted as community contributions at this time.

## License

MIT. The examples are intentionally permissive — copy, adapt, and ship without attribution.
