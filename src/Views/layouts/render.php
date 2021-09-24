<!DOCTYPE html><html><head>
<?php

// display the meta
echo $meta ?? '';

// display the css
echo service('assets')->css()

?>	
</head><body>
<?php

// display the whole content
echo $render;

// display the js
echo service('assets')->js()

?>
</body></html>
