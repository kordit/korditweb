<form autocomplete="off" action="/" method="get">
  <label for="search">Szukaj</label>
  <input type="text" name="s" id="s" placeholder="Szukaj..." value="<?php the_search_query(); ?>" />
  <input type="hidden" name="post_type" value="post" />
  <input type="submit" id="searchsubmit" value="" />
</form>