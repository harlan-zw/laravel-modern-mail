<?php
namespace Tests;

use ModernMail\Process\MJML;

trait RendersMJML
{

    /**
     * Render the contents of the given Blade template string.
     *
     * @param string $template
     * @param \Illuminate\Contracts\Support\Arrayable|array $data
     * @return \Illuminate\Support\HtmlString
     * @throws \Throwable
     */
    protected function mjml(string $template, array $data = [])
    {
        $view = view($template, $data);
        $process = new MJML($view);
        return $process->renderHTML();
    }

}
