<div class="panel panel-default panel-left">
	<div id="demo-email-list" class="panel-body">
                        
                        
                        
                        
                        
        <div class="file-manager">
            <a href="/messages/add" class="btn btn-primary compose-mail">Compose Mail</a>
            <div class="space-25"></div>
            <h5>Folders</h5>
            <ul style="padding: 0" class="folder-list m-b-md">
                <li><a href="/messages"> <i class="fa fa-inbox "></i> Inbox <?php if ((int) $j_inbox > 0) { ?><span class="label label-warning pull-right"><?php echo $j_inbox; ?></span> <?php } ?></a></li>
                <li><a href="/messages/sent"> <i class="fa fa-envelope-o"></i> Send Mail</a></li>
                <li><a href="mailbox.html"> <i class="fa fa-certificate"></i> Important</a></li>
                <li><a href="/messages/draft"> <i class="fa fa-file-text-o"></i> Drafts <?php if ((int) $j_draft > 0) { ?><span class="label label-danger pull-right"><?php echo $j_draft; ?></span><?php } ?></a></li>
                <li><a href="/messages/trash"> <i class="fa fa-trash-o"></i> Trash</a></li>
            </ul>
            <!----
            <h5>Categories</h5>
            <ul style="padding: 0" class="category-list">
                <li><a href="#"> <i class="fa fa-circle text-navy"></i> Work </a></li>
                <li><a href="#"> <i class="fa fa-circle text-danger"></i> Documents</a></li>
                <li><a href="#"> <i class="fa fa-circle text-primary"></i> Social</a></li>
                <li><a href="#"> <i class="fa fa-circle text-info"></i> Advertising</a></li>
                <li><a href="#"> <i class="fa fa-circle text-warning"></i> Clients</a></li>
            </ul>
            <h5 class="tag-title">Labels</h5>
            <ul style="padding: 0" class="tag-list">
                <li><a href="#"><i class="fa fa-tag"></i> Family</a></li>
                <li><a href="#"><i class="fa fa-tag"></i> Work</a></li>
                <li><a href="#"><i class="fa fa-tag"></i> Home</a></li>
                <li><a href="#"><i class="fa fa-tag"></i> Children</a></li>
                <li><a href="#"><i class="fa fa-tag"></i> Holidays</a></li>
                <li><a href="#"><i class="fa fa-tag"></i> Music</a></li>
                <li><a href="#"><i class="fa fa-tag"></i> Photography</a></li>
                <li><a href="#"><i class="fa fa-tag"></i> Film</a></li>
            </ul>
            <div class="clearfix"></div>
            -->
        </div>
    </div>
</div>