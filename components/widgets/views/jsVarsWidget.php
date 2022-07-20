<?php

use app\components\helpers\AppHelper;
use app\models\User;

$user = User::getCurrentUser();

?>


<script type="text/javascript">
    let commonApiHost = "<?= AppHelper::getApiHost() ?>";
    let commonUserId = <?= $user ? $user->id : 0 ?>;
</script>
