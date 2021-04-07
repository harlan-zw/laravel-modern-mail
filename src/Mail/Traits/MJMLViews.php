<?php

namespace ModernMail\Mail\Traits;

use Illuminate\Support\Facades\View;
use ModernMail\Process\MJML;

trait MJMLViews {

    public $mjml = '';

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
            $view = View::make($this->mjml, $this->viewData);
            $mjml = new MJML($view);

            return [
                'html' => $mjml->renderHTML(),
                'text' => $mjml->renderText(),
            ];
        }
        return parent::render();
    }

}
