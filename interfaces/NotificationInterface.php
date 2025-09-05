<?php
interface NotificationInterface {
    public function send($recipient, $message);
}
?>