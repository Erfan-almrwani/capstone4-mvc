<?php
require_once 'interfaces/NotificationInterface.php';

class EmailNotification implements NotificationInterface {
    public function send($recipient, $message) {
        // Simulate email sending
        $this->logNotification('email', $recipient, $message);
        return "Email sent to $recipient: $message";
    }
    
    private function logNotification($type, $recipient, $message) {
        $log = date('Y-m-d H:i:s') . " - $type notification to $recipient: $message" . PHP_EOL;
        file_put_contents('notification_log.txt', $log, FILE_APPEND);
    }
}
?>