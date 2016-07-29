<ul class="list-group">
    <li class="list-group-item">Дано</li>
    <?php foreach ($data as $subContent): ?>
        <li class="list-group-item">
            <?php foreach ($subContent as $value): ?>
                &nbsp;<?php echo htmlspecialchars($value, ENT_NOQUOTES) ?>&nbsp;
            <?php endforeach; ?>
        </li>
    <?php endforeach; ?>
</ul>

<ul class="list-group">
    <li class="list-group-item">Результат</li>
<?php foreach ($content as $subContent): ?>
    <li class="list-group-item">
        <?php foreach ($subContent as $value): ?>
        &nbsp;<?php echo htmlspecialchars($value, ENT_NOQUOTES) ?>&nbsp;
        <?php endforeach; ?>
    </li>
<?php endforeach; ?>
</ul>