<?php


namespace ModernMail\Exception;


use Illuminate\View\View;
use Symfony\Component\Process\Exception\RuntimeException;
use Symfony\Component\Process\Process;

class MJMLValidationFailedException extends RuntimeException {

    private $view;

    private $process;

    public function __construct(View $view, Process $process)
    {
        $this->view = $view;
        $error = sprintf('Failed to validate the MJML view "%s".' . "\n\n",
            $view->getPath(),
        );

        if (!$process->isOutputDisabled()) {
            $error .= sprintf("MJML Errors: \n================\n%s",
                $process->getErrorOutput()
            );
        }

        parent::__construct($error);

        $this->process = $process;
    }

    public function getProcess()
    {
        return $this->process;
    }

    /**
     * Get the exception's context information.
     *
     * @return array
     */
    public function context()
    {
        return ['view' => $this->view];
    }
}
