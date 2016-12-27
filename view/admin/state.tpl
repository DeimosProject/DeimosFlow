<!DOCTYPE>
<html>
    <head>
        {$object|var_dump}
        {$object->hello|var_dump:my:name}
        <?php echo $title; ?>
        {*<title>{$title|_}</title>*}
        {assign names ["Bob", "Max"]}
        <title>{$title|default:'Not title'}</title>
        <script src="/js/helper-{$id|default:'5'}.js"></script>
        <script src='/js/helper-{$id}.js'></script>
        <script>
            'use strict';

            var storage = {$storage|json_encode};
        </script>
    </head>
    <body class="{$classBody}">

        {printBlock "hello" "Hello World"}<br/>

        {$content}

        <?php foreach ($storage as $item): ?>
            <?=$item;?>
        <?php endforeach; ?>

        {php}if (empty($storage)) $storage = [1,2,3,4,5];{/php}

        {$storage|var_dump}<br/>
        {$storage|json.encode}<br/>
        <font color="green">{$storage|count}</font><br/>

        {foreach:foo $storage as $item}
            {$this->foreach->foo|var_dump}
        {foreachelse}
            Нет данных
        {/foreach}

        <p>total: {$this->foreach->foo->total}</p>
        <p>memory usage: {$this->foreach->foo->memory}</p>

        {include "ux/content"}
        {partial "ux/content.txt"}

    </body>
</html>