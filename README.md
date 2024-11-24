# Шаблон saas-сервиса от datamonster.ru

## От разработчиков

Привет, мы команда https://datamonster.ru/, более 5 лет занимаемся разработкой b2b saas-проектов и построению бизнесов
на них.

Наш телеграм - [https://t.me/serial_saas](https://t.me/+fmWfZscPa3s3NGIy)

Наши проекты

- https://utmstat.com/
- https://apimonster.ru/
- https://cpamonster.io/
- https://lmsly.io/
- https://osintmonster.com/

У нас уже сложилось четкое понимание как нужно разрабатывать b2b saas-сервисы на уровне кода и выработался типовой
шаблон проекта, благодаря которому мы можем запустить новый сервис и довести до первого платежа буквально за 2-4 недели.

Этим шаблоном мы делимся в рамках данного репозитория. Наш вклад в opensource.

## Для каких задач подойдет шаблон

1. Saas-сервис
2. Админка
3. Api
4. Cron-задания

## Какая проблема решается

Основной риск в начале любого проекта - не угадать со стеком и архитектурой, завязнуть в разработке рутинных задач.

Если нужно запустить быстро и недорого - данный риск очень критичен и хочется его избежать.

Поэтому вы можете воспользоваться нашим шаблоном проекта, который точно работает и проверен на 5+ проектах.

Данный шаблон проекта позволяет за 1-2 часа развернуть заготовку проекта, где уже решены типовые задачи saas:

- Базовая структура БД
- Рабочий логин/регистрация
- Базовые модули - api, админка, поддержка, ошибки
- Готовый биллинг - оплата картой, по счету, документация.
- Настроенные unit-тесты

## Для кого

### Вы хотите быстро запустить saas-сервис, но не сильно разбираетесь в разработке

Мы вам заменим дорогого архитектора проекта и заложим грамотную архитектуру, устойчивую к плохим решениям в конкретных
модулях.

Вы себя застрахуете от очень дорогой ошибки неправильного выбора стека и архитектуры, влекущую переписку проекта с нуля,
когда становится понятно что поддерживать далее невозможно.

### Вы изучаете разработку и хотите рабочий пример таких проектов

Хотите запустить свой pet-проект, но пока не понимаете как выглядит архитектура целиком - берите за основу наш проект и
постепенно разбирайтесь. Все проекты выглядит +/- также.

Потом постепенно поймете почему все так.

## Стек

Все проекты мы пишем на php/yii2, js/jquery, twitter boostrap, благодаря чему пропускаем очень много ненужной разработки
рутинных задач.

Возможно вам покажется что стек "старый", но с точки зрения бизнеса, стек надо выбирать по следующим критериям:

1. стек подходит под задачу. У нас веб-разработка и данный стек идеален.
2. должно быть много программистов на рынке, чтобы не было проблем с кадрами
3. они должны стоить разумных денег
4. должно быть много документации и готовых модулей под популярные задачи для сокращения время разработки.

Делать проекты на стеке, который знают 10 программистов по стране с зарплатой 500к+ - плохая идея.

Под данные критерии как раз и подходит php/yii2, js/jquery, twitter boostrap.

Технически там все тоже очень хорошо, детали ниже.

## Возможности

### Общий принцип наших проектов

Все проекты работают по паттерну ООП, MVC или даже MVCW (model-view-controller-widget) на базе возможностей Yii2.

Проекты собираются фактически готовых кубиков, где минимальная единица - это виджет, отвечающий кусочек логики на
странице (таблица, график).

Стараемся без "инноваций", чтобы было максимально стандартно и понятно широкому кругу разработчиков.

### Что реализовано

1. Лендинг и личный кабинет
2. Логин/Регистрация
3. Биллинг - оплата картой, выставление счета, зачисление на баланс закрывающие.
4. Мониторинг
5. Юнит-тесты
6. Кеширование - стандартное и статическое
7. Работа с изображениями
8. Работа с SEO - генерация всех тегов
8. Работа с sitemap.xml
7. Хелперы по работе с текстом, массивами, json, cookie, html
8. Виджеты меню хедера/футера/кнопок crud/уведомлений.
9. Возможность встроить модули на Go/Python там они действительно к месту.

**Важно:** модули в данном шаблоне могут быть не все, так как шаблон немного отстает от реальной разработки. Запросите в
поддержке если что-то нужно.

## FAQ

### Я слышал PHP плохой язык, нет?

Так говорят те, кто писал на нем 10-15 лет назад во времена php4 или читал гневные статьи, не имея опыта разработки.
Тогда он был действительно не очень - что-то на уровне современных go/nodejs.

Начиная с версии 5 - все стало очень хорошо, а сейчас уже версия 8.

На данный момент php8 в рамках фреймворков yii2/laravel пожалуй лучший язык для веб-разработки, если важен баланс
качества кода/скорости запуска/кадров на рынке и бюджета.

Сейчас у php нет никаких проблем ни с кодом ни с производительностью.

На голом php никто сейчас ничего не пишет.

### Почему JQuery, в не Angular/React?

Если не ставить себе цели "максимум спецэффектов на сайте", то большинство B2B проектов это простой интерфейс - таблички
и графики без сложной логики.

Тут не надо рендерить интерфейсы на js - быстрее удобнее на php. Под графики есть готовые библиотеки - их точно делать с
нуля не надо.

В итоге остается несложная логика под какие-нибуть локальные виджеты типа сортировки таблицы, где JQuery более чем
достаточно.

Но если у вас оправданная сложная логика интерфейсов, то конечно имеет смысл подключать более подходящие фреймворки.

### Почему основной язык не GO?

Go изначально придумали для высоконагруженных микросервисов(микропроектов), например быстро обрабатывать миллионы запросов
в мессенджерах, где нагрузка тысячи RPS.

Платой за это является более низкоуровневый код и значительное увеличение трудоемкости разработки.

По сравнению с PHP, одни и те же задачи на GO сложнее делать в 3-10 раз.

Почему все начали переписывать проекты на нем - для нас вопрос.

На GO имеет смысл писать высоконагруженные модули, например кликстрим и то только в случае если уперлись в потолок
оптимизации кода на php (скорее всего до этого момента не дойдете), но точно не надо делать на нем лендинги и личные
кабинеты.

Выбирать Go в качестве основного языка b2b-сервиса крайне не рекомендуем.

На Go можно писать (сжигать бюджеты), если ваша выручка в год или финансирование более 1 млрд рублей.

Если у вас есть команда на Go - делайте на Go, если команды нет - php/yii2.

### Почему основной язык не Javascript/NodeJS?

Все тоже самое что и c Go.

Если у вас есть команда на Js - делайте на Js, если команды нет - php/yii2.

### Почему не Python?

Основной хайп вокруг Python связан с ИИ и аналитикой. Это задачи так хорошо решаются, но не веб-разработка.

Для веб-разработки используется фреймворк django и это довольно редкий инструмент, могут быть проблемы с кадрами.

Если у вас есть команда на django - делайте на django, если команды нет - php/yii2.

### Почему не Ruby on Rails?

Устаревшая забытая технология по крайней мере в СНГ. Точно нет.

## Поддержка и консультации

### Бесплатно

Задавайте вопросы здесь - https://github.com/utmstat/saas_base/discussions

Ответим/поправим что-то по мере возможности.

### Платно

Можем проконсультировать как делать ваш проект или добавить недостающие модули общего назначения.

Оставьте заявку на сайте - https://datamonster.ru/

## Лицензия

Используйте код как хотите, но было классно рассказать о данном репозитории на вашу аудиторию - рассылка, блог, телеграм
канал.

Мы вам сэкономили много времени и денег.

## Контакты

Подписывайтесь на нас в телеграм - [https://t.me/serial_saas](https://t.me/+fmWfZscPa3s3NGIy)

Отзывы и предложения пишите на alex@utmstat.com

## Установка

1. Клонируйте проект в каталог saasbase
2. Добавьте в файл /etc/hosts домены saasbase из файла config/nginx/hosts
2. Настройте nginx на домен saasbase.ru, пример конфига config/nginx/saasbase_mac.conf
3. Создайте БД saasbase и пропишите доступы тут config/db.php
4. Запустите файл init.sh
5. Откройте в бразуере http://saasbase.ru
6. Все