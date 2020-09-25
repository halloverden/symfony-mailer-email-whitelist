<?php


namespace HalloVerden\EmailWhitelist\EventListener;


use Symfony\Component\Mailer\Event\MessageEvent;
use Symfony\Component\Mailer\EventListener\EnvelopeListener;

/**
 * Class WhitelistEnvelopeListener
 *
 * @package HalloVerden\EmailWhitelist\EventListener
 */
class WhitelistEnvelopeListener extends EnvelopeListener {

  /**
   * @var array|null
   */
  private $deliveryWhitelist;

  /**
   * WhitelistEnvelopeListener constructor.
   *
   * @param null       $sender
   * @param array|null $recipients
   * @param array|null $deliveryWhitelist
   */
  public function __construct($sender = null, array $recipients = null, array $deliveryWhitelist = null) {
    parent::__construct($sender, $recipients);
    $this->deliveryWhitelist = $deliveryWhitelist;
  }

  /**
   * @param MessageEvent $event
   */
  public function onMessage(MessageEvent $event): void {
    $matchingRecipients = [];
    if($this->deliveryWhitelist) {
      $recipients = $event->getEnvelope()->getRecipients();

      foreach ($recipients as $recipient) {
        foreach ($this->deliveryWhitelist as $whitelistRegex) {
          if(preg_match($whitelistRegex, $recipient->getAddress())) {
            $matchingRecipients[] = $recipient;
          }
        }
      }

    }
    parent::onMessage($event);

    if(!empty($matchingRecipients)){
      $event->getEnvelope()->setRecipients($matchingRecipients);
    }
  }

}
