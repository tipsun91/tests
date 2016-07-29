<ul class="list-group">
<?php foreach ($content as $key => $value): ?>
    <?php $entity = $value['entity']; ?>
    <li class="list-group-item">
        <span class="date"><?php echo $entity->getDate()->format(\DateTime::RFC850); ?></span>
        <?php if (5 > $entity->getLevel()): ?>
            ( <a href="/comment/<?php echo ((int) $entity->getIdi()); ?>/answer">Отв.</a> |
            <a href="/comment/<?php echo ((int) $entity->getIdi()); ?>/edit">Ред.</a> |
            <a href="/comment/<?php echo ((int) $entity->getIdi()); ?>/delete">Уд.</a> )
        <?php endif; ?>
        <br/>
        <span class="text"><?php echo htmlspecialchars($entity->getText(), ENT_NOQUOTES); ?></span><br/>
    </li>
    <?php if (isset($value['children']) && is_array($value['children'])): ?>
    <li class="list-group-item">
        <?php $content = $value['children']; ?>
        <?php include(__FILE__); ?>
    </li>
    <?php endif; ?>
<?php endforeach; ?>
</ul>