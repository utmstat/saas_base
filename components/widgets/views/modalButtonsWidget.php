<?php


?>

<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
<?php if ($isUpdate): ?>
    <button type="submit" class="btn btn-primary">Сохранить</button>
<?php else: ?>
    <button type="submit" class="btn btn-success">Добавить</button>
<?php endif; ?>
