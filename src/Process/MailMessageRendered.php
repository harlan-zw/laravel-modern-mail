<?php


namespace ModernMail\Process;


use Illuminate\Contracts\Support\Arrayable;

class MailMessageRendered implements Arrayable {

    public $html;
    public $text;


    /**
     * RenderedMailView constructor.
     */
    public function __construct($html, $text = '') {
        $this->html = $html;
        $this->text = $text;
    }

    public static function render ($view) {
        /** @var MJML $mjml */
        $mjml = app(MJML::class);
        $html = $mjml->render($view);
        /** @var HtmlToText $htmlToText */
        $htmlToText = app(HtmlToText::class);
        $text = $htmlToText->convert($html);
        return new static($html, $text);
    }

    public function toArray() {
        return [
            'html' => $this->html,
            'text' => $this->text,
        ];
    }
}
