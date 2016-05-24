<?php
namespace Brainteaser\InfrastructureBundle\Exception;

class InputValidationException extends \Exception
{
    /**
     * @var string
     */
    private $errorMessage;

    /**
     * @var string
     */
    private $errorCode;

    /**
     * @param string $code
     * @param string $message
     */
    public function __construct(string $code, string $message)
    {
        parent::__construct($message);

        $this->errorMessage = $message;
        $this->errorCode = $code;
    }

    /**
     * @return string
     */
    public function getErrorMessage() : string
    {
        return $this->errorMessage;
    }

    /**
     * @return string
     */
    public function getErrorCode() : string
    {
        return 'INPUT-' . $this->errorCode;
    }
}