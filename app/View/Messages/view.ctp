<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            <?php echo $this->element('message_menu', array('inbox' => 10, 'draft' => 3)) ?>
        </div>
        <div class="col-lg-9 animated fadeInRight">
            <div class="mail-box-header">
                <div class="pull-right tooltip-demo">
                    <a title="Reply" data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm" href="/messages/add/<?php echo $message['User']['id'] ?>/<?php echo $message['Message']['id'] ?>"><i class="fa fa-reply"></i> Reply</a>
                    <a title="Print email" data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm" href="#"><i class="fa fa-print"></i> </a>
                    <a title="Move to trash" data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm" href="mailbox.html"><i class="fa fa-trash-o"></i> </a>
                </div>
                <h2>
                    View Message
                </h2>
                <div class="mail-tools tooltip-demo m-t-md">
                    <h3>
                        <span class="font-noraml">Subject: </span><?php echo $message['Message']['subject'] ?>.
                    </h3>
                    <h5>
                        <span class="pull-right font-noraml"><?php echo date('H:i A d F Y', strtotime($message['Message']['created'])) ?></span>
                        <span class="font-noraml">From: </span><?php echo $message['User']['username'] ?>
                    </h5>
                </div>
            </div>
            <div class="mail-box">
                <div class="mail-body">
                    <?php echo $message['Message']['message'] ?>
                </div>
                <!-- next feature
                <div class="mail-attachment">
                    <p>
                        <span><i class="fa fa-paperclip"></i> 2 attachments - </span>
                        <a href="#">Download all</a>
                        |
                        <a href="#">View all images</a>
                    </p>
                    <div class="attachment">
                        <div class="file-box">
                            <div class="file">
                                <a href="#">
                                    <span class="corner"></span>
                                    <div class="icon">
                                        <i class="fa fa-file"></i>
                                    </div>
                                    <div class="file-name">
                                        Document_2014.doc
                                        <br>
                                        <small>Added: Jan 11, 2014</small>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="file-box">
                            <div class="file">
                                <a href="#">
                                    <span class="corner"></span>
                                    <div class="image">
                                        <img src="img/p1.jpg" class="img-responsive" alt="image">
                                    </div>
                                    <div class="file-name">
                                        Italy street.jpg
                                        <br>
                                        <small>Added: Jan 6, 2014</small>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="file-box">
                            <div class="file">
                                <a href="#">
                                    <span class="corner"></span>
                                    <div class="image">
                                        <img src="img/p2.jpg" class="img-responsive" alt="image">
                                    </div>
                                    <div class="file-name">
                                        My feel.png
                                        <br>
                                        <small>Added: Jan 7, 2014</small>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="mail-body text-right tooltip-demo">
                    <a href="mail_compose.html" class="btn btn-sm btn-white"><i class="fa fa-reply"></i> Reply</a>
                    <a href="mail_compose.html" class="btn btn-sm btn-white"><i class="fa fa-arrow-right"></i> Forward</a>
                    <button class="btn btn-sm btn-white" data-original-title="Print" type="button" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-print"></i> Print</button>
                    <button class="btn btn-sm btn-white" data-original-title="Trash" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-trash-o"></i> Remove</button>
                </div>
                <div class="clearfix"></div>
                -->
            </div>
        </div>
    </div>
</div>