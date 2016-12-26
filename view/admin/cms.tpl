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

            var storage = {$storage|json.encode};
        </script>
    </head>
    <body class="{$classBody}">

        {$content}

        <?php foreach ($storage as $item): ?>
            <?=$item;?>
        <?php endforeach; ?>

        {php}if (empty($storage)) $storage = [1,2,3,4,5];{/php}

        {$storage|var_dump}
        {$storage|json.encode}

        {foreach $storage as $key => $item}
            {$item}
        {foreachelse}
            Нет данных
        {/foreach}

        {include "ux/content"}
        {partial "ux/content.txt"}

    </body>
</html>