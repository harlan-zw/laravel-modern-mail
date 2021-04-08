<?php

namespace ModernMail\Process;

use Soundasleep\Html2Text;
use Illuminate\Support\Facades\File;
use Illuminate\Support\HtmlString;
use Illuminate\View\View;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class MJML
{
    /**
     * @var Process
     */
    protected $process;

    /**
     * @var View
     */
    protected $view;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var array
     */
    protected $additionalArguments = [];

    /**
     * MJML constructor.
     *
     * @param View $view
     */
    public function __construct($view)
    {
        $this->view = $view;
        // Hash combined data and path.  If either change, new pre-compiled file is generated.
        $dataPathChecksum = hash('sha256', json_encode([
            'path' => $this->view->getPath(),
            'data' => $this->view->getData(),
        ]));
        $this->path = storage_path("framework/views/{$dataPathChecksum}.mjml.php");
    }

    /**
     * Set additional arguments for the command line call to the mjml binary. The provided format should be as
     * `--config.<option> <value>`
     *
     * See: https://github.com/mjmlio/mjml#inside-nodejs
     */
    public function setCmdLineAdditionalArguments(array $arguments): MJML {
        $this->additionalArguments = $arguments;
        return $this;
    }

    /**
     * Build the mjml command.
     *
     * @return string
     */
    public function buildCmdLineFromConfig()
    {
        return implode(' ', array_merge([
            dirname(__DIR__, 2) . '/node_modules/.bin/mjml',
            $this->path,
            '-o',
            $this->compiledPath,
            '--config.filePath ' . resource_path('views')
        ], $this->additionalArguments));
    }

    /**
     * Render the html content.
     *
     * @throws \Throwable
     */
    public function renderHTML()
    {

        $html = $this->view->render();

        File::put($this->path, $html);

        $contentChecksum    = hash('sha256', $html);
        $this->compiledPath = storage_path("framework/views/{$contentChecksum}.php");

        if (! File::exists($this->compiledPath)) {
            $this->process = Process::fromShellCommandline($this->buildCmdLineFromConfig());
            $this->process->run();

            if (! $this->process->isSuccessful()) {
                throw new ProcessFailedException($this->process);
            }
        }

        return new HtmlString(File::get($this->compiledPath));
    }

    /**
     * Render the text content.
     *
     * @return HtmlString
     *
     * @throws \Throwable
     */
    public function renderText()
    {
        libxml_use_internal_errors(true);

        return new HtmlString(Html2Text::convert($this->renderHTML()->toHtml()));
    }

    public function render() {
        return [
            'html' => $this->renderHTML(),
            'text' => $this->renderText()
        ];
    }

}
