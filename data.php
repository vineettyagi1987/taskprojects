<?php

function displayHierarchy($parentId = null, $level = 0) {
    $pdo = new PDO("mysql:host=localhost;dbname=data", "root", "");
    $stmt = $pdo->prepare("SELECT id, name FROM persons WHERE parent_id " . 
                          (is_null($parentId) ? "IS NULL" : "= :parentId"));
    if (!is_null($parentId)) {
        $stmt->bindParam(':parentId', $parentId);
    }
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($rows) {
        echo "<ul>";
        foreach ($rows as $row) {
            echo "<li>" . htmlspecialchars($row['name']) . "</li>";
            displayHierarchy($row['id'], $level + 1); // Recursive call
        }
        echo "</ul>";
    }
}


displayHierarchy();



?>