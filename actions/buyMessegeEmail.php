<?php
$to = $email;
$subject = "Product Sale Details - KitabiAdda";

// HTML Email Template
$message = "
<html>
<head>
<title>Product Sale Details</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        padding: 20px;
    }
    .container {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        max-width: 600px;
        margin: auto;
    }
    .product-details {
        border-top: 2px solid #ccc;
        margin-top: 20px;
        padding-top: 20px;
    }
    .product-image {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin-top: 20px;
    }
    .product-name {
        font-size: 24px;
        font-weight: bold;
        color: #2c3e50;
        margin-top: 10px;
    }
    .product-price {
        font-size: 20px;
        color: #27ae60;
        margin-top: 5px;
    }
    .product-description {
        font-size: 16px;
        margin-top: 10px;
        color: #7f8c8d;
    }
    .footer {
        margin-top: 20px;
        font-size: 12px;
        color: #888;
    }
</style>
</head>
<body>
<div class='container'>
    <h2>Hello,</h2>
    <p>Thank you for listing your product on <strong>KitabiAdda</strong>.</p>
    <p>Here are the details of the product you recently sold:</p>

    <div class='product-details'>
        <img src='https://kitabiadda.com/assets/images/wedfew' alt='Product Image' class='product-image'>
        <p class='product-name'>Product Name: $233</p>
        <p class='product-price'>Price: ₹$234</p>
        <p class='product-description'>
            Description: $23433433wedf.
        </p>
    </div>

    <br>
    <p>Thank you for using <strong>KitabiAdda</strong> to sell your product. We wish you more successful sales!</p>
    <br>
    <p>Regards,<br><strong>KitabiAdda Team</strong></p>

    <div class='footer'>
        <p>If you didn't list this product, please contact support immediately.</p>
    </div>
</div>
</body>
</html>
";

// Headers
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=UTF-8\r\n";
$headers .= "From: KitabiAdda <no-reply@kitabiadda.in>\r\n";
$headers .= "Reply-To: support@kitabiadda.com\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Send Mail
if (mail($to, $subject, $message, $headers)) {
    echo "<script> window.location.href='order_details.php?order_id='.$last_id.'';</script>";
} else {
    echo "❌ Failed to send product details. Please try again later.";
}

?>