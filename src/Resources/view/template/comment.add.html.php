<form action="<?php echo htmlspecialchars($action, ENT_QUOTES); ?>" method="post" xmlns="http://www.w3.org/1999/html">
    <label class="title"><?php echo (0 < $ide ? 'Ответ' : 'Комментарий'); ?></label>
    <input type="hidden" name="ide" value="<?php echo ((int) $ide); ?>" /><br/>
    <textarea name="text"></textarea><br/>
    <input type="submit" name="button" value="Отправить" />
</form>