<?php
/*
  This file is part of UserMgmt.

  Author: Chetan Varshney (http://ektasoftwares.com)

  UserMgmt is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  UserMgmt is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
 */
?>
<div class="main-block">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h4><?php echo __('Don\'t have an account?'); ?></h4>
                <p>
                    <?php echo $this->Html->link(__("Free Sign Up", true), "/register", array('class' => "btn btn-green")) ?>
                </p>
                <br/>
                <h5><?php echo __('Why signup?'); ?></h5>
                <p>
                <ul>
                    <li>Get job opportunities from email</li>
                    <li>Ease apply job</li>
                    <li>Security guaranteed</li>
                </ul>
                </p>
                <br>
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