<?php
/****************

Company: Colourz Technologies 
version: Chat 1.0
description: chatting window

--------------------

created by: Senthil Kumar P
created on:  
completed on:
comments:
------------------
tested by: Danielpaulrajsing
tested on:
test comment:
----------------------------
updated by: Danielpaulrajsing
updated on:
update completed on:

****************/
?>

<?php if($page=="chat") { ?>
<div class="chatpanel" align="right" id="chatpanel"></div>
<img src="images/close.png" style="display:none" /> <img src="images/minimize.png" style="display:none" />
<img src="smileys/mini_smile.gif" style="display:none" />
<?php } ?>
</body>
</html>
<?php
mysql_close($con);
?>