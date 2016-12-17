<?php

/**
 * MyajaxHelper is 
 *
 * @author Mizno Kruge
 * @since May 16, 2012
 * Copyright "PT Tricipta Media Perkasa" all rights reserved
 */
class MyajaxHelper extends Helper{
    var $helpers = array('Html', 'Javascript', 'Form');  
    public function __construct(View $view, $settings = array()){
        parent::__construct($view,$settings);
    }       //put your code here
    
    public function dragDropBox($state, $orderId){
echo $this->Html->css('bootstrap.min'); 
echo $this->Html->css('bootstrap-responsive.min'); 
echo $this->Html->css('bootstrap-image-gallery.min'); 
echo $this->Html->css('jquery.fileupload-ui'); 
print <<<DRAGDROPBOX
<div class="container">
    <!-- The file upload form used as target for the file upload widget -->
    <form id="fileupload" action="$this->webroot$state/save_proof_ajax/$orderId" method="POST" enctype="multipart/form-data">
        <h3>Tolong Drag Gambar Bukti Transfer Ke Kotak Ini</h3>
        <h5>Lalu Klik "Start" saat anda sudah cek itu gambar yang benar</h5>        
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="span7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="icon-plus icon-white"></i>
                    <span>Add files...</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="icon-upload icon-white"></i>
                    <span>Start upload</span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="icon-ban-circle icon-white"></i>
                    <span>Cancel upload</span>
                </button>
            </div>
        </div>
        <!-- The loading indicator is shown during file processing -->
        <div class="fileupload-loading"></div>
        <br>
        <!-- The table listing the files available for upload/download -->
        <table class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
    </form>
    <br>
</div>
<!-- modal-gallery is the modal dialog used for the image gallery -->
<div id="modal-gallery" class="modal modal-gallery hide fade" data-filter=":odd">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3 class="modal-title"></h3>
    </div>
    <div class="modal-body"><div class="modal-image"></div></div>
    <div class="modal-footer">
        <a class="btn modal-download" target="_blank">
            <i class="icon-download"></i>
            <span>Download</span>
        </a>
        <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000">
            <i class="icon-play icon-white"></i>
            <span>Slideshow</span>
        </a>
        <a class="btn btn-info modal-prev">
            <i class="icon-arrow-left icon-white"></i>
            <span>Previous</span>
        </a>
        <a class="btn btn-primary modal-next">
            <span>Next</span>
            <i class="icon-arrow-right icon-white"></i>
        </a>
    </div>
</div>        
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name"><span>{%=file.name%}</span></td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress progress-success progress-striped active"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i>
                    <span>{%=locale.fileupload.start%}</span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="icon-ban-circle icon-white"></i>
                <span>{%=locale.fileupload.cancel%}</span>
            </button>
        {% } %}</td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
            <td></td>
            <td class="name"><span>{%=file.name%}</span></td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else { %}
            <td class="preview">{% if (file.url) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.url%}" style="width:500px;"></a>
            {% } %}</td>
            <td class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
            </td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td colspan="2"></td>
        {% } %}
    </tr>
{% } %}
</script>
DRAGDROPBOX;

