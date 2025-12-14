<?php
session_start();
if(!isset($_SESSION['user_id'])) header("Location: ../auth/login.php");
require '../config/db.php';
$students = $pdo->query("SELECT * FROM students ORDER BY fullname ASC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students - Attendance System</title>
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
        .student-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .student-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .btn-action {
            padding: 5px 15px;
            font-size: 14px;
            margin: 0 3px;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .empty-state i {
            font-size: 64px;
            color: #dee2e6;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-2"><i class="bi bi-people-fill me-2"></i>Manage Students</h1>
                    <p class="mb-0 opacity-75">Add, edit, or remove students from the system</p>
                </div>
                <a href="add.php" class="btn btn-light btn-lg">
                    <i class="bi bi-plus-circle me-2"></i>Add New Student
                </a>
            </div>
        </div>

        <?php if(count($students) > 0): ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="bg-white rounded-3 shadow-sm p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="bi bi-list-ul me-2"></i>
                                Total Students: <span class="badge bg-primary"><?php echo count($students); ?></span>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php foreach($students as $s): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="student-card">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="flex-grow-1">
                                <h5 class="mb-2">
                                    <i class="bi bi-person-badge text-primary me-2"></i>
                                    <?php echo htmlspecialchars($s['fullname']); ?>
                                </h5>
                                <p class="mb-1 text-muted">
                                    <small><i class="bi bi-hash"></i> <?php echo htmlspecialchars($s['reg_no']); ?></small>
                                </p>
                                <?php if($s['department']): ?>
                                <p class="mb-3">
                                    <span class="badge bg-info">
                                        <i class="bi bi-building me-1"></i>
                                        <?php echo htmlspecialchars($s['department']); ?>
                                    </span>
                                </p>
                                <?php endif; ?>
                                
                                <div class="d-flex gap-2">
                                    <a href="edit.php?id=<?php echo $s['id']; ?>" 
                                       class="btn btn-sm btn-outline-primary btn-action">
                                        <i class="bi bi-pencil-square me-1"></i>Edit
                                    </a>
                                    <a href="delete.php?id=<?php echo $s['id']; ?>" 
                                       class="btn btn-sm btn-outline-danger btn-action"
                                       onclick="return confirm('Are you sure you want to delete this student?')">
                                        <i class="bi bi-trash me-1"></i>Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <h3 class="text-muted">No Students Yet</h3>
                <p class="text-muted">Start by adding your first student to the system</p>
                <a href="add.php" class="btn btn-primary btn-lg mt-3">
                    <i class="bi bi-plus-circle me-2"></i>Add Student
                </a>
            </div>
        <?php endif; ?>

        <div class="mt-4">
            <a href="../dashboard.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>