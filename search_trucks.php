<?php
require "config/conn.php";

if (isset($_POST['search'])) {
    $search = "%" . trim($_POST['search']) . "%";

    try {
        $stmt = $pdo->prepare("SELECT truck_plate FROM trucks WHERE truck_plate LIKE :search LIMIT 5");
        $stmt->bindParam(':search', $search, PDO::PARAM_STR);
        $stmt->execute();
        $trucks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($trucks) {
            foreach ($trucks as $truck) {
                echo "<div class='search-item'>" . htmlspecialchars($truck['truck_plate']) . "</div>";
            }
        } else {
            echo "<div>No matches found</div>";
        }
    } catch (PDOException $e) {
        echo "<div style='color:red;'>Error: " . $e->getMessage() . "</div>";
    }
}
?>
