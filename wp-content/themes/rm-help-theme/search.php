<?php

include 'header.php';

while ( have_posts() ) : the_post();
	the_title();
	the_excerpt();

endwhile; // End of the loop.
?>
<?php

include 'footer.php';
