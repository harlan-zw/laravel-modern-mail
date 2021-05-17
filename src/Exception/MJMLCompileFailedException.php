<?php


namespace ModernMail\Exception;


use Illuminate\View\View;
use Symfony\Component\Process\Exception\RuntimeException;
use Symfony\Component\Process\Process;

class MJMLCompileFailedException extends RuntimeException {

    private $view;

    private $process;

    public function __construct(View $view, Process $process)
    {
        $this->view = $view;
        $error = sprintf('Failed to compile the view "%s".'."\n\nExit Code: %s(%s)\n\nWorking directory: %s",
            $view->getPath(),
            $process->getExitCode(),
            $process->getExitCodeText(),
            $process->getWorkingDirectory()
        );

        if (!$process->isOutputDisabled()) {
            $error .= sprintf("\n\nOutput:\n================\n%s\n\nError Output:\n================\n%s",
                $process->getOutput(),
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
