<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pages = [
        'textarea' => ['table' => 'editor_content', 'db' => true],
        'profileContent' => ['file' => 'profile.html'],
        'cartContent' => ['file' => 'cart.html'],
        'messageContent' => ['file' => 'message.html'],
        'shopContent' => ['file' => 'shop.html']
    ];
    
    // Database connection setup (used only for textarea)
    $conn = new mysqli("localhost", "root", "", "clothing");
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    foreach ($pages as $postKey => $settings) {
        if (!empty($_POST[$postKey])) {
            $content = $_POST[$postKey];

            if (isset($settings['db']) && $settings['db']) {
                // Insert into database (for 'textarea')
                $sql = "INSERT INTO editor_content (content) VALUES ('$content')";
                if ($conn->query($sql) === TRUE) {
                    echo ucfirst($postKey) . " content saved successfully in database.<br>";
                } else {
                    echo "Error saving " . ucfirst($postKey) . " content: " . $conn->error . "<br>";
                }
            } elseif (isset($settings['file'])) {
                // Save to a file (for profile, cart, message, shop)
                if (file_put_contents($settings['file'], $content)) {
                    echo ucfirst($postKey) . " content saved successfully to " . $settings['file'] . ".<br>";
                } else {
                    echo "Failed to save " . ucfirst($postKey) . " content.<br>";
                }
            }
        } else {
            echo "No " . ucfirst($postKey) . " content to save.<br>";
        }
    }

    // Close database connection
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
