<?php
trait SearchableTrait {
    protected function search($table, $columns, $searchTerm) {
        $db = Database::getInstance()->getConnection();
        
        $searchConditions = [];
        $params = [];
        
        foreach ($columns as $column) {
            $searchConditions[] = "$column LIKE :searchTerm";
        }
        
        $query = "SELECT * FROM $table WHERE " . implode(' OR ', $searchConditions);
        $stmt = $db->prepare($query);
        $stmt->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
        
        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Search error: " . $e->getMessage());
            return [];
        }
    }
}
?>