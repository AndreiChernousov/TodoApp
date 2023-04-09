<?php include '../templates/header.php';
/**
 * @var array $user
 */
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">User Authorized</div>
                <div class="card-body">
                    <div class="card-row">User: <?=$user['name']?></div>
                    <a class="btn btn-primary" href="../logout/">Logout</a>
                    <a href="../" type="submit" class="btn btn-link"><-- Main page</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../templates/footer.php'; ?>
