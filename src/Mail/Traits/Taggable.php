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
    public $tags = [];


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
        switch(config('mail.driver')) {
            case 'mailgun':
                $header = 'X-Mailgun-Tag';
                break;
            case 'postmark':
                $header = 'X-PM-Tag';
                break;
        }
        if (!isset($header)) {
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
    public function tags(string $tags)
    {
        // add the full tag with nested dots
        $this->tag($tags);
        // if there's still dots we run a recursive function to remove all of them
        if (Str::contains($tags, '.')) {
            // get the string parts
            $str = explode('.', $tags);
            // remove the last element
            array_pop($str);
            // recombine the elements, joining with the extract dot
            $this->tags(implode('.', $str));
        }

        return $this;
    }
}
