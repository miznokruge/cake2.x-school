<ul class="nav nav-tabs">
    <li class="<?php if ($this->request->action == 'index'): ?>active<?php endif; ?>"">
        <a href="<?php echo $this->webroot . $this->request->controller; ?>">All</a>
    </li>
    <li class="<?php if ($this->request->action == 'unposted'): ?>active<?php endif; ?>"">
        <a href="<?php echo $this->webroot . $this->request->controller; ?>/unposted">Un posted</a>
    </li>
    <li class="<?php if ($this->request->action == 'posted'): ?>active<?php endif; ?>"">
        <a href="<?php echo $this->webroot . $this->request->controller; ?>/posted">Posted</a>
    </li>
</ul>