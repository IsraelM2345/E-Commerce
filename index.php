<?php
$conn = new mysqli("localhost", "root", "", "your_database");
$result = $conn->query("SELECT content FROM editor_content ORDER BY id DESC LIMIT 1");
$row = $result->fetch_assoc();
$savedContent = $row['content'] ?? ''; // Load last saved content
?>

<textarea name="textarea" id="default"><?php echo htmlspecialchars($savedContent); ?></textarea>