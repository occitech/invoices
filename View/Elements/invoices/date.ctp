<div class="before"><?php
	echo ucfirst(strftime(__d('invoices', '%A, %B %d %Y'), strtotime($invoice['Invoice']['created'])));
?></div>