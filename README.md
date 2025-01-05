![Kirby Deploy Trigger screenshot](./.github/kirby-deploy-trigger.png)

# Kirby Deploy Trigger

A Kirby Panel view button to trigger deployments on any CI/CD service, such as [Vercel](https://vercel.com/docs/deployments/deploy-hooks), [Netlify](https://docs.netlify.com/configure-builds/build-hooks/), or GitHub Actions.

This is especially useful when you want to trigger a deployment after updating the content in the Panel from your headless Kirby setup. The button sends a request to the specified URL, which can be used to trigger a deployment on your CI/CD service.

## Requirements

- Kirby 4 or Kirby 5

Kirby is not free software. However, you can try Kirby and the Starterkit on your local machine or on a test server as long as you need to make sure it is the right tool for your next project. … and when you're convinced, [buy your license](https://getkirby.com/buy).

## Installation

### Composer

```bash
composer require johannschopplich/kirby-deploy-trigger
```

### Download

Download and copy this repository to `/site/plugins/kirby-deploy-trigger`.

## Getting Started

### Webhook Setup

Create a webhook in your CI/CD service to listen for incoming requests. The webhook URL is the URL you need to specify in the `johannschopplich.deploy-trigger.deployUrl` option in the `config.php` file:

```php
# /site/config/config.php
return [
    'johannschopplich.deploy-trigger' => [
        'deployUrl' => 'https://api.example.com/deploy',
    ]
];
```

> [!TIP]
> The `deployUrl` is sent as a POST request by default. You can change the request method with the [`requestOptions`](#configuration) option.

### Blueprint Setup

Kirby 5 introduces new extensions that allow you to add custom view buttons to most Panel views (e.g. page, site, or file). The Deploy Trigger plugin provides a button that can be added alongside the default buttons, such as the preview button or the language dropdown.

To add the `deploy-trigger` button to a particular view, set the `buttons` option in the corresponding blueprint. The following example shows how to reference the default buttons and add the `deploy-trigger` button to the `site` blueprint:

```yaml
# /site/blueprints/site.yml
buttons:
  - deploy-trigger # Re-order the button as needed
  - preview
```

This way, you can reference the default buttons and decide where to place the `deploy-trigger` button.

> [!TIP]
> Kirby 4 does not support custom view buttons, but the `deploy-trigger` button has been backported 🎉. It is always prepended to the default buttons and cannot be moved.

## Configuration

Each configuration option is available in the `config.php` file.

The following table lists all available options:

| Option           | Default | Description                                                  |
| ---------------- | ------- | ------------------------------------------------------------ |
| `deployUrl`      | `null`  | The URL to trigger the deployment.                           |
| `requestOptions` | `[]`    | Additional headers or a specific method to send the request. |

## Cookbook

### Trigger a Vercel Deployment

To create a Deploy Hook for your project, make sure your project is [connected to a Git repository](https://vercel.com/docs/projects/overview#git).

Once your project is connected, navigate to its **Settings** page and then select the **Git** menu item.

In the "Deploy Hooks" section, choose a name for your Deploy Hook and select the branch that will be deployed when the generated URL is requested.

[![Create Vercel deploy hooks](./.github/vercel-deploy-hooks-light.png)](https://vercel.com/docs/deployments/deploy-hooks)

After submitting the form, you will see a URL that you can copy and use as the `deployUrl` option in the `config.php` file.

## License

[MIT](./LICENSE) License © 2025-PRESENT [Johann Schopplich](https://github.com/johannschopplich)
