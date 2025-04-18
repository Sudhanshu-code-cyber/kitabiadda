<?php
$book_namee = $cartItem['book_name'];
$book_imagee = $cartItem['img1'];
$book_desc = $cartItem['book_description'];
$to = $email;
$subject = "Product Purchase Confirmation - KitabiAdda";

// HTML Email Template
$message = "
<html>
<head>
<title>Product Purchase Confirmation</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        padding: 20px;
    }
    .container {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        max-width: 650px;
        margin: auto;
        text-align: center;
    }
    .header {
        background-color: #2c3e50;
        color: #fff;
        padding: 20px;
        border-radius: 8px 8px 0 0;
    }
    .header h2 {
        margin: 0;
        font-size: 28px;
    }
    .product-details {
        border-top: 2px solid #ddd;
        margin-top: 25px;
        padding-top: 20px;
        text-align: left;
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
        color: #333;
        margin-top: 15px;
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
        margin-top: 30px;
        font-size: 14px;
        color: #888;
        text-align: center;
    }
    .footer a {
        color: #3498db;
        text-decoration: none;
    }
</style>
</head>
<body>
<div class='container'>
    <div class='header'>
        <h2>Thank You for Your Purchase!</h2>
    </div>
    <p>Dear Valued Customer,</p>
    <p>We are thrilled to inform you that your order has been successfully placed on <strong>KitabiAdda</strong>!</p>
    <p>Here are the details of your recent purchase:</p>

    <div class='product-details'>
        <a href='https://kitabiadda.com/order_details.php?order_id=$last_id' ><img src='https://kitabiadda.com/assets/images/$book_imagee' alt='Product Image' class='product-image'></a>
        <p class='product-name'>Product Name: $book_namee</p>
        <p class='product-price'>Price: ₹$totleSellPrice2</p>
        <p class='product-description'>
            Description: $book_desc.
        </p>
    </div>

    <br>
    <p>We appreciate your trust in <strong>KitabiAdda</strong> and look forward to serving you again. Your satisfaction is our priority!</p>
    <br>
    <p>If you have any questions or concerns, feel free to reach out to our support team.</p>

    <br>
    <p>Warm regards,<br><strong>KitabiAdda Team</strong></p>

    <div class='footer'>
        <p>Need help? <a href='mailto:support@kitabiadda.com'>Contact Support</a></p>
        <p>If you did not make this purchase, please <a href='mailto:support@kitabiadda.com'>contact us</a> immediately.</p>
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
    echo '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                title: "✅ Order Confirmed!",
                text: "Thank you for your order.\\nTotal Amount: ₹' . $totleSellPrice2 . '",
                icon: "success",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = "order_details.php?order_id='.$last_id.'"; // Redirect to order details page
            });
        </script>
        ';
} else {
    echo "❌ Failed to send product details. Please try again later.";
}
?>
