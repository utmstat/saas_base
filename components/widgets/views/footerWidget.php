<div class="container">
    <footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
            <div class="col-12 col-md">
                <?= Yii::$app->name ?>
                <small class="d-block mb-3 text-muted"><?= date('Y') ?></small>
            </div>
            <div class="col-6 col-md">

                <h5>Контакты</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="text-muted" href="#"><?= Yii::$app->params['ticketEmail'] ?></a></li>
                    <li><a class="text-muted"
                           href="tel:<?= Yii::$app->params['phones']['raw'] ?>"><?= Yii::$app->params['phones']['label'] ?></a>
                    </li>
                </ul>

            </div>
            <div class="col-6 col-md">
                <h5>О компании</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="text-muted" href="/docs/licence">Условия использования</a></li>
                    <li><a class="text-muted" href="/docs/privacy">Политика конфиденциальности</a></li>
                </ul>
            </div>
        </div>
    </footer>
</div>
