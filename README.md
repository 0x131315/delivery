# delivery

###### В качестве справочной информации для выполнения задачи можно использовать следующие ресурсы:
* Установка AMP (apache, mysql, php) - не весь, только то, что потребуется для установки https://www.digitalocean.com/community/tutorials/linux-apache-mysql-php-lamp-ubuntu-16-04-ru.
* Справочник языка http://www.php.net/manual/ru/langref.php 
* COOKIES http://www.php.net/manual/ru/features.cookies.php
* Сессии http://www.php.net/manual/ru/features.sessions.php
* Работа с датой/временем http://www.php.net/manual/ru/class.datetime.php
* Работа с БД через PDO http://www.php.net/manual/ru/book.pdo.php
* Обработка строк http://www.php.net/manual/ru/ref.strings.php (и аналогия для многобайтовых строк http://www.php.net/manual/ru/ref.mbstring.php)
* Безопасность http://www.php.net/manual/ru/security.php
* PHP. The Right Way http://www.phptherightway.com
* Основы проектирования реляционных баз данных https://www.intuit.ru/studies/courses/1095/191/info
* Основы объектно-ориентированного программирования https://www.intuit.ru/studies/courses/71/71/info

## Проект Сервис курьерской доставки
Выполнять задачу на чистом PHP, без использования сторонних фреймворков. Для работы с базой данных использовать PDO.

Сервис позволяет оператору вручную вносить в базу данных заказы на доставку товаров, а также дает возможность распределять их по курьерам.<br>
Доступ к сервису можно получить только после авторизации.

В системе заведены несколько курьеров, у них есть расписание работы вида 
```
пн 9:00 - 15:00
вт 10:00 - 18:00
ср выходной
чт 14:00 - 20:00
пт выходной
сб выходной
вс выходной
```
Курьер считается занятым, если на него назначены заказы в статусе "Назначен курьеру".

Система может вычислить предположительное время освобождения курьера, получив все его заказы в статусе "Назначен курьеру" и прибавив значение поля "Предположительное время курьера в пути" к текущему времени.

Считаем, что курьер будет развозить заказы в порядке их добавления в систему.

### Операторский раздел
#### Форма создания заказа
Форма позволяет оператору создать новую заявку. Заявка содержит следующие поля:
* Статус (Новый, Назначен курьеру, Доставляется, Доставлен, Отменен)
* Описание доставляемых товаров
* Сумма заказа
* Адрес доставки
* Предположительное время курьера в пути (считаем, что оператор вычисляет его в какой-то внешней системе и вносит готовый результат)
* Ответственный курьер

При этом рядом с полем выбора курьера должна выводиться рекомендация, какого курьера выбрать, чтобы он смог быстрее всех выполнить заказ и при этом уложиться в свое рабочее время. Неактивных курьеров и курьеров, у которых закончился рабочий день, выводить не надо.

#### Список заказов
Выводится список заказов, отсортированных по дате. Для каждого заказа в статусе "Назначен курьеру" выводится предположительная дата доставки с учетом загрузки курьеров.

Список курьеров для упрощения задачи можно задать напрямую в БД.

Результат выполнения вместе с дампом БД нужно будет загрузить на гитхаб и предоставить ссылку.
