<div align="center">
  <a href="https://kirby.tools/deploy-trigger"><img src="./.github/favicon.svg" alt="Kirby Deploy Trigger logo" width="120"></a>

# Kirby Deploy Trigger

Kirby Deploy Trigger is a plugin for [Kirby CMS](https://getkirby.com) that adds a Panel button to start a deployment on Vercel, Netlify, GitHub Actions, or any service with a deploy hook. Your server sends the request, so the hook URL and any token stay in `config.php`.

[Configuration](https://kirby.tools/docs/deploy-trigger/configuration) •
[Permissions](https://kirby.tools/docs/deploy-trigger/permissions) •
[Platforms](https://kirby.tools/docs/deploy-trigger/platforms)

</div>

## When to Use

| I want to…                                                      | Use                                       |
| --------------------------------------------------------------- | ----------------------------------------- |
| Rebuild a static or headless frontend after editing content     | `deploy-trigger` view button              |
| Place the button in the site view or a page view                | `buttons` in the blueprint                |
| Show the button in every page view                              | `panel.viewButtons` option                |
| Keep a role from deploying                                      | `deploy` permission in the role blueprint |
| Send a token, a JSON body, or another HTTP method with the hook | `requestOptions` option                   |

## Requirements

- Kirby 4 or Kirby 5

## Installation

### Composer (Recommended)

```bash
composer require johannschopplich/kirby-deploy-trigger
```

### Manual Installation

Download a [release](https://github.com/johannschopplich/kirby-deploy-trigger/releases) and extract it to `/site/plugins/kirby-deploy-trigger`.

## Documentation

For installation, configuration, and usage, see the [Kirby Deploy Trigger documentation](https://kirby.tools/docs/deploy-trigger).

## License

[MIT](./LICENSE) License © 2025-PRESENT [Johann Schopplich](https://github.com/johannschopplich)
