

Урок 6. Работа с БД  
  
docker-compose up -d  
docker-compose down  
  
Строка запроса добавления пользователя  
http://mysite.local/user/index/?user_info=Иван&birthday=05-05-1991  

— Создайте метод обновления пользователя новыми данными  
http://mysite.local/user/update/?id=2&name=Петр  

— Создайте метод удаления пользователя из базы. Учитывайте, что пользователя может не быть в базе  
http://mysite.local/user/delete/?id=2  