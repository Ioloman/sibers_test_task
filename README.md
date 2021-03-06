Комментарии по запуску:

Самый простой способ запуска - через Docker.
Единственное что нужно - удалить лишний файл в папке /initdb. create_tables_admin.sql при первом запуске контейнера создаст таблицы и 2 админов. create_tables_many.sql в дополнение к этому создаст 300 сгенерированных пользователей. Нужно выбрать один: create_tables_admin.sql без пользователей, create_tables_many.sql с пользователями, а другой удалить. (Так как дата рождения сгенерирована случайно, а для даты рождения установлено ограничение на клиенте - возраст 10 лет, то при изменении существующих записей может появляться предупреждение и для сохранение потребуется изменить дату рождения на более раннюю)

Далее нужно прописать `docker-compose up -d` и сайт должен быть доступен на http://localhost.

Все параметры для подключения к БД находятся в файле .env и специально оставлены в проекте.

Данные админов:
1. admin admin1234
2. admin2 admin1234

Были использованы следующие дополнительные технологии:
- PDO - для соединения с БД
- jQuery + AJAX - для создания анимаций и выполнения сортировки, добавления и удаления без перезагрузки страницы
- Bootstrap 5  - для верстки
- Docker - для создания среды разработки и запуска


Описание работы:
Для начала нужно войти под записью администратора, без этого контент недоступен. Форма входа сначала проверяется скриптом, если все в порядке отправляется на сервер. Если данные не подходят выводится форма с сообщением. Если вход произошел успешно, то идет редирект на главную. 

Главная страница выводит всех пользователей постранично. Можно выбрать в дропдауне сколько записей показывать на странице. Также можно изменить сортировку кликом по визуально отмеченным заголовкам таблицы с пользователями.

На главной странице можно создать пользователя, нажав на кнопку "+". Появится модальное окно с формой. Поля формы сначала валидируются скриптом, если что то не так выводится сообщение. Если все нормально, данные отправляются на сервер с помощью AJAX и, если все успешно, запись вставляется в список без перезагрузки страницы.

Также записи можно удалить прямо с главной страницы, щелкнув по кнопке с соответствующей иконкой. Это тоже происходит без перезагрузки. Рядом есть кнопка - ссылка на страницу с подробной информацией о пользователе. Там можно изменить данные и удалить запись.