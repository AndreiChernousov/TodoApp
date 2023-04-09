<?php include '../templates/header.php';

/**
 * @var array $error
 */

$loginVal = filter_input(INPUT_POST,'login',FILTER_SANITIZE_EMAIL);
$passwordVal = filter_input(INPUT_POST,'password',FILTER_SANITIZE_SPECIAL_CHARS);
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <!-- error message -->
                    <?php if(isset($error['auth'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?=$error['auth']?>
                        </div>
                    <?php endif; ?>
                    <form method="post">
                        <input type="hidden" name="action" value="login">
                        <div class="form-group is-invalid">
                            <label for="username">Username</label>
                            <input type="text" class="form-control <?=isset($error['login'])?'is-invalid':''?>" name="login" id="login" autocomplete="off" value="<?=$loginVal?>">
                            <span class="error-message is-invalid"><?=$error['login']??''?></span>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control <?=isset($error['password'])?'is-invalid':''?>" id="password" name="password" autocomplete="off" value="<?=$passwordVal?>">
                            <span class="error-message"><?=$error['password']??''?></span>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="../" type="submit" class="btn btn-link"><-- Main page</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../templates/footer.php'; ?>
