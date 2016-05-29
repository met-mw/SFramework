<?php
namespace SFramework\Classes;
use Exception;


/**
 * Class NotificationLog
 * @package SFramework\Classes
 *
 * Сборщик системных оповещений
 */
class NotificationLog
{

    const MODE_DEVELOP = 0;
    const MODE_PRODUCTION = 1;

    const TYPE_ERROR = 0;
    const TYPE_WARNING = 1;
    const TYPE_NOTICE = 2;
    const TYPE_MESSAGE = 3;

    /** @var NotificationLog | null */
    static protected $Instance = null;

    /** @var int */
    private $mode = self::MODE_PRODUCTION;

    /** @var string[] */
    private $errors = [];
    /** @var string[] */
    private $warnings = [];
    /** @var string[] */
    private $notice = [];
    /** @var string[] */
    private $messages = [];

    private function __construct() {}

    static public function instance()
    {
        if (is_null(self::$Instance)) {
            self::$Instance = new self();
        }

        return self::$Instance;
    }

    public function setProductionMode()
    {
        $this->mode = self::MODE_PRODUCTION;
    }

    public function setDevelopMode()
    {
        $this->mode = self::MODE_DEVELOP;
    }

    protected function pushAny($type, $text)
    {
        $triggerErrorType = null;
        switch ($type) {
            case self::TYPE_ERROR:
                $this->errors[] = $text;
                $triggerErrorType = E_USER_ERROR;
                break;
            case self::TYPE_WARNING:
                $this->warnings[] = $text;
                $triggerErrorType = E_USER_WARNING;
                break;
            case self::TYPE_NOTICE:
                $this->notice[] = $text;
                $triggerErrorType = E_USER_NOTICE;
                break;
            case self::TYPE_MESSAGE:
                $this->messages[] = $text;
                break;
        }

        if (!is_null($triggerErrorType) && $this->mode == self::MODE_DEVELOP) {
            trigger_error($text, $triggerErrorType);
        }
    }

    public function pushError($errorText)
    {
        $this->pushAny(self::TYPE_ERROR, $errorText);
    }

    public function pushWarning($warningText)
    {
        $this->pushAny(self::TYPE_WARNING, $warningText);
    }

    public function pushNotice($noticeText)
    {
        $this->pushAny(self::TYPE_NOTICE, $noticeText);
    }

    public function pushMessage($messageText)
    {
        $this->pushAny(self::TYPE_MESSAGE, $messageText);
    }

    public function hasErrors()
    {
        return !empty($this->errors);
    }

    public function hasWarnings()
    {
        return !empty($this->warnings);
    }

    public function hasNotices()
    {
        return !empty($this->notice);
    }

    public function hasMessages()
    {
        return !empty($this->messages);
    }

    public function hasProblems()
    {
        return $this->hasErrors() || $this->hasWarnings() || $this->hasNotices();
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getWarnings()
    {
        return $this->warnings;
    }

    public function getNotices()
    {
        return $this->notice;
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function getError($index)
    {
        if (!isset($this->errors[$index])) {
            throw new Exception("Ошбика с индексом \"{$index}\" не найдена.");
        }

        return $this->errors[$index];
    }

    public function getWarning($index)
    {
        if (!isset($this->warnings[$index])) {
            throw new Exception("Предупреждение с индексом \"{$index}\" не найдено.");
        }

        return $this->warnings[$index];
    }

    public function getNotice($index)
    {
        if (!isset($this->notice[$index])) {
            throw new Exception("Уведомление с индексом \"{$index}\" не найдено.");
        }

        return $this->notice[$index];
    }

    public function getMessage($index)
    {
        if (!isset($this->messages[$index])) {
            throw new Exception("Сообщение с индексом \"{$index}\" не найдено.");
        }

        return $this->messages[$index];
    }

    public function getLastError()
    {
        return $this->hasErrors() ? $this->getError(count($this->errors) - 1) : null;
    }

    public function getLastWarning()
    {
        return $this->hasWarnings() ? $this->getWarning(count($this->warnings) - 1) : null;
    }

    public function getLastNotice()
    {
        return $this->hasNotices() ? $this->getNotice(count($this->notice) - 1) : null;
    }

    public function getLastMessage()
    {
        return $this->hasMessages() ? $this->getMessage(count($this->messages) - 1) : null;
    }

} 