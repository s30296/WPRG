<?php
// Aktualizacja posta
global $conn;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['post_id'])) {
        include 'includes/db.php';

        $post_id = $_POST['post_id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $sql = "UPDATE posts SET title=?, content=?, edited_at=NOW() WHERE id=?";
        $update_post = $conn->prepare($sql);
        $update_post->bind_param("ssi", $title, $content, $post_id);
        $update_post->execute();

        if ($_FILES['image']) {
            $dir = "images/";
            $file = $dir . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $file);
            $image = basename($_FILES["image"]["name"]);
            $sql_img = "UPDATE posts SET image=? WHERE id=?";
            $update_img = $conn->prepare($sql_img);
            $update_img->bind_param("si", $image, $post_id);
            $update_img->execute();
        }
        header("Location: post.php?id=$post_id");
        exit();
    }
}
?>