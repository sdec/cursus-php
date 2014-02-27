<!DOCTYPE html>
<html>
    <head>
        <?= $this->renderPartial('header') ?>
    </head>
    <body>
        <?= $this->renderPartial('navigation') ?>
        
        <div class="container">
            <?php $this->getContent(); ?>
            <?= $this->renderPartial('message') ?>
        </div>
        <?= $this->renderPartial('scripts') ?>
    </body>
</html>