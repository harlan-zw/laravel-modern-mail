<?php

namespace ModernMail\Mail\Traits;

use Illuminate\Support\Str;
use ModernMail\Mail\ModernMailMessage;

trait Taggable {


    /**
     * The tag data for the message.
     *
     * @var array
     */
    protected $tags = [];


    /**
     * Register a tag for this email. Tags in this context are only used for analytics in Mailgun currently.
     *
     * @param string $tag
     *
     * @return $this
     */
    public function tag($tag)
    {
        $tags = array_merge($this->tags, [$tag]);
        $mailDriver = config('mail.driver');
        $header = config("modern-mailer.services.$mailDriver.headers.tag");
        if (empty($header)) {
            // @todo throw exception
            return $this;
        }
        $this->callbacks['tags'] = function (\Swift_Message $message) use ($tags, $header) {
            foreach ($tags as $tag) {
                $message
                    ->getHeaders()
                    ->addTextHeader($header, $tag);
            }
        };
        $this->tags = $tags;

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


    /**
     * Sets up tagging for Laravel Telescope
     * @return array
     */
    public function tags(): array {
        return $this->tags;
    }
}
