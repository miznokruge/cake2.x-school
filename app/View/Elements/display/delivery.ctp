<?php $deliveryUrl = $this->webroot . 'delivery/show/ajax' ?>
    var store = null;
    var isset = function(x) {
        return typeof(x) != "undefined" && x !== null
    }
    var updatePOField = function(po, model, field, colName) {
        var poName = getPODivID(po['Pos']['id']);
        if (model === 'Pos' && field === 'pre_checker'
                && colName == 'col-early') {
            // Update
            if (po[model][field] > 0) {
                $('#' + poName + ' .checkmark').addClass('checked');
                $('#' + poName + ' .circle').addClass('done');
            }
            else {
                $('#' + poName + ' .checkmark').removeClass('checked');
                $('#' + poName + ' .circle').removeClass('done');
            }
        }
        else if (model === 'Pos' && field === 'today_checker'
                && colName == 'col-today') {
            // Update
            if (po[model][field] > 0) {
                $('#' + poName + ' .checkmark').addClass('checked');
                $('#' + poName + ' .circle').addClass('done');
            }
            else {
                $('#' + poName + ' .checkmark').removeClass('checked');
                $('#' + poName + ' .circle').removeClass('done');
            }
            if (po[model]['pre_checker'] == 0) {
                $('#' + poName + ' .circle').addClass('no-precheck');
            }
            else {
                $('#' + poName + ' .circle').removeClass('no-precheck');
            }
        }
        else if (model === 'Pos' && field === 'date_changed_by') {
            if (po[model][field] > 0) {
                $('#' + poName + ' .circle').addClass('changed-date');
            }
            else {
                $('#' + poName + ' .circle').removeClass('changed-date');
            }
        }
        else {
            var loModel = model.toLowerCase();
            var loField = field.toLowerCase();
            $('#' + poName + ' .' + loModel + '-' + loField).html(po[model][field]);
        }
    }
    var getPODivID = function(poId) {
        return 'po-' + poId;
    }
    var getGroupName = function(supplierId) {
        return 'group-' + supplierId;
    }
    var removePO = function(poId) {
        var poName = getPODivID(poId);
        $('#' + poName).fadeOut();
        $('#' + poName).remove();
    }
    var removeSupplierGroup = function(supplierId, ori, next, colName) {
        var groupSupp = $('#' + colName + ' .' + getGroupName(supplierId));
        groupSupp.fadeOut();
        groupSupp.remove();
        // Remove the actual array
        delete ori[supplierId];
    }
    var addPO = function(supplierId, ori, next, colName) {
        // For each PO in the supplier group
        for (var poId in next[supplierId]) {
            var poName = getPODivID(poId);
            var poObj = $('#' + poName);
            var po = next[supplierId][poId];
            var groupSupp = $('#' + colName + ' .' + getGroupName(supplierId));
            // If PO does not exist, add it
            if (poObj.length <= 0) {
                // Adding it to store
                ori[supplierId][poId] = next[supplierId][poId];
                var checked = '';
                var status = '';
                var late = '';
                if ((po['Pos']['pre_checker'] > 0) && colName == 'col-early') {
                    checked += ' checked';
                    status += ' done';
                }
                if (po['Pos']['today_checker'] > 0 && colName == 'col-today') {
                    checked += ' checked';
                    status += ' done';
                }
                if (po['Pos']['pre_checker'] == 0 && colName == 'col-today') {
                    status += ' no-precheck';
                }
                if (po['Pos']['date_changed_by'] > 0) {
                    status += ' changed-date';
                }
                if (po['os']['is_late'] == 'true') {
                    late = 'late';
                }
                var poHtml = '<div id="' + poName + '" class="pos ' + late + '">'
                        + '<div class="checkmark ' + checked + '"></div>'
                        + '<span class="pos-path">' + po['Pos']['path'] + '</span>'
                        + '<span class="customer-name">' + po['Customer']['name'] + '</span>'
                        + '<div class="right">';
                if (po['Supplier']['image'] == '') {
                    poHtml += '<span class="supplier-name">' + po['Supplier']['name'] + '</span>'
                } else if (po['Supplier']['image'] == 'siap_kirim') {
                    poHtml += '<span class="supplier-name"><span>Invoice siap kirim</span></span>'
                }
                else {
                    poHtml += '<span class="supplier-name"><img class="supplier-pics" src="' + po['Supplier']['image'] + '" title="'
                            + po['Supplier']['name'] + '"/></span>';
                }
                poHtml += '<div class="circle ' + status + '"></div>'
                        + '</div>'
                        + '</div>';
                groupSupp.append(
                        poHtml
                        );
            }
            else {
                // Check if anything changed
                var origPO = ori[supplierId][poId];
                for (var model in po) {
                    for (var field in po[model]) {
                        if (origPO[model][field] != po[model][field]) {
                            // Update new field
                            console.log('Update ' + model + '-' + field + ' to ' + po[model][field]);
                            updatePOField(po, model, field, colName);
                            //update on ori
                            origPO[model][field] = po[model][field];
                        }
                    }
                }
            }
        }
    }
    var addSupplierGroup = function(supplierId, ori, next, colName) {
        var groupName = getGroupName(supplierId);
        // If no supplier group yet, create it
        var groupSupp = $('#' + colName + ' .' + groupName);
        if (groupSupp.length <= 0) {
            // Add it to the column                
            $('<div class="' + groupName + '"></div>').hide().appendTo($('#' + colName)).fadeIn();
            groupSupp = $('#' + colName + ' .' + groupName);
        }
        addPO(supplierId, ori, next, colName);
    }
    var whatsNew = function(ori, next, colName) {
//        console.log(ori);
        for (var supplierId in next) {
//            console.log(supplierId);
            // If supplierId exist in ori
            if (isset(ori[supplierId])) {
                // Go through all element inside                
//                console.log('Supplier exist');
                addPO(supplierId, ori, next, colName);
            }
            else {
                // Otherwise add it                
                ori[supplierId] = next[supplierId];
//                console.log('Adding new supplier');
                addSupplierGroup(supplierId, ori, next, colName);
            }
        }
        whatsOut(ori, next, colName);
//        console.log(next);
    }
    var whatsOut = function(ori, next, colName) {
        for (var supplierId in ori) {
            if (!isset(next[supplierId])) {
                removeSupplierGroup(supplierId, ori, next, colName);
//console.log('Supplier Group:'+supplierId+' has been removed');
            }
            else {
                // Check if anything changed
                for (var poId in ori[supplierId]) {
                    if (!isset(next[supplierId][poId])) {
                        removePO(poId, ori, next, colName);
                        delete ori[supplierId][poId];
//console.log('PO:'+poId+' has been removed');                        
                    }
                }
            }
        }
    }
    var checkDelivery = function() {
        var request = $.ajax({
            url: "<?php echo $deliveryUrl; ?>",
            type: "POST",
            dataType: "json"
        });
        request.done(function(data) 
        {
            today = data.today;
            if (typeof(store) != "undefined" && store !== null) {
//                console.log('Global variable:' + store);
            }
            if (store == null) {
                store = {'early': {}, 'today': {}}
            }
            // See difference, mark them
            whatsNew(store.early, data.early, 'col-early');
            whatsNew(store.today, data.today, 'col-today');
            if (!isSimilar(store.today, data.today) || !isSimilar(store.early, data.early)) {
                console.log('store beda sama data. Ada assignment yang lepas');
                console.log(store);
                console.log(data);
            }
            if (!isSimilar(data.today, store.today) || !isSimilar(data.early, store.early)) {
                console.log('data beda sama store. Ada yang belum dihapus');
                console.log(store);
                console.log(data);
            }
        });
        request.fail(function(jqXHR, textStatus) {
            console.log("Request failed: " + textStatus);
        });
    }
    var isSimilar = function(ori, next) {
        for (var supplierId in next) {
            if (!isset(ori[supplierId])) {
                console.log('supplierId' + supplierId + ' doesnt exist in ori');
                return false;
            }
            else {
                for (var poId in next[supplierId]) {
                    if (!isset(ori[supplierId][poId])) {
                        console.log('poId ' + poId + ' doesnt exist in ori');
                        return false;
                    }
                    else {
                        // Check if anything changed
                        var po = next[supplierId][poId];
                        var origPO = ori[supplierId][poId];
                        for (var model in po) {
                            for (var field in po[model]) {
                                if (origPO[model][field] != po[model][field]) {
                                    console.log(model + '-' + field + ' does not exist in ori');
                                    return false;
                                }
                            }
                        }
                    }
                }
            }
        }
        return true;
    }
    checkDelivery();
    setInterval(function() {
        checkDelivery();
    }, 10000);        