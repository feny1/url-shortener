<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
include 'Include Your Database here'; // Adjust the path as necessary

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Function to generate a unique short code
function generateShortCode($length = 6) {
    return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyz', $length)), 0, $length);
}

// Handle URL shortening
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $longUrl = filter_var($_POST['url'], FILTER_VALIDATE_URL);

    if (!$longUrl) {
        echo json_encode(['error' => 'Invalid URL provided']);
        exit();
    }

    $shortCode = generateShortCode();
    $unique = false;

    while (!$unique) {
        $stmt = $conn->prepare("SELECT * FROM urls WHERE short_code = ?");
        $stmt->bind_param("s", $shortCode);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $shortCode = generateShortCode();
        } else {
            $unique = true;
        }
        $stmt->close();
    }

    $stmt = $conn->prepare("INSERT INTO urls (long_url, short_code) VALUES (?, ?)");
    $stmt->bind_param("ss", $longUrl, $shortCode);
    
    if (!$stmt->execute()) {
        echo json_encode(["error" => "Database insert failed: " . $stmt->error]);
        exit();
    }
    $stmt->close();

    echo json_encode(["shortUrl" => "http://eny.sa/tools/shorten?code=" . $shortCode]);
    exit(); // Ensure no further output
}

// Handle redirection
if (isset($_GET['code'])) {
    $shortCode = $_GET['code'];
    $stmt = $conn->prepare("SELECT long_url FROM urls WHERE short_code = ?");
    $stmt->bind_param("s", $shortCode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        header("Location: " . $row['long_url']);
        exit();
    } else {
        echo json_encode(["error" => "Not found"]);
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    <style>
        :root {
            --header: #b90010;
            --header-text: #f1f1f1;
            --background: #fafafa;
            --second-text: #130000;
            --header-font: 'Tropical';
            --text-font: 'Poppins';
            --button-background: #af2c2c;
            --button-hover: #b10000;
            --button-text: #f1f1f1;
        }

        body {
            font-family: var(--text-font), sans-serif;
            background-color: var(--background);
            color: var(--second-text);
            text-align: center;
            padding: 20px;
        }

        h1 {
            color: var(--header);
        }

        form {
            margin: 20px auto;
            max-width: 400px;
        }

        input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px;
            background-color: var(--button-background);
            color: var(--button-text);
            border: none;
            margin-top: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: var(--button-hover);
        }

        #result {
            margin-top: 20px;
            font-size: 1.2em;
        }
    </style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>

<body>
    <h1>URL Shortener</h1>
    <form method="POST" action="">
        <input type="text" name="url" placeholder="Enter URL" required>
        <button type="submit">Shorten</button>
    </form>
    <div id="result"></div>
    <footer class="footer" style="color: #130000;">
            <a style="color: #130000; text-decoration: none;" href="/" style="text-decoration-line: none;">
                <p class="footer-title">&copy; <span>Feny</span></p>
            </a>
            <div class="social-icons">
                <a style="color: #130000;" href="https://www.linkedin.com/in/ehab-yar-4a1bb4193/" aria-label="LinkedIn" class="icon"><i
                        class="fa-brands fa-linkedin-in"></i></a>
                <a style="color: #130000;" href="https://twitter.com/_f_eny" aria-label="Twitter" class="icon"><i
                        class="fa-brands fa-x-twitter"></i></a>
                <a style="color: #130000;" href="https://instagram.com/_f_eny" aria-label="Instagram" class="icon"><i
                        class="fa-brands fa-instagram"></i></a>
                <a style="color: #130000;" href="https://github.com/feny1" aria-label="GitHub" class="icon"><i
                        class="fa-brands fa-github"></i></a>
                
            </div>
        </footer>
    <script>
        document.querySelector('form').onsubmit = async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);

            try {
                const response = await fetch('', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }

                const data = await response.json();
                document.getElementById('result').innerText = data.error ? `Error: ${data.error}` : `Shortened URL: ${data.shortUrl}`;
            } catch (err) {
                document.getElementById('result').innerText = `Error: ${err.message}`;
            }
        };
    </script>
</body>

</html>
