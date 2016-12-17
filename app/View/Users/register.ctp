<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <h3>Register to <?php echo $this->Info->app('nama'); ?></h3>
        <p>Create account to see it in action.</p>
        <form class="m-t" role="form" action="">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Name" required="">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" placeholder="Email" required="">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" required="">
            </div>
            <div class="form-group">
                <div class="checkbox i-checks"><label> <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div><i></i> Agree the terms and policy </label></div>
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">Register</button>
            <p class="text-muted text-center"><small>Already have an account?</small></p>
            <a class="btn btn-sm btn-white btn-block" href="login.html">Login</a>
        </form>
    </div>
</div>