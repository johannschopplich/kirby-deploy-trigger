<div align="center">
  <img src="./.github/favicon.svg" alt="Kirby Deploy Trigger logo" width="120">

# Kirby Deploy Trigger

Kirby Deploy Trigger is a plugin for [Kirby CMS](https://getkirby.com) that adds a Panel button to start a deployment on Vercel, Netlify, GitHub Actions, or any service with a deploy hook.

[Features](#features) •
[Options](#options) •
[Recipes](#recipes)

</div>

## When to Use

| I want to…                                                      | Use                                       |
| --------------------------------------------------------------- | ----------------------------------------- |
| Rebuild a static or headless frontend after editing content     | `deploy-trigger` view button              |
| Place the button in the site view or a page view                | `buttons` in the blueprint                |
| Show the button in every site or page view                      | `panel.viewButtons` option                |
| Keep a role from deploying                                      | `deploy` permission in the role blueprint |
| Send a token, a JSON body, or another HTTP method with the hook | `requestOptions` option                   |

## Features

### 🚀 Deploy Button

Add the `deploy-trigger` button to the `buttons` of the site blueprint or any page blueprint. The list replaces Kirby's default buttons, so keep the ones you want next to it – for the site view, they are `open`, `preview`, and `languages`:

```yml
# site/blueprints/site.yml
buttons:
  - open
  - preview
  - deploy-trigger
  - languages
```

To show the button in every site view without touching a blueprint, set Kirby's [`panel.viewButtons`](https://getkirby.com/docs/reference/system/options/panel) option instead. A blueprint's `buttons` still take precedence:

```php
// site/config/config.php
return [
    'panel' => [
        'viewButtons' => [
            'site' => ['open', 'preview', 'deploy-trigger', 'languages']
        ]
    ]
];
```

While the request runs, the button shows a spinner and ignores further clicks. A notification confirms once the deploy hook has accepted the request.

### 🔐 Server-Side Request

The button calls the plugin's own API route, and the server sends a `POST` request to the `deployUrl`. The hook URL and any token in `requestOptions` stay in your `config.php` and never reach the browser.

A response outside the 2xx range shows up as a Panel error with its status code, followed by the response body when it is plain text or JSON. A hook that can't be reached – an unknown host, a timeout – shows the connection error.

### 👥 Deploy Permission

Every role may deploy by default. To withhold it, set the `deploy` permission to `false` in the role's blueprint:

```yml
# site/blueprints/users/editor.yml
title: Editor

permissions:
  johannschopplich.deploy-trigger:
    deploy: false
```

Users of that role don't see the button, and the server refuses their deploy request.

A `"*": false` wildcard in a role blueprint turns `deploy` off as well, along with access to the views the button sits in. To let such a role deploy, grant them back next to the wildcard. A category you name starts from Kirby's defaults, so give each its own `"*": false` – `pages.access` and `pages.read` only matter for a button in a page view:

```yml
# site/blueprints/users/client.yml
title: Client

permissions:
  "*": false
  access:
    "*": false
    panel: true
    site: true
  site:
    "*": false
    access: true
  pages:
    "*": false
    access: true
    read: true
  johannschopplich.deploy-trigger:
    deploy: true
```

### 🧩 Kirby 4 Backport

Kirby 4 has no view buttons, so the plugin backports the button to the site view only. It sits after the view's buttons and doesn't follow the `buttons` blueprint option. The `deploy` permission doesn't hide it there, but the server still refuses the request.

## Requirements

- Kirby 4 or Kirby 5

## Installation

### Composer (Recommended)

```bash
composer require johannschopplich/kirby-deploy-trigger
```

### Manual Installation

Download and copy this repository to `/site/plugins/kirby-deploy-trigger`.

## Options

All options are namespaced under `johannschopplich.deploy-trigger`:

| Option           | Default | Description                                                                                                                                                                                                                      |
| ---------------- | ------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `deployUrl`      | `null`  | URL of the deploy hook. Without it, the button fails with a missing option error.                                                                                                                                                |
| `requestOptions` | `[]`    | Options for Kirby's [`Remote`](https://getkirby.com/docs/reference/objects/http/remote) class, such as `headers`, `data`, `agent`, `basicAuth`, `method` or `timeout` (10 seconds by default), merged over `'method' => 'POST'`. |

Example `config.php`:

```php
return [
    'johannschopplich.deploy-trigger' => [
        'deployUrl' => 'https://api.netlify.com/build_hooks/<hook-id>',
        'requestOptions' => [
            'timeout' => 30
        ]
    ]
];
```

## Recipes

### Vercel

Create a deploy hook under **Settings → Git → Deploy Hooks** of your project, as described in [Vercel's deploy hooks guide](https://vercel.com/docs/deploy-hooks), and use its URL as the `deployUrl`.

### Netlify

Create a build hook as described in [Netlify's build hooks guide](https://docs.netlify.com/build/configure-builds/build-hooks/), and use its URL as the `deployUrl`.

### GitHub Actions

A GitHub Actions workflow starts on a [`repository_dispatch`](https://docs.github.com/en/actions/reference/workflows-and-actions/events-that-trigger-workflows#repository_dispatch) event:

```yml
# .github/workflows/deploy.yml
on:
  repository_dispatch:
    types: [deploy]
```

GitHub's API needs a token, a user agent, and a JSON body, so send them through `requestOptions`. A fine-grained personal access token needs write access to the repository's **Contents**:

```php
return [
    'johannschopplich.deploy-trigger' => [
        'deployUrl' => 'https://api.github.com/repos/<owner>/<repo>/dispatches',
        'requestOptions' => [
            'agent' => 'kirby-deploy-trigger',
            'headers' => [
                'Accept' => 'application/vnd.github+json',
                'Authorization' => 'Bearer <token>',
                'Content-Type' => 'application/json'
            ],
            'data' => json_encode(['event_type' => 'deploy'])
        ]
    ]
];
```

## License

[MIT](./LICENSE) License © 2025-PRESENT [Johann Schopplich](https://github.com/johannschopplich)
