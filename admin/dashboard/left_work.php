<?php include_once '../../config/connect.php'; ?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Rainbow (Admin)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            height: auto;
            padding: 20px;
            text-align: center;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            width: 100%;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .icon {
            font-size: 30px;
            margin-bottom: 10px;
        }
        .breadcrumb a {
            text-decoration: none;
            color: #6c757d;
        }
        .card_graph {
            height: 450px;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            background: #343a40;
            padding: 15px;
            color: white;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 10px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #495057;
            border-radius: 5px;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
            .sidebar {
                display: none;
                width: 100%;
            }
            .sidebar.show {
                display: block;
            }
            .card, .card_graph {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <?php include_once "../includes/admin_navbar.php"; ?>
    <div class="full-screen d-flex">
        <?php include_once "../includes/admin_sidebar.php"; ?>
        <div class="main-content flex-grow-1 p-4">
            <h2>Welcome to Read Rainbow</h2>
            <div class="container mt-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Hyper</a></li>
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Projects</li>
                    </ol>
                </nav>
                <h4 class="mb-3">Projects</h4>
                <div class="row g-4">
                    <div class="col-md-3 col-12">
                        <div class="card">
                            <div class="icon">📁</div>
                            <h3>29</h3>
                            <p>Total Projects</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="card">
                            <div class="icon">📋</div>
                            <h3>715</h3>
                            <p>Total Tasks</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="card">
                            <div class="icon">👥</div>
                            <h3>31</h3>
                            <p>Members</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="card">
                            <div class="icon">📈</div>
                            <h3>93% <span class="text-success">&#9650;</span></h3>
                            <p>Productivity</p>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6 mx-auto">
                        <div class="card_graph">
                            <h5>Project Status</h5>
                            <canvas id="projectChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let data = { completed: 64, in_progress: 26, behind: 10 };
            const ctx = document.getElementById('projectChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Completed', 'In-progress', 'Behind'],
                    datasets: [{
                        data: [data.completed, data.in_progress, data.behind],
                        backgroundColor: ['#28a745', '#007bff', '#dc3545']
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        });
        document.getElementById('sidebar-toggler').addEventListener('click', function () {
            document.querySelector('.sidebar').classList.toggle('show');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>