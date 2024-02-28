<?php

/*

Dostępne funkcje do aktywacji bibliotek. 
Każda przyjmuje parametr "true" przy aktywacji biblioteki, 
nieważne w którym miejscu w kodzie zostana dodana. 
Preferowane miejsce dla tej funkcji jest "block.php" w konkretnym bloku

*/

et_lib_accordion(false);
if (!is_admin()) {
	et_lib_aos(false);
}
et_lib_choices(false);
et_lib_halka(false);
et_lib_normalize(false);
et_lib_splide(false);
et_lib_typed(false);
et_lib_reset(false);
et_lib_walkway(false);
