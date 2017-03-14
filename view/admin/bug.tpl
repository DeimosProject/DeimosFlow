{foreach $list as $file}
    {assign d $file->isDir()}
    <div>
        <a class="{if $d}dir{else}file{/if}" href="{$file->getBasename()}{if $d}/{/if}">{$file->getBasename()}</a>
        {if ! $d} - {$helper->str()->fileSize($file->getSize())} {/if}
    </div>
{/foreach}