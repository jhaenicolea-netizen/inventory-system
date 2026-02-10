<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']); // Security improvement: intval
    $conn->query("DELETE FROM items WHERE id=$id");
    header("Location: dashboard.php");
}

// Fetch Items
$result = $conn->query("SELECT * FROM items ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Dashboard</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
        }
        
        /* Navbar Styling */
        .navbar-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: 600;
            color: white !important;
            font-size: 1.5rem;
        }
        
        /* Card Styling */
        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.2s;
            background: white;
        }
        
        /* Table Styling */
        .table-custom thead th {
            background-color: #f8f9fa;
            color: #6c757d;
            font-weight: 600;
            border-bottom: 2px solid #e9ecef;
            text-transform: uppercase;
            font-size: 0.85rem;
            padding: 15px;
        }
        .table-custom tbody td {
            padding: 15px;
            vertical-align: middle;
            color: #495057;
        }
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        /* Badge Styling */
        .badge-stock {
            padding: 8px 12px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.75rem;
        }
        
        /* Action Buttons */
        .btn-icon {
            width: 35px;
            height: 35px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            margin: 0 2px;
            transition: all 0.2s;
        }
        .btn-edit {
            background-color: #e3f2fd;
            color: #2196f3;
            border: none;
        }
        .btn-edit:hover {
            background-color: #2196f3;
            color: white;
        }
        .btn-delete {
            background-color: #ffebee;
            color: #f44336;
            border: none;
        }
        .btn-delete:hover {
            background-color: #f44336;
            color: white;
        }
        
        /* Add Form Styling */
        .form-control {
            border-radius: 10px;
            padding: 10px 15px;
            border: 1px solid #dee2e6;
        }
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.25);
            border-color: #667eea;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-custom mb-5">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-box-seam-fill me-2"></i> Inventory Manager
            </a>
            <div class="d-flex align-items-center text-white">
                <span class="me-3 d-none d-md-block">
                    <i class="bi bi-person-circle me-1"></i> 
                    <?php echo htmlspecialchars($_SESSION['user']); ?>
                </span>
                <a href="logout.php" class="btn btn-light btn-sm rounded-pill px-3 fw-bold text-primary">
                    Logout <i class="bi bi-box-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        
        <div class="card card-custom mb-5">
            <div class="card-body p-4">
                <h5 class="card-title mb-4 fw-bold text-secondary">
                    <i class="bi bi-plus-circle-fill text-success me-2"></i>Add New Item
                </h5>
                <form action="add.php" method="POST" class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label text-muted small fw-bold">Item Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Wireless Mouse" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small fw-bold">Quantity</label>
                        <input type="number" name="qty" class="form-control" placeholder="0" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small fw-bold">Price ($)</label>
                        <input type="number" step="0.01" name="price" class="form-control" placeholder="0.00" required>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100 rounded-3 py-2">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card card-custom">
            <div class="card-body p-0">
                <div class="p-4 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark">Current Inventory</h5>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-custom table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Item Name</th>
                                <th>Stock Level</th>
                                <th>Price</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark"><?= htmlspecialchars($row['name']) ?></div>
                                            <div class="small text-muted">ID: #<?= $row['id'] ?></div>
                                        </td>
                                        
                                        <td>
                                            <?php if($row['qty'] <= 5): ?>
                                                <span class="badge bg-danger bg-opacity-10 text-danger badge-stock">
                                                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Low: <?= $row['qty'] ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-success bg-opacity-10 text-success badge-stock">
                                                    <i class="bi bi-check-circle-fill me-1"></i> In Stock: <?= $row['qty'] ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <td class="fw-bold text-dark">
                                            $<?= number_format($row['price'], 2) ?>
                                        </td>
                                        
                                        <td class="text-end pe-4">
                                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-icon btn-edit" title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <a href="dashboard.php?delete=<?= $row['id'] ?>" 
                                               class="btn btn-icon btn-delete" 
                                               onclick="return confirm('Are you sure you want to delete this item?')"
                                               title="Delete">
                                                <i class="bi bi-trash-fill"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                        No items found in inventory.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>

</body>
</html>