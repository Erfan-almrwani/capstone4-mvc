<?php
trait LoggingTrait {
    protected function logAction($action, $details) {
        $logMessage = date('Y-m-d H:i:s') . " - $action: " . json_encode($details) . PHP_EOL;
        file_put_contents('system_log.txt', $logMessage, FILE_APPEND);
    }
}
?>