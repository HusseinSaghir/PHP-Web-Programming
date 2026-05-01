<?php 
function init(){
    $message =$_SESSION['login_error'] ?? '';
    unset($_SESSION['login_error']);

    return <<<HTML
    <h1>Login</h1>
    <form method="POST" action="controllers/loginProc.php">
        <div class="mb-3">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <span class="text-danger">$message</span><br>
        <button type="submit" class="btn btn-primary mt-2">Login</button>
    </form>
HTML;
}
?>