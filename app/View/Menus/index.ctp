<div class="panel">
    <div class="panel-heading">
        <div class="ibox-tools">
            <a class="btn btn-success btn-xs" id="new-parent">New Menu</a>
        </div>
    </div>
    <div class="panel-body">
        <script type="text/javascript">
            var Menus =
                    {
                        Cache: {},
                        _generateCache: function (data) {
                            for (var iloop in data)
                            {
                                for (var jloop in data[iloop]) {
                                    if (data[iloop].hasOwnProperty([jloop]))
                                    {
                                        if (jloop == 'children')
                                        {
                                            for (var kloop in data[iloop][jloop])
                                            {
                                                Menus.Cache[ data[iloop][jloop][kloop]['Menu']['id'] ] = data[iloop][jloop][kloop]['Menu'];
                                                Menus._generateCache(data[iloop][jloop]);
                                            }
                                        }
                                        else if (jloop == 'Menu')
                                        {
                                            Menus.Cache[data[iloop][jloop]['id']] = data[iloop][jloop];
                                        }
                                    }
                                }
                            }
                        },
                        init: function () {
                            var data = <?php echo json_encode($menus); ?>;
                            Menus._generateCache(data);
                            delete data;
                        },
                        save: function () {
                            var url = '<?php echo $this->webroot; ?>menus/add';
                            if (parseInt($('form#fmMenu').find('input[name="menu_id"]').val()) > 0) {
                                url = '<?php echo $this->webroot; ?>menus/update';
                            }
                            var data = $('form#fmMenu').serialize();
                            $.post(url, data, function (response) {
                                if (response.Result == "OK")
                                {
                                    document.location.replace('<?php echo $this->webroot; ?>menus');
                                } else {
                                    alert(response.Message);
                                }
                            }, 'json');
                        },
                        remove: function (_key) {
                            var url = '<?php echo $this->webroot; ?>menus/remove';
                            $.post(url, {menu_id: _key}, function (response) {
                                if (response.Result == "OK")
                                {
                                    document.location.replace('<?php echo $this->webroot; ?>menus');
                                } else {
                                    alert(response.Message);
                                }
                            }, 'json');
                        },
                        reorder: function (_data) {
                            var url = '<?php echo $this->webroot; ?>menus/reorder';
                            $.post(url, _data, function (response) {
                                if (response.Result != "OK")
                                {
                                    alert(response.Message);
                                }
                            }, 'json');
                        }
                    }
            $(document).ready(function () {
                var TableMenu = $('tbody#table-sortable');
                Menus.init();
                $('form#fmMenu').submit(function () {
                    if ($(this).validationEngine('validate'))
                    {
                        Menus.save();
                    }
                    return false;
                });
                $('table#tree-menu').treegrid({
                    initialState: 'expanded'
                });
                var menuDlg = $('div#menu-dialog').dialog({
                    modal: true,
                    autoOpen: false,
                    width: '50%',
                    buttons: {
                        "Simpan": function () {
                            $('form#fmMenu').submit();
                        },
                        "Batal": function () {
                            $(this).dialog('close');
                        }
                    }
                });
                $('form#fmMenu').validationEngine('attach', {promptPosition: "bottomLeft", scroll: false});
                $('a#new-parent').click(function () {
                    menuDlg.dialog('open');
                });
                //icon onKeyUp
                $('form#fmMenu').find('input[name="icon"]').keyup(function (ev) {
                    $('i#icon-preview').attr('class', $(this).val());
                });
                //btn-edit onClick
                $('a.btn-edit').click(function () {
                    var _key = $(this).attr('data-key');
                    var data = Menus.Cache[_key];
                    $('form#fmMenu').find('input[name="menu_id"]').val(_key);
                    $('form#fmMenu').find('input[name="label"]').val(data.label);
                    $('form#fmMenu').find('input[name="controller"]').val(data.controller);
                    $('form#fmMenu').find('input[name="action"]').val(data.action);
                    $('form#fmMenu').find('input[name="enabled"]').val(data.action);
                    $('form#fmMenu').find('input[name="icon"]').val(data.icon);
                    if (!data.parent_id) {
                        $('form#fmMenu').find('select[name="parent_id"]').val(0);
                        $('form#fmMenu').find('select[name="parent_id"]').hide();
                    }
                    else {
                        $('form#fmMenu').find('select[name="parent_id"]').show();
                        $('form#fmMenu').find('select[name="parent_id"]').val(data.parent_id);
                    }
                    menuDlg.dialog('option', 'title', 'Edit Menu ' + data.name);
                    menuDlg.dialog('open');
                });
                //btn-remove onClick
                $('a.btn-remove').click(function () {
                    if (confirm('Warning \n Seluruh child menu yang ada didalam nya akan ikut terhapus. \n Anda yakin?'))
                    {
                        var _key = $(this).attr('data-key');
                        if ($.isNumeric(_key))
                            Menus.remove(_key);
                    }
                });
                //add-child
                $('a.btn-child').click(function ()
                {
                    var _key = $(this).attr('data-key');
                    var data = Menus.Cache[_key];
                    $('form#fmMenu').find('select[name="parent_id"]').val(data.id);
                    menuDlg.dialog('option', 'title', 'Edit Menu ' + data.label);
                    menuDlg.dialog('open');
                });
                //sortable
                TableMenu.sortable({
                    cursor: "move",
                    update: function (evt, ui) {
                        var _parent_id = $(ui.item[0]).attr('data-parent');
                        if (parseInt($(ui.item[0].nextSibling).attr('data-parent')) == _parent_id || parseInt($(ui.item[0].nextSibling).attr('data-parent')) == _parent_id)
                        {
                            var data = {key: [], order: []};
                            $('tr.treegrid-parent-' + _parent_id).each(function (i, item) {
                                data.key.push($(item).attr('data-key'));
                                data.order.push(i);
                            });
                            Menus.reorder(data);
                        }
                        else
                        {
                            TableMenu.sortable('cancel');
                        }
                    }
                });
            });
        </script>
        <!-- deep level 2 -->
        <table id="tree-menu" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Menu</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody id="table-sortable">
                <?php foreach ($menus as $menu): ?>
                    <tr class="treegrid-<?php echo $menu['Menu']['id']; ?>" data-key="<?php echo $menu['Menu']['id']; ?>">
                        <td><i class="<?php echo $menu['Menu']['icon']; ?>"></i>&nbsp;<?php echo $menu['Menu']['label']; ?></td>
                        <td class="text-right">
                            <div class="text-right">
                                <a class="btn btn-xs btn-default btn-child" data-key="<?php echo $menu['Menu']['id']; ?>">Add Child</a>
                                <a class="btn btn-xs btn-default btn-edit" data-key="<?php echo $menu['Menu']['id']; ?>">Edit</a>
                                <a class="btn btn-xs btn-default btn-remove" data-key="<?php echo $menu['Menu']['id']; ?>">Remove</a>
                                <?php if (!empty($menu['Menu']['controller'])): ?>
                                    <a target="_blank" class="btn btn-xs btn-default" href="<?php echo $menu['Menu']['controller'] . '/' . $menu['Menu']['action']; ?>">open link</a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php if (count($menu['children']) > 0): ?>
                        <?php foreach ($menu['children'] as $child): ?>
                            <tr class="treegrid-<?php echo $child['Menu']['id']; ?> treegrid-parent-<?php echo $menu['Menu']['id']; ?>" data-key="<?php echo $child['Menu']['id']; ?>" data-parent="<?php echo $menu['Menu']['id']; ?>">
                                <td><i class="<?php echo $child['Menu']['icon']; ?>"></i>&nbsp;<?php echo $child['Menu']['label']; ?></td>
                                <td class="text-right">
                                    <div class="text-right">
                                        <a class="btn btn-xs btn-default btn-child" data-key="<?php echo $child['Menu']['id']; ?>">Add Child</a>
                                        <a class="btn btn-xs btn-default btn-edit" data-key="<?php echo $child['Menu']['id']; ?>">Edit</a>
                                        <a class="btn btn-xs btn-default btn-remove" data-key="<?php echo $child['Menu']['id']; ?>">Remove</a>
                                        <?php if (!empty($child['Menu']['controller'])): ?>
                                            <a target="_blank" class="btn btn-xs btn-default" href="<?php echo $child['Menu']['controller'] . '/' . $child['Menu']['action']; ?>">open link</a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php if (count($child['children']) > 0): ?>
                                <?php foreach ($child['children'] as $ch): ?>
                                    <tr class="treegrid-<?php echo $ch['Menu']['id']; ?> treegrid-parent-<?php echo $child['Menu']['id']; ?>" data-key="<?php echo $ch['Menu']['id']; ?>" data-parent="<?php echo $child['Menu']['id']; ?>">
                                        <td><i class="<?php echo $ch['Menu']['icon']; ?>"></i>&nbsp;<?php echo $ch['Menu']['label']; ?></td>
                                        <td class="text-right">
                                            <div class="text-right">
                                                <a class="btn btn-xs btn-default btn-edit" data-key="<?php echo $ch['Menu']['id']; ?>">Edit</a>
                                                <a class="btn btn-xs btn-default btn-remove" data-key="<?php echo $ch['Menu']['id']; ?>">Remove</a>
                                                <?php if (!empty($ch['Menu']['controller'])): ?>
                                                    <a target="_blank" class="btn btn-xs btn-default" href="<?php echo $ch['Menu']['controller'] . '/' . $ch['Menu']['action']; ?>">open link</a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div role="dialog" id="menu-dialog" style="display:none;" title="New Menu">
            <h3>New Menu</h3>
            <form id="fmMenu" method="POST">
                <input type="hidden" name="menu_id">
                <p>
                    <input placeholder="Label" type="text" name="label" class="controls validate[required]" style="width:100%;">
                </p>
                <p>
                    <select placeholder="Parent Menu" name="parent_id" style="width:100%;">
                        <option value="0">--No Parent--</option>
                        <?php foreach ($menus as $menu): ?>
                            <option value="<?php echo $menu['Menu']['id']; ?>"><?php echo $menu['Menu']['label']; ?></option>
                            <?php if (count($menu['children']) > 0): ?>
                                <?php foreach ($menu['children'] as $child): ?>
                                    <option value="<?php echo $child['Menu']['id']; ?>"><?php echo $child['Menu']['label']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </p>
                <p>
                    <input placeholder="Controller" type="text" name="controller" class="controls" style="width:100%;">
                </p>
                <p>
                    <input placeholder="Action" type="text" name="action" class="controls" style="width:100%;">
                </p>
                <p>
                <p style="font-size:12px;font-style:italic;">icon preview : <i style="font-size:18px;" id="icon-preview"></i></p>
                <input placeholder="Icon Class" type="text" name="icon" class="controls" style="width:100%;">
                <input type="checkbox" name="enabled" class="controls" style="width:100%;">enabled
                </p>
            </form>
        </div>
    </div>
</div>