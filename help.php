<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help - Stock Management</title>
   
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .back-button {
            position: absolute;
            top: 10px;
            right: 20px; /* Moved to the right */
            background-color: #f39c12; /* Updated color */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
        }


        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 28px;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
            margin-bottom: 20px;
            text-align: center;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        li {
            background-color: #f9f9f9;
            margin: 10px 0;
            padding: 15px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        li img {
            flex-shrink: 0;
        }

        li span {
            font-size: 18px;
            color: #333;
        }

        .faq-section {
            margin-top: 40px;
        }

        .faq-section h3 {
            color: #007bff;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .faq-section p {
            font-size: 16px;
            color: #333;
            margin: 10px 0;
        }

        .contact-details {
            margin-top: 40px;
        }

        .contact-details h3 {
            color: #007bff;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .contact-details p {
            font-size: 16px;
            color: #333;
            margin: 10px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <a href="index.php" class="back-button">Back to Dashboard</a>
       
    </header>

    <div class="container">
        <h2>Help</h2>
        <p>Welcome to the Stock Management System. Below you'll find instructions and resources to help you navigate the system.</p>

        <ul>
            <li><img src="images/dashboard.png" alt="Nav Icon" width="40"><span>Use the dashboard to access different management pages easily.</span></li>
            <li><img src="images/manage.png" alt="Admin Icon" width="40"><span>Admins can manage users, suppliers, items, and sales records efficiently.</span></li>
            <li><img src="images/planning.png" alt="Manage Icon" width="40"><span>Each management page allows you to add, edit, delete, and view records seamlessly.</span></li>
            <li><img src="images/secure.png" alt="Security Icon" width="40"><span>Always log out after using the system for enhanced security.</span></li>
            <li><img src="images/contact.png" alt="Contact Icon" width="40"><span>For further assistance, contact the system administrator using the details below.</span></li>
        </ul>

        <div class="faq-section">
            <h3>Frequently Asked Questions (FAQs)</h3>
            <p><strong>Q1: How do I reset my password?</strong></p>
            <p>A: You can reset your password by going to the 'My Account' page and entering a new password.</p>

            <p><strong>Q2: Can I change my username?</strong></p>
            <p>A: Yes, you can change your username by going to the 'My Account' page on the dashboard and entering a new username.</p>

            <p><strong>Q3: How can I track all records in the system?</strong></p>
            <p>A: You can track all records from the dashboard. It provides live updates with the database.</p>

            <p><strong>Q4: What should I do if I encounter an error?</strong></p>
            <p>A: Contact the system administrator using the contact details below with details of the error.</p>
        </div>

        <div class="contact-details">
            <h3>Contact Us</h3>
            <p><strong>Address:</strong> 123 Main Street, Colombo 07, Sri Lanka</p>
            <p><strong>Phone:</strong> +94 11 123 4567</p>
            <p><strong>Email:</strong> support@stockmanagement.lk</p>
        </div>
    </div>
        <?php include 'includes/footer.php'; ?>
</body>
</html>
