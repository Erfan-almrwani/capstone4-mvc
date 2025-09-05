<?php
require_once 'interfaces/NotificationInterface.php';

class SMSNotification implements NotificationInterface {
    public function send($recipient, $message) {
        // Simulate SMS sending
        $this->logNotification('sms', $recipient, $message);
        return "SMS sent to $recipient: $message";
    }
    
    private function logNotification($type, $recipient, $message) {
        $log = date('Y-m-d H:i:s') . " - $type notification to $recipient: $message" . PHP_EOL;
        file_put_contents('notification_log.txt', $log, FILE_APPEND);
    }
}
?>