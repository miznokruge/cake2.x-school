<?php
$loggeuser_id = $this->Session->read('UserAuth.User.id');
?>

<div class="cls-content">
    <div class="cls-content-sm panel">
        <div class="panel-heading">
            <h3 class="panel-title">Locked Screen</h3>
        </div>
        <div class="panel-body">
            <p>Your are in lock screen. Main app was shut down and you need to enter your passwor to go back to app.</p>
            <div class="middle-box text-center lockscreen animated fadeInDown">
                <div>
                    <div class="m-b-md">
                        <img alt="image" class="img-circle circle-border" src="/img/foto_profile/<?php echo str_replace('.', '_150.', $user_foto); ?>">
                    </div>
                    <h3><?php echo $this->Info->userdata($user_id, 'username'); ?></h3>
                    <?php echo $this->Form->create("User", array("class" => "m-t", "role" => "form", "url" => "/users/lockscreen/")); ?>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="****" required="">
                    </div>
                    <button type="submit" class="btn btn-primary block full-width">Unlock</button>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>