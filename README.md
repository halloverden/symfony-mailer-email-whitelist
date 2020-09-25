# symfony-mailer-email-whitelist
EnvelopeListener for symfony mailer that enables whitelisting of emails

## Install

`composer require halloverden/symfony-mailer-whitelist`

## Usage

```yaml
services:
  mailer.staging.set_recipients:
    class: HalloVerden\EmailWhitelist\EventListener\WhitelistEnvelopeListener
    tags: ['kernel.event_subscriber']
    arguments:
      $sender: '%env(EMAIL_FROM_ADDRESS)%'
      $recipients: '%env(json:EMAIL_DELIVERY_ADDRESSES)%'
      $deliveryWhitelist: '%env(json:EMAIL_DELIVERY_WHITELIST)%'
```
