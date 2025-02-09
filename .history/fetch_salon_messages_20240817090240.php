<?php
require 'connect_bdd.php';

// Ce fichier récupère les messages passés pour un salon spécifique :



if (isset($_GET['salon_id'])) {
    $salon_id = $_GET['salon_id'];
    $sql = "SELECT users.username, salon_messages.message FROM salon_messages JOIN 
            users ON salon_messages.user_id = users.id WHERE salon_messages.salon_id = ? ORDER BY salon_messages.created_at ASC";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $salon_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
    echo json_encode($messages);
}
?>
