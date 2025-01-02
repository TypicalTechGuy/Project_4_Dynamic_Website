<?php
include("session_handler.php");
include("db_connect.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost/gaming_corner/profilepages/sign_in.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $article_id = intval($_POST['id']);
    $user_id = $_SESSION['user_id'];

    try {
        $query_delete = "DELETE FROM articles WHERE id = ? AND user_id = ?";
        $stmt_delete = $conn->prepare($query_delete);
        $stmt_delete->bind_param("ii", $article_id, $user_id);

        if ($stmt_delete->execute()) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        } else {
            echo "Failed to delete the article. Please try again.";
        }

        $stmt_delete->close();
    } catch (Exception $e) {
        echo "An error occurred: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
