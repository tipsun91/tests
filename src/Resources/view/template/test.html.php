<ul class="list-group">
<?php foreach ($content as $key => $value): ?>
    <li class="list-group-item">
        <?php if (is_array($value)): ?>
            <?php $content = $value; ?>
            <?php include(__FILE__); ?>
        <?php else: ?>
            <span class="key"><?php echo htmlspecialchars($key, ENT_NOQUOTES); ?></span>:
            <span class="value"><?php echo htmlspecialchars($value, ENT_NOQUOTES); ?></span>
        <?php endif; ?>
    </li>
<?php endforeach; ?>
</ul>
