<?php
session_start();
if(!isset($_SESSION['user_id'])) header("Location: ../auth/login.php");
require '../config/db.php';

$students = $pdo->query("SELECT * FROM students ORDER BY fullname ASC")->fetchAll();
$success = false;

if($_SERVER['REQUEST_METHOD']==='POST'){
    $stmt = $pdo->prepare("INSERT INTO attendance (student_id, status, date) VALUES (?,?,NOW())");
    $stmt->execute([$_POST['student'], $_POST['status']]);
    $success = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance - Attendance System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: #f8f9fa;
            padding: 20px;
        }
        .form-container {
            max-width: 700px;
            margin: 0 auto;
        }
        .form-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .form-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .form-body {
            padding: 40px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }
        .btn-submit {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
            transition: transform 0.2s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
        }
        .status-option {
            padding: 20px;
            border: 2px solid #dee2e6;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }
        .status-option:hover {
            border-color: #28a745;
            background: #f8f9fa;
        }
        .status-option input[type="radio"] {
            display: none;
        }
        .status-option input[type="radio"]:checked + label {
            color: #28a745;
            font-weight: bold;
        }
        .status-option.present {
            border-color: #28a745;
        }
        .status-option.absent {
            border-color: #dc3545;
        }
        .status-option.present input[type="radio"]:checked ~ i {
            color: #28a745;
        }
        .status-option.absent input[type="radio"]:checked ~ i {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <?php if($success): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong>Success!</strong> Attendance has been marked successfully.
            <a href="view.php" class="alert-link">View Records</a>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <div class="form-card">
            <div class="form-header">
                <i class="bi bi-clipboard-check-fill" style="font-size: 48px;"></i>
                <h2 class="mt-3 mb-0">Mark Attendance</h2>
                <p class="mb-0 opacity-75">Record student attendance for today</p>
            </div>
            
            <div class="form-body">
                <form method="POST" id="attendanceForm">
                    <div class="mb-4">
                        <label for="student" class="form-label">
                            <i class="bi bi-person-fill text-success me-1"></i>Select Student
                        </label>
                        <select name="student" id="student" class="form-select form-select-lg" required>
                            <option value="">-- Choose a student --</option>
                            <?php foreach($students as $s): ?>
                            <option value="<?php echo $s['id']; ?>">
                                <?php echo htmlspecialchars($s['fullname']); ?> 
                                (<?php echo htmlspecialchars($s['reg_no']); ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="bi bi-calendar-check text-success me-1"></i>Attendance Status
                        </label>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="status-option present">
                                    <input type="radio" name="status" value="Present" id="present" required>
                                    <label for="present" class="w-100">
                                        <i class="bi bi-check-circle-fill" style="font-size: 32px;"></i>
                                        <div class="mt-2">Present</div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="status-option absent">
                                    <input type="radio" name="status" value="Absent" id="absent" required>
                                    <label for="absent" class="w-100">
                                        <i class="bi bi-x-circle-fill" style="font-size: 32px;"></i>
                                        <div class="mt-2">Absent</div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg btn-submit">
                            <i class="bi bi-save me-2"></i>Mark Attendance
                        </button>
                    </div>
                </form>

                <div class="mt-4 d-flex gap-2">
                    <a href="view.php" class="btn btn-outline-primary flex-fill">
                        <i class="bi bi-list-ul me-2"></i>View Records
                    </a>
                    <a href="../dashboard.php" class="btn btn-outline-secondary flex-fill">
                        <i class="bi bi-house me-2"></i>Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add click handlers to status options
        document.querySelectorAll('.status-option').forEach(option => {
            option.addEventListener('click', function() {
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;
                
                // Remove active state from all options
                document.querySelectorAll('.status-option').forEach(opt => {
                    opt.style.borderWidth = '2px';
                });
                
                // Add active state to clicked option
                this.style.borderWidth = '3px';
            });
        });
    </script>
</body>
</html>