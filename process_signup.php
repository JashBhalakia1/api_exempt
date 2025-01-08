<?php
// Database connection
$host = "localhost";
$dbname = "api_exempt";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $gender = $_POST['gender'];

    // Set default role (e.g., Admin)
    $role = 'Admin';  // Default role, you can modify this as needed

    // Get the roleId from the roles table
    $sqlRole = "SELECT roleId FROM roles WHERE role = :role";
    $stmtRole = $conn->prepare($sqlRole);
    $stmtRole->execute([':role' => $role]);
    $roleId = $stmtRole->fetchColumn();

    if (!$roleId) {
        // Insert default role if it doesn't exist
        $sqlInsertRole = "INSERT INTO roles (role) VALUES (:role)";
        $stmtInsertRole = $conn->prepare($sqlInsertRole);
        $stmtInsertRole->execute([':role' => $role]);
        $roleId = $conn->lastInsertId();  // Get the newly inserted roleId
    }

    // Insert into users table
    $sql = "INSERT INTO users (fullname, email, password, genderId, roleId) 
            VALUES (:fullname, :email, :password, 
                    (SELECT genderId FROM gender WHERE gender = :gender), :roleId)";
    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute([
            ':fullname' => $fullname,
            ':email' => $email,
            ':password' => $password,
            ':gender' => $gender,
            ':roleId' => $roleId
        ]);
        echo "Signup successful!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
