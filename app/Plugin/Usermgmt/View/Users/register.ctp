<div class="main-block">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="text-center" style="margin-bottom: 10px;">
                    <?php echo $this->Util->flash(); ?>
                </div>
                <?php echo $this->Form->create('User', array('action' => 'register')); ?>
                <h3>Create your free account:</h3>
                <?php echo $this->Form->input("user_group_id", array("type" => 'hidden', 'value' => 4)); ?>
                <div class="field">
                    <?php echo $this->Form->input("first_name", array('div' => false, 'class' => "form-control")) ?>
                </div> <!-- /field -->
                <div class="field">
                    <?php echo $this->Form->input("last_name", array('div' => false, 'class' => "form-control")) ?>
                </div> <!-- /field -->
                <div class="field">
                    <?php echo $this->Form->input("email", array('div' => false, 'class' => "form-control")) ?>
                </div> <!-- /field -->
                <div class="field">
                    <?php echo $this->Form->input("password", array('div' => false, 'class' => "form-control", "label" => "Password")) ?>
                </div> <!-- /field -->
                <div class="field">
                    <?php echo $this->Form->input("cpassword", array('div' => false, 'class' => "form-control", "label" => "Confirm Password", 'type' => 'password')) ?>
                </div> <!-- /field -->
                <?php if (USE_RECAPTCHA && PRIVATE_KEY_FROM_RECAPTCHA != "" && PUBLIC_KEY_FROM_RECAPTCHA != "") { ?>
                    <div class="field">
                        <?php echo $this->UserAuth->showCaptcha(isset($this->validationErrors['User']['captcha'][0]) ? $this->validationErrors['User']['captcha'][0] : ""); ?>
                    </div>
                <?php } ?>
                <div class="login-actions">
                    <span class="login-checkbox">
                        <input id="Field" name="Field" class="field login-checkbox" value="First Choice" tabindex="4" type="checkbox">
                        <label class="choice" for="Field">I have read and agree with the Terms of Use.</label>
                    </span>
                    <button class="login-action btn btn-primary" type="submit">Register</button>
                </div> <!-- .actions -->
                <?php echo $this->Form->end(); ?>
            </div>
            <div class="col-md-5">

                <!-- Login starts -->
                <div class="well login-reg-form">
                    <!-- Heading -->
                    <h4><?php echo __('Login to your Account'); ?></h4>
                    <hr>
                    <!-- Form -->
                    <?php echo $this->Form->create('User', array('action' => 'login', 'class' => 'form-horizontal')); ?>
                    <!-- Form Group -->
                    <div class="text-center" style="margin-bottom: 10px;">
                        <?php echo $this->Common->flash(); ?>
                    </div>
                    <div class="form-group">
                        <!-- Label -->
                        <label class="col-sm-3 control-label" for="user">Username</label>
                        <div class="col-sm-9">
                            <!-- Input -->
                            <input name="data[User][email]" value="" placeholder="Email" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="password">Password</label>
                        <div class="col-sm-9">
                            <input name="data[User][password]" value="" placeholder="Password" class="form-control" type="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> Remember Me
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <!-- Button -->
                            <button class="btn btn-red btn-block" type="submit">Login</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <?php echo $this->Html->link(__("Forgot Password?", true), "/forgotPassword", array("class" => "black")) ?>
                            <?php echo $this->Html->link(__("Email Verification", true), "/emailVerification", array("class" => "black")) ?>
                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                    <hr>
                    <div style="text-align: center; font-weight: bold; font-size: 14px; margin: 5px auto;">
                        <?php echo __('Login with') ?>
                    </div>
                    <!-- Social Media Login -->
                    <div class="s-media text-center">
                        <!-- Button -->
                        <div class="social-login-box">
                            <?php
                            echo $this->Html->image("social-media/facebook.png", array(
                                "alt" => "Signin with Facebook",
                                'url' => array('action' => 'social_login', 'Facebook')
                            ));

                            echo $this->Html->image("social-media/google.png", array(
                                "alt" => "Signin with Google",
                                'url' => array('action' => 'social_login', 'Google')
                            ));

                            echo $this->Html->image("social-media/twitter.png", array(
                                "alt" => "Signin with Twitter",
                                'url' => array('action' => 'social_login', 'Twitter')
                            ));
                            echo $this->Html->image("social-media/linkedin.png", array(
                                "alt" => "Signin with LinkedIn",
                                'url' => array('action' => 'social_login', 'LinkedIn')
                            ));
                            ?>
                        </div>
                    </div>
                </div>
                <!-- Login ends -->
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById("UserUsername").focus();
</script>

