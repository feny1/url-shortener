# Security Policy

## Introduction

This document outlines the security measures and policies for the URL Shortener project. We are committed to maintaining the security of our application and protecting user data.

## Reporting Security Vulnerabilities

If you discover a security vulnerability, please report it to us promptly. We take security seriously and will investigate all reported vulnerabilities.

- **Email**: [feny@eny.sa]
- **Security Team**: [Feny]

Please include the following information in your report:
- A description of the vulnerability
- Steps to reproduce the issue
- Potential impact of the vulnerability

## Supported Versions

We actively support the latest version of the application. Older versions may not receive security updates. Please refer to our release notes for version history.

## Security Best Practices

To enhance the security of the application, we recommend the following best practices:

1. **Keep Dependencies Updated**: Regularly update your libraries and frameworks to their latest stable versions.
2. **Use HTTPS**: Ensure that your application is served over HTTPS to protect data in transit.
3. **Sanitize Inputs**: Always sanitize user inputs to prevent SQL injection and other types of attacks.
4. **Implement Rate Limiting**: Protect against abusive behaviors by implementing rate limiting on API endpoints.
5. **Use Strong Passwords**: If your application requires user authentication, encourage the use of strong passwords and consider implementing multi-factor authentication (MFA).

## Security Measures in Place

- **Input Validation**: All user inputs are validated and sanitized to prevent harmful data.
- **Prepared Statements**: SQL queries are executed using prepared statements to mitigate SQL injection risks.
- **Error Handling**: Errors are logged, but sensitive information is not exposed to users.

## Conclusion

We are dedicated to maintaining the security of our application and appreciate your efforts to help us identify and mitigate potential vulnerabilities. Thank you for your commitment to security!
