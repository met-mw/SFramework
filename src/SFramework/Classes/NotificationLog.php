<?php
namespace SFramework\Classes;
use Exception;


/**
 * Class NotificationLog
 * @package SFramework\Classes
 *
 * Сборщик системных оповещений
 */
class NotificationLog {

    const MODE_DEVELOP = 0;
    const MODE_PRODUCTION = 1;

    static protected $instance = null;

    private $mode = self::MODE_PRODUCTION;

    private $errors = [];
    private $warnings = [];
    private $notice = [];
    private $messages = [];

    private function __construct() {}

    static public function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function setProductionMode() {
        $this->mode = self::MODE_PRODUCTION;
    }

    public function setDevelopMode() {
        $this->mode = self::MODE_DEVELOP;
    }

    public function pushError($errorText) {
        $this->errors[] = $errorText;
        if ($this->mode == self::MODE_DEVELOP) {
            trigger_error($errorText, E_USER_ERROR);
        }
    }

    public function pushWarning($warningText) {
        $this->warnings[] = $warningText;
        if ($this->mode == self::MODE_DEVELOP) {
            trigger_error($warningText, E_USER_WARNING);
        }
    }

    public function pushNotice($noticeText) {
        $this->notice[] = $noticeText;
        if ($this->mode == self::MODE_DEVELOP) {
            trigger_error($noticeText, E_USER_NOTICE);
        }
    }

    public function pushMessage($messageText) {
        $this->messages[] = $messageText;
    }

    public function hasErrors() {
        return !empty($this->errors);
    }

    public function hasWarnings() {
        return !empty($this->warnings);
    }

    public function hasNotices() {
        return !empty($this->notice);
    }

    public function hasMessages() {
        return !empty($this->messages);
    }

    public function hasProblems() {
        return $this->hasErrors() || $this->hasWarnings() || $this->hasNotices();
    }

    public function getErrors() {
        return $this->errors;
    }

    public function getWarnings() {
        return $this->warnings;
    }

    public function getNotices() {
        return $this->notice;
    }

    public function getMessages() {
        return $this->messages;
    }

    public function getError($index) {
        if (!isset($this->errors[$index])) {
            throw new Exception("Ошбика с индексом \"{$index}\" не найдена.");
        }

        return $this->errors[$index];
    }

    public function getWarning($index) {
        if (!isset($this->warnings[$index])) {
            throw new Exception("Предупреждение с индексом \"{$index}\" не найдено.");
        }

        return $this->warnings[$index];
    }

    public function getNotice($index) {
        if (!isset($this->notice[$index])) {
            throw new Exception("Уведомление с индексом \"{$index}\" не найдено.");
        }

        return $this->notice[$index];
    }

    public function getMessage($index) {
        if (!isset($this->messages[$index])) {
            throw new Exception("Сообщение с индексом \"{$index}\" не найдено.");
        }

        return $this->messages[$index];
    }

    public function getLastError() {
        return $this->hasErrors() ? $this->getError(count($this->errors) - 1) : null;
    }

    public function getLastWarning() {
        return $this->hasWarnings() ? $this->getWarning(count($this->warnings) - 1) : null;
    }

    public function getLastNotice() {
        return $this->hasNotices() ? $this->getNotice(count($this->notice) - 1) : null;
    }

    public function getLastMessage() {
        return $this->hasMessages() ? $this->getMessage(count($this->messages) - 1) : null;
    }

} 