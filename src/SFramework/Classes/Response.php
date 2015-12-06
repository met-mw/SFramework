<?php
namespace SFramework\Classes;


class Response {

    /** @var NotificationLog */
    private $notificationLog;

    public function __construct(NotificationLog $notificationLog) {
        $this->notificationLog = $notificationLog;
    }

    public function arrayToJSON(array $data) {
        return json_encode($data);
    }

    public function sendAny(array $data, $success = true) {
        echo $this->arrayToJSON(array_merge(['success' => $success], $data));
    }

    public function send() {
        $success = !($this->notificationLog->hasErrors()
            || $this->notificationLog->hasWarnings()
            || $this->notificationLog->hasNotices());

        $errors = [];
        $warnings = [];
        $notices = [];
        $messages = [];

        if (!$success) {
            foreach ($this->notificationLog->getErrors() as $error) {
                $errors[] = $error;
            }

            foreach ($this->notificationLog->getWarnings() as $warning) {
                $warnings[] = $warning;
            }

            foreach ($this->notificationLog->getNotices() as $notice) {
                $notices[] = $notice;
            }
        }

        foreach ($this->notificationLog->getMessages() as $message) {
            $messages[] = $message;
        }

        echo $this->arrayToJSON(
            [
                'success' => $success,
                'errors' => $errors,
                'warnings' => $warnings,
                'notices' => $notices,
                'messages' => $messages
            ]
        );
    }

} 