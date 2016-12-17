<div class="cls-content">
    <div class="cls-content-sm panel">
        <div class="panel-body">
            <?php if ($this->Session->read("Message.flash.message")) { ?>
            <div class="alert alert-danger"><?php echo $this->Session->read("Message.flash.message"); ?></div>
            <?php } ?>
            <p class="pad-btm">Sign In to your account</p>
            <?php echo $this->Form->create('User', array("class" => "m-t")); ?>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-user"></i></div>
                    <input type="text" class="form-control" placeholder="Username" name="data[User][username]">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                    <input type="password" class="form-control" placeholder="Password" name="data[User][password]">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-8 text-left checkbox">
                    <label class="form-checkbox form-icon">
                        <input type="checkbox"> Remember me
                    </label>
                </div>
                <div class="col-xs-4">
                    <div class="form-group text-right">
                        <button class="btn btn-success text-uppercase" type="submit">Sign In</button>
                    </div>
                </div>
                <!--                </div>
                                <div class="mar-btm"><em>- or -</em></div>
                                <button class="btn btn-primary btn-lg btn-block" type="button">
                                    <i class="fa fa-facebook fa-fw"></i> Login with Facebook
                                </button>-->
                <?php echo $this->Form->end(); ?>
            </div>
        </div>

    </div>
    <div class="pad-ver">
        <a href="<?php echo $this->webroot?>users/forget_password" class="btn-link mar-rgt">Forgot password ?</a>
        <a href="<?php echo $this->webroot?>users/register" class="btn-link mar-lft">Create a new account</a>
    </div>
</div>