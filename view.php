<?php
session_start();
if(!isset($_SESSION['user_id'])) header("Location: ../auth/login.php");
require '../config/db.php';

$records = $pdo->query("SELECT a.id, s.fullname, s.reg_no, a.status, a.date 
                        FROM attendance a 
                        JOIN students s ON a.student_id=s.id 
                        ORDER BY a.date DESC, s.fullname ASC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Records - Attendance System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: #f8f9fa;
            padding: 20px;
        }
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .table-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .table thead th {
            border: none;
            padding: 15px;
            font-weight: 600;
        }
        .table tbody tr {
            transition: background-color 0.2s;
        }
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        .badge-present {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            padding: 8px 16px;
            font-size: 14px;
        }
        .badge-absent {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            padding: 8px 16px;
            font-size: 14px;
        }
        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .empty-state i {
            font-size: 64px;
            color: #dee2e6;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h1 class="mb-2">
                        <i class="bi bi-journal-text me-2"></i>Attendance Records
                    </h1>
                    <p class="mb-0 opacity-75">Complete attendance history</p>
                </div>
                <div>
                    <a href="mark.php" class="btn btn-light btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>Mark Attendance
                    </a>
                </div>
            </div>
        </div>

        <?php if(count($records) > 0): 
            $present_count = count(array_filter($records, fn($r) => $r['status'] === 'Present'));
            $absent_count = count($records) - $present_count;
        ?>
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="bi bi-list-check text-primary" style="font-size: 40px;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-0">Total Records</h6>
                                <h2 class="mb-0"><?php echo count($records); ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="bi bi-check-circle text-success" style="font-size: 40px;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-0">Present</h6>
                                <h2 class="mb-0"><?php echo $present_count; ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="bi bi-x-circle text-danger" style="font-size: 40px;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-0">Absent</h6>
                                <h2 class="mb-0"><?php echo $absent_count; ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th><i class="bi bi-hash me-1"></i>ID</th>
                                <th><i class="bi bi-person me-1"></i>Student Name</th>
                                <th><i class="bi bi-card-text me-1"></i>Reg No</th>
                                <th><i class="bi bi-calendar-check me-1"></i>Status</th>
                                <th><i class="bi bi-clock me-1"></i>Date & Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($records as $r): ?>
                            <tr>
                                <td><?php echo $r['id']; ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($r['fullname']); ?></strong>
                                </td>
                                <td>
                                    <code><?php echo htmlspecialchars($r['reg_no']); ?></code>
                                </td>
                                <td>
                                    <?php if($r['status'] === 'Present'): ?>
                                        <span class="badge badge-present">
                                            <i class="bi bi-check-circle-fill me-1"></i>Present
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-absent">
                                            <i class="bi bi-x-circle-fill me-1"></i>Absent
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <i class="bi bi-calendar3 me-1"></i>
                                    <?php echo date('M d, Y - h:i A', strtotime($r['date'])); ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <h3 class="text-muted">No Attendance Records</h3>
                <p class="text-muted">Start marking attendance to see records here</p>
                <a href="mark.php" class="btn btn-primary btn-lg mt-3">
                    <i class="bi bi-plus-circle me-2"></i>Mark Attendance
                </a>
            </div>
        <?php endif; ?>

        <div class="mt-4">
            <a href="../dashboard.php" class="btn btn-outline-secondary btn-lg">
                <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>