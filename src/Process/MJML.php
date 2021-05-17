<?php

namespace ModernMail\Process;

use Illuminate\Support\Facades\Log;
use ModernMail\Exception\MisingMJMLBinaryException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\HtmlString;
use Illuminate\View\View;
use ModernMail\Exception\MJMLNotExecutableException;
use ModernMail\Exception\MJMLCompileFailedException;
use ModernMail\Exception\MJMLValidationFailedException;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class MJML
{

    /**
     * @var array
     */
    protected $additionalArguments = [];

    protected $mjmlBinaryPath;
    protected $validate;

    /**
     * MJML constructor.
     *
     * @param View $view
     * @throws MJMLNotExecutableException
     */
    public function __construct($mjmlBinaryPath)
    {
        $this->mjmlBinaryPath = $mjmlBinaryPath;

        $this->validate = config('modern-mailer.mjml_validate');
        if (!is_executable($this->mjmlBinaryPath)) {
            throw new MJMLNotExecutableException($this->mjmlBinaryPath);
        }
    }

    /**
     * @throws MisingMJMLBinaryException
     */
    public static function detectMode () {
        $npmBinary = base_path('node_modules/bin/mjml');
        if (File::exists($npmBinary)) {
            return static::viaNodeModule();
        }

        // attempt the configured binary path, first as relative to the code base
        if (File::exists(base_path(config('modern-mailer.mjml_binary_path')))) {
            return static::viaBinary(base_path(config('modern-mailer.mjml_binary_path')));
        }
        // then as an absolute path
        if (File::exists(config('modern-mailer.mjml_binary_path'))) {
            return static::viaBinary(config('modern-mailer.mjml_binary_path'));
        }
        // otherwise check the usr bin
        if (File::exists('/usr/bin/mjml')) {
            return static::viaBinary('/usr/bin/mjml');
        }
        // or just the root directory
        if (File::exists(base_path('mjml'))) {
            return static::viaBinary(base_path('mjml'));
        }
        throw new MisingMJMLBinaryException(config('modern-mailer.mjml_binary_path'));
    }

    public static function viaNodeModule () {
        return new MJML(base_path('node_modules/bin/mjml'));
    }

    public static function viaBinary($path) {
        return new MJML($path);
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
    public function buildCmdLineFromConfig($path, $compiledPath)
    {
        return implode(' ', array_merge([
            $this->mjmlBinaryPath,
            $path,
            '-o',
            $compiledPath,
            '--config.filePath ' . resource_path('views')
        ], $this->additionalArguments));
    }


    /**
     * @param View $view
     * @return HtmlString
     * @throws \JsonException
     */
    public function render(View $view) {
        // Hash combined data and path.  If either change, new pre-compiled file is generated.
        $dataPathChecksum = hash('sha256', json_encode([
            'path' => $view->getPath(),
            'data' => $view->getData(),
        ], JSON_THROW_ON_ERROR));
        $path = storage_path("framework/views/{$dataPathChecksum}.mjml.php");

        $html = $view->render();

        File::put($path, $html);

        $contentChecksum    = hash('sha256', $html);
        $compiledPath = storage_path("framework/views/{$contentChecksum}.php");

        if (! File::exists($compiledPath)) {
            $validateProcess = Process::fromShellCommandline($this->mjmlBinaryPath . ' -v ' . $path);
            $validateProcess->run();
            if (! $validateProcess->isSuccessful()) {
                if ($this->validate === 'error') {
                    throw new MJMLValidationFailedException($view, $validateProcess);
                } else if ($this->validate === 'warning') {
                    Log::warning(sprintf('Failed to validate the MJML view "%s".' . "\n\nErrors:\n%s,",
                        $view->getPath(),
                        $validateProcess->getErrorOutput()
                    ), ['view' => $view]);
                }
            }

            $compileProcess = Process::fromShellCommandline($this->buildCmdLineFromConfig($path, $compiledPath));
            $compileProcess->run();

            if (! $compileProcess->isSuccessful()) {
                throw new MJMLCompileFailedException($view, $compileProcess);
            }
        }

        return new HtmlString(File::get($compiledPath));
    }

}
