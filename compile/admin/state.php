<!DOCTYPE>
<html>
    <head>
        <?php echo $this->configure->di()->call('var_dump', array (  0 => $object,)); ?>
        <?php echo $this->configure->di()->call('var_dumpmyname', array (  0 => $object->hello,)); ?>
        <!--  echo $title;  -->
        <?php $this->configure->setVariable('names', ["Bob", "Max"]); $names = $this->configure->getVariable('names'); ?>
        <title><?php echo $this->configure->di()->call('default'Not title'', array (  0 => $title,)); ?></title>
        <script src="/js/helper-<?php echo $this->configure->di()->call('default'5'', array (  0 => $id,)); ?>.js"></script>
        <script src='/js/helper-{$id}.js'></script>
        <script>
            'use strict';

            var storage = <?php echo $this->configure->di()->call('json_encode', array (  0 => $storage,)); ?>;
        </script>
    </head>
    <body class="<?php echo $this->configure->di()->call('escape', array (  0 => $classBody,)); ?>">

        <?php echo $this->configure->block()->display('hello', 'Hello World'); ?><br/>

        <?php echo $this->configure->di()->call('escape', array (  0 => $content,)); ?>

        <!--  foreach ($storage as $item):  -->
            <!-- $item; -->
        <!--  endforeach;  -->

        <!-- if (empty($storage)) $storage = [1,2,3,4,5]; -->

        <?php echo $this->configure->di()->call('var_dump', array (  0 => $storage,)); ?><br/>
        <?php echo $this->configure->di()->call('json.encode', array (  0 => $storage,)); ?><br/>
        <font color="green"><?php echo $this->configure->di()->call('count', array (  0 => $storage,)); ?></font><br/>

        <?php if (!empty($storage)): ?> <?php $this->foreach->register('foo', $storage); ?><?php foreach ($storage as $key23426301031093261631192001205447984346 => $item): $this->foreach->foo($key23426301031093261631192001205447984346); ?>
            <?php echo $this->configure->di()->call('var_dump', array (  0 => $this->foreach->foo,)); ?>
        <?php endforeach;  else: ?>
            Нет данных
        <?php endif; ?>

        <p>total: <?php echo $this->configure->di()->call('escape', array (  0 => $this->foreach->foo->total,)); ?></p>

        <?php echo $this->configure->requireFile("ux/content");?>
        <?php echo $this->configure->getFile("ux/content.tpl");?>

    </body>
</html>