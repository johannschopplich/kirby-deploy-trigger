# Kirby Deploy Trigger

Kirby CMS Panel plugin that adds a view button to start a deployment through a deploy hook that the server calls; the hook URL and `requestOptions` never reach the browser.

## Commands

```bash
composer test
composer csfix         # lives in tools/phpcs/vendor/bin/, not vendor/bin/
pnpm run test --run
pnpm run test:types
pnpm run lint
pnpm run format        # src/panel/ and tests/panel/, checked in CI
pnpm run build         # after a change in src/panel/; index.js is committed
```

## Conventions

- The plugin ships without `vendor/`, so it takes no runtime Composer dependency.
- `src/panel/site.ts` feeds kirby.tools' Panel mocks.
