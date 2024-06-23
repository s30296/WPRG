<?php
// Dodanie komentarza
global $conn;
session_start();
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id'];
    $content = $_POST['content'];

    $sql = "INSERT INTO comments (post_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())";
    $insert_comment = $conn->prepare($sql);
    $insert_comment->bind_param("iis", $post_id, $user_id, $content);

    if ($insert_comment->execute()) {
        header("Location: post.php?id=$post_id");
    } else {
        echo "Wystąpił problem podczas dodawania komentarza.";
    }
}
?>