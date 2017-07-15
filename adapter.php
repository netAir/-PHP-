<?php

/**
 * Created by PhpStorm.
 * User: netAir
 * Date: 17-7-15
 * Time: 下午1:28
 */
class ErrorObject
{
    private $error;

    public function __construct(string $error)
    {
        $this->error = $error;
    }

    public function getError()
    {
        return $this->error;
    }
}

/*
 * 原有日志类,直接调用ErrorObject
 */

class LogToConsole
{
    private $errorObject;

    public function __construct(ErrorObject $errorObject)
    {
        $this->errorObject = $errorObject;
    }

    public function write()
    {
        fwrite(STDERR, $this->errorObject->getError());
    }
}

/*
 * 新日志类,无法直接使用ErrorObject
 */

class LogToCSV
{
    const CSV_LOCATION = 'log.csv';

    private $errorObject;

    public function __construct(LogToCSVAdapter $errorObject)
    {
        $this->errorObject = $errorObject;
    }

    public function write()
    {
        $line = $this->errorObject->getErrorNumber();
        $line .= ',';
        $line .= $this->errorObject->getErrorText();
        $line .= "\n";

        file_put_contents(self::CSV_LOCATION, $line, FILE_APPEND);
    }
}

/*
 * 适配器类,将errorObject转换为LogToCSV可调用类
 */

class LogToCSVAdapter extends ErrorObject
{
    private $errorNumber;
    private $errorText;

    public function __construct(string $error)
    {
        parent::__construct($error);

        $parts = explode(':', $error);
        $this->errorNumber = $parts[0];
        $this->errorText = $parts[1];
    }

    public function getErrorNumber()
    {
        return $this->errorNumber;
    }

    public function getErrorText()
    {
        return $this->errorText;
    }
}

$error = '404:NF';

$errorObject = new ErrorObject($error);
$log = new LogToConsole($errorObject);
$log->write();

$errorObject=new LogToCSVAdapter($error);
$log=new LogToCSV($errorObject);
$log->write();
