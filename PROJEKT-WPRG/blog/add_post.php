<?php
// Dodanie posta
global $conn;
include 'includes/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $image = $_FILES['image']['name'];
    $dir = "images/";
    $file = $dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $file);

    $sql = "INSERT INTO posts (title, content, image, created_at, author_id) VALUES (?, ?, ?, NOW(), ?)";
    $insert_post = $conn->prepare($sql);
    $insert_post->bind_param("sssi", $title, $content, $image, $_SESSION['user_id']);

    if ($insert_post->execute()) {
        $post_id = $insert_post->insert_id;

        header("Location: post.php?id=$post_id");
        exit();
    } else {
        echo "Wystąpił problem podczas dodawania wpisu.";
    }
}
?>