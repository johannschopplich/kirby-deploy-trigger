# Kirby Deploy Trigger

Kirby CMS Panel plugin that adds a view button to start a deployment through a deploy hook that the server calls; the hook URL and `requestOptions` never reach the browser.

## Commands

```bash
composer test          # PHPUnit
composer csfix         # php-cs-fixer, lives in tools/phpcs/vendor/bin/, not vendor/bin/
pnpm run test:types    # typecheck with tsc, which does not reach .vue files
pnpm run lint          # ESLint
pnpm run format        # Prettier for src/panel, checked in CI
pnpm run build         # build the Panel bundle (index.js)
```

## Search Hints

- `__deploy-trigger__/hook` – API route that sends the request to the deploy hook
- `johannschopplich.deploy-trigger` – permission category, option and translation prefix
- `legacyViewButtonMixin` – Kirby 4 backport that mounts the button into the site view's header
