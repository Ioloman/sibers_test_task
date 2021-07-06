<!-- 
a div that says info about pages and stuff
like "Showing 1 to 10 of 200 entries"
 -->
<div class="float-md-start" id="showing">Showing
    <?php
    $offset = $show * ($page - 1);
    echo strval(1 + $offset) . " to " . strval(($show + $offset) > $total ? $total : ($show + $offset)) . " of <total>$total</total> entries";
    ?>
</div>