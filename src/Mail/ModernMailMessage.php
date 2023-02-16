<?php
namespace ModernMail\Mail;

use Illuminate\Notifications\Messages\MailMessage as LegacyMailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;
use ModernMail\Mail\Traits\InheritsProperties;
use ModernMail\Mail\Traits\MJMLViews;
use ReflectionClass;
use Symfony\Component\Mime\Email;

class ModernMailMessage extends LegacyMailMessage
{
    use MJMLViews,
        InheritsProperties;

    /**
     * The tag data for the message.
     *
     * @var array
     */
    public $tags = [];

    public $clicks = true;

    public $opens = true;

    /**
     * @param array $tags
     */
    public function __construct() {
        $this->withSymfonyMessage(function(Email $email) {
            $headers = $email->getHeaders();
            $mailDriver = config('mail.driver');
            $header = config("modern-mailer.services.$mailDriver.headers.tag");
            foreach ($this->tags as $tag) {
                $headers->addTextHeader($header, $tag);
            }

            $scopes = ['clicks', 'opens'];
            // iterate scopes
            foreach ($scopes as $scope) {
                // get the header and value
                $valueKey = $this->$scope ? 'header_on_value' : 'header_off_value';
                $header = config("modern-mailer.services.$mailDriver.headers.track-$scope");
                $value = config("modern-mailer.services.$mailDriver.$valueKey");
                // add the header and value to the text array
                $headers->addTextHeader($header, $value);
            }

            $email->setHeaders($headers);
        });
    }


    public function tag($tag) {
        $this->tags = array_merge($this->tags, [$tag]);
        return $this;
    }

    /**
     * This is so we can group the analytics of the message for ones that exist within the same namespace.
     *
     * @param string $tags
     * @return ModernMailMessage
     */
    public function namespacedTag(string $tags) {
        // add the full tag with nested dots
        $this->tag($tags);
        // if there's still dots we run a recursive function to remove all of them
        if (Str::contains($tags, '.')) {
            // get the string parts
            $str = explode('.', $tags);
            // remove the last element
            array_pop($str);
            // recombine the elements, joining with the extract dot
            $this->namespacedTag(implode('.', $str));
        }
        return $this;
    }

    public function addTagsFromNotification(Notification $notification) {
        if (empty($this->tags)) {
            if (property_exists($notification, 'tag')) {
                $tag = $notification::$tag;
                if (Str::contains($tag, '.')) {
                    $this->namespacedTag($tag);
                } else {
                    $this->tag($tag);
                }
            } else {
                $reflectedNotification = new ReflectionClass($notification);
                $this->tag(Str::kebab($reflectedNotification->getShortName()));
            }
        }
        return $this;
    }

    public function setTrackingHeaders($enabled) {
        return $enabled ? $this->enableTracking() : $this->disableTracking();
    }

    public function enableTracking() {
        $this->enableTrackingClicks();
        $this->enableTrackingOpens();
        return $this;
    }

    public function disableTracking() {
        $this->disableTrackingClicks();
        $this->disableTrackingOpens();
        return $this;
    }

    public function enableTrackingClicks() {
        $this->clicks = true;
        return $this;
    }

    public function disableTrackingClicks() {
        $this->clicks = false;
        return $this;
    }

    public function enableTrackingOpens() {
        $this->opens = true;
        return $this;
    }

    public function disableTrackingOpens() {
        $this->opens = false;
        return $this;
    }

    /**
     * Sets up tagging for Laravel Telescope
     * @return array
     */
    public function tags(): array {
        return $this->tags;
    }
}
