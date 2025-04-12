<?php
if (isset($_SESSION['admin'])) {
   $admin = getAdminDetails();
}
else {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
            icon: 'error',
            title: '🔒 Access Denied!',
            text: 'You Are Not an Admin',
            });

            // ⏳ Auto Redirect after 2 seconds
            setTimeout(() => {
                window.location.href = '../index.php';
            }, 2000);
        });
    </script>";
    exit();
}
$adminName = $admin['name'];