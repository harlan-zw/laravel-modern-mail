<?php

namespace ModernMail\Mail\Traits;

use Illuminate\Support\Facades\View;
use ModernMail\Process\MJML;

trait MJMLViews {

    public $mjml = '';

    public function previewText($text) {
        $this->viewData['previewText'] = $text;
        return $this;
    }

    /**
     * Set the MJML template for the notification.
     *
     * @param string $view
     * @param array  $data
     * @return $this
     */
    public function mjml(string $view, array $data = [])
    {
        $this->mjml = $view;
        $this->viewData = $data;

        $this->view = null;
        $this->markdown = null;

        return $this;
    }

    public function render() {
        if ($this->mjml) {
            $mjml = new MJML(view($this->mjml, $this->data()));
            return $mjml->render();
        }
        return parent::render();
    }

}
