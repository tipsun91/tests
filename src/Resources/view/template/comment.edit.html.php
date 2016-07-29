<form action="<?php echo htmlspecialchars($action, ENT_QUOTES); ?>" method="post" xmlns="http://www.w3.org/1999/html">
    <label>Редактирование</label><br/>
    <textarea name="text"><?php echo htmlspecialchars($text, ENT_NOQUOTES); ?></textarea><br/>
    <input type="submit" name="button" value="Отправить" />
</form>