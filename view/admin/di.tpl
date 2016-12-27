{assign storage [1, 2, 3, 4]}

{$storage|var_dump}
<p>{$storage|count}</p> {* 4 *}
<p>{$storage|length}</p> {* mt_rand *}

{assign string "Hello World"}

{$string|var_dump}
<p>{$string|strlen}</p> {* 11 *}
<p>{$string|length}</p> {* mt_rand *}