echo $this->Javascript->link('vendor/jquery.ui.widget.js'); 
echo $this->Javascript->link('tmpl.min.js');
echo $this->Javascript->link('load-image.min.js'); 
echo $this->Javascript->link('canvas-to-blob.min.js'); 
echo $this->Javascript->link('bootstrap.min.js');
echo '<!-- Bootstrap JS and Bootstrap Image Gallery are not required, but included for the demo -->';
echo $this->Javascript->link('bootstrap.min.js'); 
echo '<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->';
echo $this->Javascript->link('jquery.iframe-transport.js');
echo '<!-- The basic File Upload plugin -->';
echo $this->Javascript->link('jquery.fileupload.js'); 
echo '<!-- The File Upload file processing plugin -->';
echo $this->Javascript->link('jquery.fileupload-fp.js'); 
echo '<!-- The File Upload user interface plugin -->';
echo $this->Javascript->link('jquery.fileupload-ui.js'); 
echo '<!-- The localization script -->';
echo $this->Javascript->link('locale.js');
echo '<!-- The main application script -->';
echo $this->Javascript->link('main.js');
echo '<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->';
echo '<!--[if gte IE 8]><script src="js/cors/jquery.xdr-transport.js"></script><![endif]-->';
    }
   
    function formDragDrop($state, $orderId, $formId, $addition = '', $start_addition = ''){
echo '<form action="'.$this->webroot.$state.'/pay/'.$orderId.'" id="'.$formId.'" class="dragDropBaseForm" method="post" accept-charset="utf-8">';
    echo $start_addition;
    echo $this->Form->input('Payment.date', array('type' => 'date', 'div' => 'required'));
    echo $this->Form->input('Payment.description', array('label' => 'Keterangan', 'div' => 'required'
        ,'type' => 'textarea'));
    echo $this->Form->input('Payment.amount', array('type' => 'text', 'label' => 'Jumlah'
        ,'class' => 'auto', 'div' => 'required', 'placeholder' => 'Rp '));
    echo $this->Form->input('Payment.balance', array('type' => 'text', 'label' => 'Saldo'
        ,'class' => 'auto', 'div' => 'required', 'placeholder' => 'Rp '));
    echo $addition;

echo '</form>';
print <<<FORMDRAGDROP
<script>
    $(function(){
        $('input.auto').autoNumeric({aSep: ',', aDec: '.', aSign:'Rp '});
        $('form.dragDropBaseForm').submit(function(event){
        var notEmpty = true;
        $('div.required input').each(function(){
            if ($.trim(this.value) == ''){
                notEmpty = false;
                $(this).parent().addClass('error');
            }else{
                $(this).parent().removeClass('error');
            }
        });
        if (notEmpty && 
            confirm("Apakah kamu yakin semua data di sini sudah benar? Kamu tidak boleh mengganti lagi setelahnya."))
        {       
            return true;
        }
        else{
            event.preventDefault()
            return false;
        }
    });    
    });
</script>        
FORMDRAGDROP;
}
    public function rangePicker($indexUrl, $fromDate, $toDate = null, $users = null, $users_chosen_id = 0, $by, $suppliers = null, $suppliers_chosen_id = 0){
        $html = '';
        $html .= '
            <div class="sa_selector">
                <form id="range-picker">';
        $html .= '
                    <strong>View Orders for</strong><br />
                    <a href="'.$indexUrl.'today">Today</a><br />
                    <a href="'.$indexUrl.'thisweek/">Last Week</a><br />
                    <a href="'.$indexUrl.'thismonth/">Last Month</a><br /><br />
                    <strong>Condition</strong><br />
                    <strong><small>Type</small></strong><br />
                    <select id="by-chart">
                        <option value="both" '.($by == 'both' ? 'selected' : '').'>Compare Sales & Profit</option>
                        <option value="sales" '.($by == 'sales' ? 'selected' : '').'>Sales</option>
                        <option value="profit" '.($by == 'profit' ? 'selected' : '').'>Profit</option>
                        <option value="order" '.($by == 'order' ? 'selected' : '').'>Order</option>
                    </select><br />
                    <strong><small>From</small></strong><br />
                    <input name="from-date" id="from-date" type="text" value="'.$fromDate.'"/><br />
                    <strong><small>To</small></strong><br />
                    <input name="to-date" id="to-date" type="text" value="'.$toDate.'"/><br />
                    <strong><small>User</small></strong><br />
                    ';
        if ($users){
            $html .= '<select id="sales">';
            $html .= '<option value="0">All</option>';
            foreach ($users as $id => $name){
                $selected = $id == $users_chosen_id ? 'selected="selected"' : '';
                $html .= '
                        <option value="'.$id.'" '.$selected.'>'.$name.'</option>';
            }
            $html .= '
                    </select><br />';
        }
        if($suppliers_chosen_id == -1){
            $html .= '
                <br /><strong><small>Another Filter Option</small></strong><br />
                <input type="hidden" readonly id="supplier" value="0">
                <a href="'.$this->webroot.'reports/salessupplier/" style="padding-left:0px;"><button type="button" class="btn btn-primary">Filter by Supplier</button></a>
            ';
        }
        else{
            if ($suppliers){
                $html .= '
                        <strong><small>Supplier</small></strong><br />
                        <select id="supplier">';
                if(!strpos($indexUrl, 'supplier')){
                    $html .= '<option value="0">All</option>';
                }
                foreach ($suppliers as $id => $name){
                    $selected = $id == $suppliers_chosen_id ? 'selected="selected"' : '';
                    $html .= '
                            <option value="'.$id.'" '.$selected.'>'.$name.'</option>';
                }
                $html .= '
                        </select>';
            }
        }
        $html .= '
                </form>
            </div>';
        echo $html;
        $base = $this->webroot;
print <<<RANGEPICKERSCRIPT
<script>
    $('#from-date').datepicker({dateFormat:'dd-mm-yy'});
    $('#to-date').datepicker({dateFormat:'dd-mm-yy'});
    $('#range-picker').change(function(){
        var from = $('#from-date').val();
        var to = $('#to-date').val();
        var by = $('#by-chart').val();
        var salesID = $('#sales').val();
        var supplierID = $('#supplier').val();
        var nextLocation = '$indexUrl' + from + '/' + to + '/';
        nextLocation += salesID + '/';
        nextLocation += by + '/';
        nextLocation += supplierID + '/';
        window.location = nextLocation;
    });
</script>
RANGEPICKERSCRIPT;
    }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function conditionselector($indexUrl, $gtype, $fromDate, $toDate, $sales, $sid){
        $html = '';
        $html .= '
            <div class="pr_selector">
                <form id="condition-selector">
                    <strong>View Products for</strong><br />
                    <a href="'.$indexUrl.'today">Today</a><br />
                    <a href="'.$indexUrl.'thisweek/">Last Week</a><br />
                    <a href="'.$indexUrl.'thismonth/">Last Month</a><br /><br />
                    <strong>Condition</strong><br />
                    <strong><small>Type</small></strong><br />
                    <select id="pr_gtype">
                        <option value="product" '.($gtype == 'product' ? 'selected' : '').'>Product</option>
                        <!--option value="sop" '.($gtype == 'sop' ? 'selected' : '').'>Sales of Product</option-->
                    </select>
                    <br />
                    <strong><small>From</small></strong><br />
                    <input name="from-date" id="from-date" type="text" value="'.$fromDate.'"/>
                    <br />
                    <strong><small>To</small></strong><br />
                    <input name="to-date" id="to-date" type="text" value="'.$toDate.'"/><br />';
        if ($sales){
            $html .= '
                    <strong><small>By</small></strong><br />
                    <select id="pr_sales">
                        <option value="0">All</option>';
            foreach ($sales as $id => $name){
                $selected = $id == $sid ? 'selected="selected"' : '';
                $html .= '
                        <option value="'.$id.'" '.$selected.'>'.ucfirst($name).'</option>';
            }
            $html .= '
                    </select>';
        }

        $html .= '
                    <input type="hidden" value="'.Router::url('/', true).'" id="pr_url" />
                </form>
            </div>
        ';

        echo $html;

print <<<RANGEPICKERSCRIPT
<script>
    $('#from-date').datepicker({dateFormat:'dd-mm-yy'});
    $('#to-date').datepicker({dateFormat:'dd-mm-yy'});
    $('#condition-selector').change(function(){
        var gtype = $('#pr_gtype').val();
        var fromDate = $('#from-date').val();
        var toDate = $('#to-date').val();
        var sales = $('#pr_sales').val();
        var nextLocation = '$indexUrl' + fromDate + '/' + toDate + '/' + sales + '/' + gtype + '/';
        window.location = nextLocation;
    });
</script>
RANGEPICKERSCRIPT;
    }
}

?>
