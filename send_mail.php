<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data || !isset($data['name'], $data['email'], $data['phone'], $data['project'], $data['location'])) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Invalid input data"]);
        exit;
    }

    $to = "polaris.rkd@gmail.com";  // ✅ अपना ईमेल एड्रेस डालें
    $subject = "Project Inquiry - " . $data['project'];

    // ✅ HTML Table formatted message
    $message = "
    <html>
    <head>
      <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
      </style>
    </head>
    <body>
      <h2>New Site Visit Request</h2>
      <table>
        <tr><th>Name</th><td>" . htmlspecialchars($data['name']) . "</td></tr>
        <tr><th>Email</th><td>" . htmlspecialchars($data['email']) . "</td></tr>
        <tr><th>Phone</th><td>" . htmlspecialchars($data['phone']) . "</td></tr>
        <tr><th>Project</th><td>" . htmlspecialchars($data['project']) . "</td></tr>
        <tr><th>Location</th><td>" . htmlspecialchars($data['location']) . "</td></tr>
      </table>
    </body>
    </html>";

$headers = "From: UmikoWeb <info@umikoweb.com>\r\n";
$headers .= "Reply-To: " . $data['email'] . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(["status" => "success", "message" => "Email sent successfully"]);
    } else {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Failed to send email"]);
    }
}
?>