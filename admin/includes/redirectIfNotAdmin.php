<?php
if (isset($_SESSION['admin'])) {
    $admin = getAdminDetails();
} else {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            let redirected = false;

            Swal.fire({
                icon: 'error',
                title: '🔒 Access Denied!',
                text: 'You Are Not an Admin',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (!redirected && result.isConfirmed) {
                    redirected = true;
                    window.location.href = '../index.php';
                }
            });

            // Auto-redirect after 5 seconds
            setTimeout(() => {
                if (!redirected) {
                    redirected = true;
                    window.location.href = '../index.php';
                }
            }, 5000);
        });
    </script>";
    exit();
}

$adminName = $admin['name'];
