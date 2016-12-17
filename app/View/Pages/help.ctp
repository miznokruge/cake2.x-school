<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content animated fadeInUp">
            <div class="panel-body m-b-sm border-bottom">
                <div class="text-center p-lg">
                    <h2>If you don't find the answer to your question</h2>
                    <span>add your question by selecting </span>
                    <button title="Create new cluster" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <span class="bold">Add question</span></button> button
                </div>
            </div>
            <?php foreach ($faqs as $faq) { ?>
                <div class="faq-item">
                    <div class="row">
                        <div class="col-md-7">
                            <a data-toggle="collapse" href="#faq1" class="faq-question"><?php echo $faq['Faq']['title'] ?>?</a>
                            <small>Added by <strong>Alex Smith</strong> <i class="fa fa-clock-o"></i> Today 2:40 pm - 24.06.2014</small>
                        </div>
                        <div class="col-md-3">
                            <span class="small font-bold">Robert Nowak</span>
                            <div class="tag-list">
                                <span class="tag-item">General</span>
                                <span class="tag-item">License</span>
                            </div>
                        </div>
                        <div class="col-md-2 text-right">
                            <span class="small font-bold">Voting </span><br>
                            42
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="faq1" class="panel-collapse collapse faq-answer">
                                <?php echo $faq['Faq']['body'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>