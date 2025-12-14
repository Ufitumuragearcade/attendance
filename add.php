<?php
session_start();
if(!isset($_SESSION['user_id'])) header("Location: ../auth/login.php");
require '../config/db.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
    $stmt=$pdo->prepare("INSERT INTO students (reg_no, fullname, department) VALUES (?,?,?)");
    $stmt->execute([$_POST['reg'], $_POST['name'], $_POST['dept']]);
    header("Location:index.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student - Attendance System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: #f8f9fa;
            padding: 20px;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
        }
        .form-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .form-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .form-body {
            padding: 40px;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
            transition: transform 0.2s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <i class="bi bi-person-plus-fill" style="font-size: 48px;"></i>
                <h2 class="mt-3 mb-0">Add New Student</h2>
                <p class="mb-0 opacity-75">Fill in the student information below</p>
            </div>
            
            <div class="form-body">
                <form method="POST">
                    <div class="mb-4">
                        <label for="reg" class="form-label">
                            <i class="bi bi-hash text-primary me-1"></i>Registration Number
                        </label>
                        <input type="text" class="form-control form-control-lg" id="reg" name="reg" 
                               placeholder="e.g., STU2024001" required>
                        <div class="form-text">Enter the unique registration number</div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="name" class="form-label">
                            <i class="bi bi-person text-primary me-1"></i>Full Name
                        </label>
                        <input type="text" class="form-control form-control-lg" id="name" name="name" 
                               placeholder="e.g., John Doe" required>
                        <div class="form-text">Enter the student's full name</div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="dept" class="form-label">
                            <i class="bi bi-building text-primary me-1"></i>Department
                        </label>
                        <input type="text" class="form-control form-control-lg" id="dept" name="dept" 
                               placeholder="e.g., Computer Science">
                        <div class="form-text">Enter the department (optional)</div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg btn-submit">
                            <i class="bi bi-check-circle me-2"></i>Add Student
                        </button>
                        <a href="index.php" class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-arrow-left me-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>