<ul class="list-group">
<?php if (isset($content) && Is_array($content)): ?>
<?php foreach ($content as $key => $value): ?>
    <?php $entity = $value['entity']; ?>
    <?php $idi = (int) $entity->getIdi(); ?>
    <li class="list-group-item">
        <span class="date"><?php echo $entity->getDate()->format(\DateTime::RFC850); ?></span>
        (
        <?php if (5 > $entity->getLevel()): ?>
            <a href="/comment/<?php echo $idi; ?>/answer">Отв.</a> |
        <?php endif; ?>
        <a href="/comment/<?php echo $idi; ?>/edit">Ред.</a> |
        <a href="/comment/<?php echo $idi; ?>/delete">Уд.</a> )
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
<?php else: ?>
    <li>Пусто</li>
<?php endif; ?>
</ul>