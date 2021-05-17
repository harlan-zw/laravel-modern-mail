<?php

namespace ModernMail\Process;

use Html2Text\Html2Text;
use Illuminate\Support\HtmlString;

class HtmlToText
{

    public $options;

    /**
     * Html2Text constructor.
     */
    public function __construct($options = []) {
        $this->options = $options;
    }

    public function convert($html) {
        $transformer = new Html2Text($html, $this->options);
        return new HtmlString($transformer->getText());
    }
}
