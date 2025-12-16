<?php
require_once "db.php";
$conn = db();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = trim($_POST["name"] ?? "");
  $message = trim($_POST["message"] ?? "");

  if ($name !== "" && $message !== "") {
    $stmt = $conn->prepare("INSERT INTO guests (name, message) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $message);
    $stmt->execute();
    $stmt->close();
  }
  header("Location: /insert/");
  exit;
}

$result = $conn->query("SELECT id, name, message, created_at FROM guests ORDER BY id DESC");
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Insert Service</title></head>
<body>
  <h2>Insert Service</h2>
  <p><a href="/">Home</a></p>

  <form method="POST">
    <div>
      <label>Name</label><br>
      <input name="name" required>
    </div>
    <div>
      <label>Message</label><br>
      <textarea name="message" rows="3" required></textarea>
    </div>
    <button type="submit">Add Guest</button>
  </form>

  <h3>Current Guests</h3>
  <table border="1" cellpadding="6" cellspacing="0">
    <tr><th>ID</th><th>Name</th><th>Message</th><th>Created</th></tr>
    <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row["id"]) ?></td>
        <td><?= htmlspecialchars($row["name"]) ?></td>
        <td><?= htmlspecialchars($row["message"]) ?></td>
        <td><?= htmlspecialchars($row["created_at"]) ?></td>
      </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
