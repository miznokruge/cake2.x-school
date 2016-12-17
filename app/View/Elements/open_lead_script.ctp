<!-- Script for all openlead/add/edit order type -->
<script type="text/mustache" id="selectModel">
	<select name="data[Buy][name][]" class="slcItem">
	<option value="0">-- Pilih Type --</option>
	{{# items }}	
		<option {{# selected }}selected="selected"{{/ selected }} value="{{ RevinoItem.name }}">{{ RevinoItem.name }}</option>	
	{{/ items }}
	</select>
</script>
<script type="text/mustache" id="selectMod">
    <select name="data[Buy][name][]" class="slcItem">
    <option value="0">-- Pilih Type --</option>
    {{# items }}    
        <option {{# selected }}selected="selected"{{/ selected }} value="{{ Product.id }}+{{ Product.product_name }}">{{ Product.product_name }}</option>  
    {{/ items }}
    </select>
</script>
<script type="text/javascript">
	var modelDefault = '<input type="text" placeholder="Tipe model Barang" name="data[Buy][name][]">';
	var priceDefault = '<div class="input text required"><label for="BuyListPrice">Pricelist / Unit</label>'+
					   '<input type="text" id="BuyListPrice" placeholder="Rp" class="auto" name="data[Buy][list_price][]"></div>';
	//var _revinoModelCache = [];
	function parseSelect( target )
    {
		var url = "<?php echo $this->webroot;?>revinos/lookup";
		$.get(url,function(response){
			if( response.Result == "OK" ){				
				var tpl = $('#selectModel').html();
                for( var item in response.items )
                {
                    console.log(target.val());
                    if( response.items[item]['RevinoItem']['name'] == target.val() )
                        response.items[item]['selected'] = true;
                    else
                        response.items[item]['selected'] = false;
                }
				target.replaceWith( Mustache.to_html(tpl,response) );
			}else{
				alert( response.Message );
			}
		},'json');			
	}
    function parseText( target, supplierId )
    {
        var url = "<?php echo $this->webroot;?>openlead/getProductData/" + supplierId;
        $.get(url,function(response){
            if( response.Result == "OK" ){              
                var tpl = $('#selectMod').html();
                for( var item in response.items )
                {
                    console.log(target.val());
                    if( response.items[item]['Product']['product_name'] == target.val() )
                        response.items[item]['selected'] = true;
                    else
                        response.items[item]['selected'] = false;
                }
                target.replaceWith( Mustache.to_html(tpl,response) );
            }else{
                alert( response.Message );
            }
        },'json');          
    }
    /*function giveDiscountValue(target, proid){
        var url = "<?php echo $this->webroot;?>openlead/getProductDiscount/" + proid;
        $.get(url,function(response){
            if( response.Result == "OK" ){
                target.val(response.discount);
            }else{
                alert( response.Message );
            }
        },'json');
    }*/
$(function(){
    $('input.auto').autoNumeric({aSep: ',', aDec: '.', aSign:'Rp '});
    $('.datepicker').datepicker({dateFormat:'dd-mm-yy'});
    $('form').submit(function(event){
    	//if( !$(this).validationEngine('validate') ) return false;
        // Checking for empty values
        var notEmpty = true;        
        $('div.required input').each(function(){
            if ($.trim(this.value) == ''){
                notEmpty = false;
                $(this).parent().addClass('error');
            }else{
                $(this).parent().removeClass('error');
            }
        });        
        // Supplier info check
        var supp_buys = [];
        var correctSupplier = true;
        var errMsg = '';
        $('.supplier_buy').each(function(){
            supp_buys[$(this).val()] = true;
        });   
        $('.supplier_order').each(function(){
            var soVal = $(this).val();            
            if (soVal in supp_buys){
                if (supp_buys[soVal] === true){
                    supp_buys[soVal] = false;
                }
                else{
                    correctSupplier = false;
                    errMsg = 'Ada beberapa supplier yang sama di supplier box';
                }
            }
            else{
                correctSupplier = false;
                errMsg = 'Ada supplier yang tidak perlu dimasukan karena kita tidak beli barangnya';
            }            
        });  
        for (var key in supp_buys){
            if (supp_buys[key] == true){
                correctSupplier = false;
                errMsg = 'Kurang supplier: Ada supplier yang belum dimasukan di daftar supplier.';
                break;
               event.preventDefault();
               return false;               
            }
        }        
        if (!correctSupplier){
            alert(errMsg);
            event.preventDefault();
            return false;
        }
        if (notEmpty && correctSupplier &&
            confirm("Apakah kamu yakin semua data di sini sudah benar? Kamu tidak boleh mengganti lagi setelahnya."))
        {       
            return true;
        }
        else{
            console.log('here')
            event.preventDefault();
            return false;
        }
    });// end of form submit   
    $('#add_order_buy').click(
        function(){
            $('div.order_buys').append('<?php echo str_replace(array("\r","\n"), '', $order_buy); ?>');
            $('input.auto').each(function(){
                $(this).autoNumeric({aSep: ',', aDec: '.', aSign:'Rp '});
            });            
            $('a.remove_order_buy').each(function(){
                $(this).click(function(){
                   $(this).parent().remove();
                   return false;
                });
            });
            return false;
        }
    );
    $('a.remove_order_buy').each(function(){
        $(this).click(function(){
           $(this).parent().remove();
           return false;
        });
    });
    $('#add_order_supplier').click(
        function(){
            $('div.order_suppliers').append('<?php echo str_replace(array("\r","\n"), '', $order_supplier); ?>');
            $('input.auto').each(function(){
                $(this).autoNumeric({aSep: ',', aDec: '.', aSign:'Rp '});
            });            
            $('.datepicker').datepicker({dateFormat:'dd-mm-yy'});
            $('a.remove_order_supplier').each(function(){
                $(this).click(function(){
                   $(this).parent().remove();
                   return false;
                });
            });
            return false;
        }
    );
    $('#add_order_shipping').click(
        function(){
            $('div.order_shippings').append('<?php echo str_replace(array("\r","\n"), '', $order_shipping); ?>');
            $('input.auto').each(function(){
                $(this).autoNumeric({aSep: ',', aDec: '.', aSign:'Rp '});
            });            
            $('a.remove_order_shipping').each(function(){
                $(this).click(function(){
                   $(this).parent().remove();
                   return false;
                });
            });
            return false;
        }
    );       
    $('form#OrderBaseForm').validationEngine(); 
    $('input#ckAddress').click(function(){
    	var _checked =  $(this).is(':checked');
    	var form = $('form.order-form');
    	if( _checked ){
    		var _custAddress = form.find('input[name="data[Customer][address]"]').val();
    		var _custCity = form.find('input[name="data[Customer][city]"]').val();
    		form.find('textarea[name="data[Order][ship_address]"]').val( _custAddress );
    		form.find('input[name="data[Order][ship_city]"]').val( _custCity );
            console.log(_custAddress);
    	}else{
    		form.find('textarea[name="data[Order][ship_address]"]').val( '' );
    		form.find('input[name="data[Order][ship_city]"]').val( '' );    		
    	}   	
    });
    $(document).on('change','select.slcItem',function(el){
        var slc = el.target;
        var fullname = $(this).val();
        var proid = fullname.substring(0, fullname.indexOf("+"));
        var productIdTarget = $(slc).parent().next().next().next().next().next().next();
        var discTarget = productIdTarget.prev().prev().find('input');
        //giveDiscountValue(discTarget, proid);
        productIdTarget.val(proid);
    });
    <?php if( !in_array($this->view, array('boss_item_edit','suggest_edit','compare') ) ):?>
    //revino
    $(document).on('change','select.supplier_buy',function(el){
        var supplierId = $(this).val();
    	var slc = el.target;
        var text = $(slc).find('option:selected').text();
  		var target = $(slc).parent().next().children().eq(1);
		var priceTarget = $(slc).parent().next().next().next().next();
    	if( $.trim(text).toLowerCase() == 'revino' ){
            priceTarget.hide();
            priceTarget.next().next().next().next().hide();
            priceTarget.find('input').val(0);
    		parseSelect( target );
        }
        else{
            priceTarget.show();
            priceTarget.next().next().next().next().show();
            priceTarget.find('input').val('');
            parseText( target, supplierId );
        }
    });
    $('select.supplier_buy').change();
    <?php endif;?>
});
</script>