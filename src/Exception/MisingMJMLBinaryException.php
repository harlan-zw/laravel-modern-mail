<?php


namespace ModernMail\Exception;


class MisingMJMLBinaryException extends \Exception {

    private $triedPath;

    /**
     * MisingMJMLBinaryException constructor.
     */
    public function __construct($triedPath) {
        $this->triedPath = $triedPath;
        parent::__construct('Failed to find MJML binary at path: "' . $triedPath . '". Please install the binary and continue.');
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
