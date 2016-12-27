<!DOCTYPE html>
<html>
    <head>
        <title><?php echo (empty($title)?$this->configure->di()->escape('Not title'):$this->configure->di()->escape($title)); ?></title>
        <script src="/js/helper-<?php echo (empty($id)?$this->configure->di()->escape(5):$this->configure->di()->escape($id)); ?>.js"></script>
        <script src='/js/helper-{$id}.js'></script>
        <script>
            'use strict';

            var storage = <?php echo $this->configure->di()->call('json_encode', array (  0 => $storage,)); ?>;
        </script>
    </head>
    <?php $classBody = 'mySelf'; ?>
    <body class="<?php echo (empty($classBody)?$this->configure->di()->escape("classBody"):$this->configure->di()->escape($classBody)); ?>">

        <?php $this->configure->block()->start('hello'); ?><h1>my block</h1><?php $this->configure->block()->end(); ?>

        <?php echo $this->configure->block()->display('hello', 'Hello World'); ?><br/>

        <?php echo $this->configure->di()->call('escape', array (  0 => $content,)); ?>

        <h2><?php echo $this->configure->di()->call('escape', array (  0 => 'hello',)); ?></h2>
        <h2><?php echo $this->configure->di()->call('substr', array (  0 => 'hello',  1 => '0',  2 => '3',)); ?></h2>

        <?php echo (empty($array['0'])?$this->configure->di()->escape('world'):$this->configure->di()->escape($array['0'])); ?>
        <h3><?php echo (empty($hello)?$this->configure->di()->escape('test'):$this->configure->di()->escape($hello)); ?></h3>

        <!--  foreach ($storage as $item):  -->
            <!-- $item; -->
        <!--  endforeach;  -->

        <!-- if (empty($storage)) $storage = [1,2,3,4,5]; -->

        <?php echo $this->configure->di()->call('var_dump', array (  0 => $storage,)); ?><br/>
        <?php echo $this->configure->di()->call('json.encode', array (  0 => $storage,)); ?><br/>
        <font color="green"><?php echo $this->configure->di()->call('count', array (  0 => $storage,)); ?></font><br/>

        <?php if (!empty($storage)): ?> <?php $this->foreach->register('foo', $storage); ?><?php foreach ($storage as $key51183003058358540527974300479489927114 => $item): $this->foreach->foo($key51183003058358540527974300479489927114); ?>
            <?php echo $this->configure->di()->call('escape', array (  0 => $item,)); ?>
            <?php if (!empty($storage)): ?><?php foreach ($storage as $key7935850299604754126490036512678129753 => $item):  ?><?php endforeach;  endif; ?>
            <?php endforeach;  else: ?>
            Нет данных
        <?php endif; ?>

        <?php if (!empty($storage)): ?> <?php $this->foreach->register('test', $storage); ?><?php foreach ($storage as $key5709433120764117646584460542234126500 => $item): $this->foreach->test($key5709433120764117646584460542234126500); ?>
            <?php echo $this->configure->di()->call('var_dump', array (  0 => $this->foreach->test,)); ?>
        <?php endforeach;  else: ?>
            Нет данных
        <?php endif; ?>

        <p>total: <?php echo $this->configure->di()->call('escape', array (  0 => $this->foreach->foo->total,)); ?></p>

        <?php echo $this->configure->requireFile("ux/content");?>
        <?php echo $this->configure->requireFile("ux/content");?>
        <?php echo $this->configure->getFile("ux/content.tpl");?>
        <!--  echo '
            {partial "ux/content.tpl"}
        ';  -->

    </body>
</html>