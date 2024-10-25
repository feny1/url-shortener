# URL Shortener

A simple and efficient URL shortener built with PHP and MySQL that allows users to shorten long URLs and redirect them seamlessly.

## Table of Contents

- [Features](#features)
- [Technologies Used](#technologies-used)
- [Setup Instructions](#setup-instructions)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## Features

- Shorten long URLs easily.
- Redirects from shortened URLs to original links.
- User-friendly interface.
- Error handling for invalid URLs and database issues.

## Technologies Used

- **PHP**: Server-side scripting language.
- **MySQL**: Database to store original and shortened URLs.
- **HTML/CSS**: Frontend structure and styling.
- **JavaScript**: For asynchronous URL shortening requests.

## Setup Instructions

1. **Clone the repository:**

   ```bash
   git clone https://github.com/your-username/url-shortener.git
   cd url-shortener
   ```

2. **Set up your database:**

   - Create a MySQL database and a table named `urls` with the following structure:

   ```sql
   CREATE TABLE urls (
       id INT AUTO_INCREMENT PRIMARY KEY,
       long_url VARCHAR(255) NOT NULL,
       short_code VARCHAR(10) NOT NULL UNIQUE
   );
   ```

3. **Configure your database connection:**

   - Update the database connection details in your PHP script:
   
   ```php
   $host = 'YOUR_DB_HOST';
   $username = 'YOUR_DB_USERNAME';
   $password = 'YOUR_DB_PASSWORD';
   $dbname = 'YOUR_DB_NAME';
   ```

4. **Run the application:**

   - Place the PHP files on your server (e.g., XAMPP, LAMP) and access the application through your web browser.

## Usage

1. Enter a long URL in the input box.
2. Click the "Shorten" button.
3. Copy the shortened URL provided.
4. Use the shortened URL to access the original link.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE.md) file for details.
