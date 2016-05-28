<?php
namespace SFramework\Classes;


class Response
{

    /** @var NotificationLog */
    private $NotificationLog;

    public function __construct(NotificationLog $NotificationLog)
    {
        $this->NotificationLog = $NotificationLog;
    }

    public function arrayToJSON(array $data)
    {
        return json_encode($data);
    }

    public function sendAny(array $data, $success = true)
    {
        echo $this->arrayToJSON(array_merge(['success' => $success], $data));
    }

    public function send($redirect = '', array $additionalData = [])
    {
        $success = !($this->NotificationLog->hasErrors()
            || $this->NotificationLog->hasWarnings()
            || $this->NotificationLog->hasNotices());

        $errors = [];
        $warnings = [];
        $notices = [];
        $messages = [];

        if (!$success) {
            foreach ($this->NotificationLog->getErrors() as $error) {
                $errors[] = $error;
            }

            foreach ($this->NotificationLog->getWarnings() as $warning) {
                $warnings[] = $warning;
            }

            foreach ($this->NotificationLog->getNotices() as $notice) {
                $notices[] = $notice;
            }
        }

        foreach ($this->NotificationLog->getMessages() as $message) {
            $messages[] = $message;
        }

        echo $this->arrayToJSON(
            [
                'success' => $success,
                'errors' => $errors,
                'warnings' => $warnings,
                'notices' => $notices,
                'messages' => $messages,
                'redirect' => $redirect,
                'additional_data' => $additionalData
            ]
        );
    }

} 