<!DOCTYPE html>
<html>
    <head>
        <title>{block 'title' prepend}{$title|default:'CMS'} {/block}</title>
        <script src="/js/helper-{$id|default:5}.js"></script>
        <script src='/js/helper-{$id}.js'></script>
        <script>
            'use strict';

            var storage = {$storage|json_encode};
        </script>
    </head>
    {assign classBody 'mySelf'}
    <body class="{$classBody|default:"classBody"}">

        <h1>{block "hello" prepend}Hello {/block}</h1>

        {$content}

        <h2>{'hello'}</h2>
        <h2>{"hello"|substr:0:3}</h2>

        {assign length 13}

        {'Flow Template!'|substr:0:-2}

        {*{$array.hello|default:'My Self'}*}
        <h3>{$hello|default:'test'}</h3>

        <?php foreach ($storage as $item): ?>
            <?=$item;?>
        <?php endforeach; ?>

        {php}if (empty($storage)) $storage = [1,2,3,4,5];{/php}

        {$storage|var_dump}<br/>
        {$storage|json.encode}<br/>
        <font color="green">{$storage|count}</font><br/>

        {foreach:foo $storage as $item}
            {$item}
            {foreach $storage as $item}{/foreach}
            {foreachelse}
            Нет данных
        {/foreach}

        {foreach name=test from=$storage item=item}
            {$this->foreach->test|var_dump}
        {foreachelse}
            Нет данных
        {/foreach}

        <p>total: {$this->foreach->foo->total}</p>

        {include "ux/content"}
        {include file="ux/content"}
        {partial "ux/content.tpl"}
        {literal}
            {partial "ux/content.tpl"}
        {/literal}

    </body>
</html>