

Урок 8. Учимся собирать логи, дебажим приложение  
Благодаря xdebug была найдена причина невозможности вывода формы логина.  
В файле AbstractController надо было установить роль с правами доступа.  
$roles[] = 'some'; или $roles[] = 'admin';  

  
docker-compose up -d  
docker-compose down  
