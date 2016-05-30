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
        $success = !$this->NotificationLog->hasProblems();

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

        if (CoreFunctions::isAJAX()) {
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
        } else {
            if ($redirect) {
                header("Location:{$redirect}");
            } else {
                echo '<h3>Системные сообщения:</h3>';
                echo 'Отчёт о выполнении: ', $success ? 'Успешно' : 'Возникли проблемы', '<hr/>';
                if (!empty($errors)) {
                    echo 'Ошибки:<br/><ul>', '<li>', implode('</li>', $errors), '</li>', '</ul>';
                }
                if (!empty($warnings)) {
                    echo 'Предупреждения:<br/><ul>', '<li>', implode('</li>', $warnings), '</li>', '</ul>';
                }
                if (!empty($notices)) {
                    echo 'Уведомления:<br/><ul>', '<li>', implode('</li>', $notices), '</li>', '</ul>';
                }
                if (!empty($messages)) {
                    echo 'Сообщения:<br/><ul>', '<li>', implode('</li>', $messages), '</li>', '</ul>';
                }
                if (!empty($additionalData)) {
                    echo '<hr/><h4>Дополнительные данные:</h4>', var_export($additionalData);
                }
            }
        }

    }

} 