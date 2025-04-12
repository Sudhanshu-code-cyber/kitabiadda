<?php
if (isset($_SESSION['admin'])) {
   $admin = getAdminDetails();
}
else {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '🔒 Access Denied!',
                text: 'You Are not Admin',
                icon: 'error',
            })

            // ⏳ Auto Redirect after 5 seconds
            setTimeout(() => {
                window.location.href = '../index.php';
            }, 5000);
        });
    </script>";
    exit();
}