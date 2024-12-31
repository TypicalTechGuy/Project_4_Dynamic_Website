<?php
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $uploadDir = '../img/articleimage/';
    $image = $_FILES['image'];
    $articleId = $_POST['article_id'];

    if ($image['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($image['type'], $allowedTypes)) {
            die("Error: Only JPG, JPEG, and PNG files are allowed.");
        }

        $fileName = time() . '_' . basename($image['name']);
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($image['tmp_name'], $filePath)) {
            $filePathInDb = '/' . $filePath;

            $query = "UPDATE articles SET image_url = ? WHERE id = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$filePathInDb, $articleId]);

            echo "Image uploaded successfully: <a href='$filePathInDb'>$filePathInDb</a>";
        } else {
            echo "Error moving the uploaded file.";
        }
    } else {
        echo "Error uploading file.";
    }
} else {
    echo "Invalid request.";
}
?>
