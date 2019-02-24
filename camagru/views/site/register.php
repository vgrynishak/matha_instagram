<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-02-02
 * Time: 22:52
 */

require_once (ROOT."/views/layouts/header.php");
?>
    <aside class=" right">
        <form method="POST">
            <label>Username:</label><input type="text" name="login"><br />
            <label>Password:</label><input type="password" name="passwd">
            <input type="button" name="pres" value="Login">
            <a href="login">Not registered? Create an account</a>
        </form>

    </aside>

<!--    <div class="hidden-xs hidden-sm main">main</div>-->

<?php
require_once (ROOT."/views/layouts/footer.php");