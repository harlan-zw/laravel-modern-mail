<?php


namespace ModernMail\Exception;


class MJMLNotExecutableException extends \Exception {

    private $triedPath;

    /**
     * MisingMJMLBinaryException constructor.
     */
    public function __construct($triedPath) {
        $this->triedPath = $triedPath;
        parent::__construct('MJML binary at path "' . $triedPath . '". is not executable. Please update the binary permissions.');
    }


    /**
     * Get the exception's context information.
     *
     * @return array
     */
    public function context()
    {
        return ['path' => $this->triedPath];
    }
}
