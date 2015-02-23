<?php
include_once("includes/header.php");
?>
<div class="container">
  <div class="no-gutter row">
<?php include_once("chesstest/test.php"); ?>
  </div>
</div>


<?php
include_once("includes/footer.php");
?>
<script type="text/javascript">
$(function() {
  $("#chessTableStyling").height($("#chessTableStyling").width());
});
$('body').scrollspy({ target: '.customHeading' })
</script>