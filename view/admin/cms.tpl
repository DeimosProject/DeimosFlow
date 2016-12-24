<!DOCTYPE>
<html>
    <head>
        <?php echo $title; ?>
        {*<title>{$title|_}</title>*}
        <title>{$title|default:'Not title'}</title>
        <script src="/js/helper-{$id}.js"></script>
        <script src='/js/helper-{$id}.js'></script>
    </head>
    <body class="{$classBody}">

        {$content}

        <?php foreach ($storage as $item) : ?>
            <?=$item;?>
        <?php endforeach; ?>

        {foreach from=storage item=item key=key}
            {$key} = {$item}<br/>
        {/foreach}

        {foreach from=["1","2",3,4,5,6,7,8] item=item key=key}
            {$key} = {$item}<br/>
        {/foreach}

        {foreach from=storage item=item key=key}{$key}{$item}{/foreach}

        {if ($a > $b)}
            {storage}
        {elseif ($b === $a)}
            {hello}
        {else}
            {wheel}
        {/if}

        {foreach $storage as $key => $item}
            {$storage}
        {/foreach}

        {include file="content"}

    </body>
</html>