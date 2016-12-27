{extends 'admin/test'}{*continue*}

{block 'title' append} - Continue{/block}
{block 'content'}
    {assign storage [1, 2, 3, 4, 5]}
    {foreach:state $storage as $item}
        {if $this->foreach->state->first}
            {continue}
        {/if}

        {$this->foreach->state->key}
    {/foreach}
{/block}