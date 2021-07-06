<div class="float-md-start" id="showing">Showing
    <?php
    $offset = $show * ($page - 1);
    echo strval(1 + $offset) . " to " . strval(($show + $offset) > $total ? $total : ($show + $offset)) . " of <total>$total</total> entries";
    ?>
</div>