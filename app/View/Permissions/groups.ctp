<div class="row-fluid">
    <div class="span4">
        TAMPUNG
        <?php
        foreach ($controllers as $c) {
            ?>
            <ul>
                <li><a href="#"><?php echo $c['Ako']['alias']; ?> - <?php echo $c['Ako']['id']; ?></a></li>
                <li>
                    <ul>
                        <?php
                        foreach ($c['ChildAko'] as $ca) {
                            //$p = "php cake acl check Group." . $group_id . " " . $c['Ako']['alias'] . "/" . $ca['alias'];
                            ?>
                            <li>
                                <?php echo $ca['alias']; ?> - <?php echo $ca['id']; ?>
                            </li>
                        <?php }
                        ?>
                    </ul>
                </li>
            </ul>
            <?php
        }
        ?>
    </div>
    <div class = "span4">
        ACOS
        <pre>
            <?php print_r($controllers);
            ?>
        </pre>
    </div>
</div
