Документация REST API

https://{url}/http/authorization?type={registration || log || social || session || exit} - METHOD "POST" registration = { "login": "", // латиница и числа, не меньше 4 символов "email" "", // валидация почты "password": "" // не меньше 8 символов }

log = { "login": "", "password": "" }

session // данные из localStorage {login, session}

social // в доработке

exit // выход из учётной записи

https://{url}/http/user?type={personal_data || edit_passsword} - METHOD "POST" personal_data = { "login": "", "email": "", "telephone": "", "password": "" }, edit_passsword { "email": "", "code": "", "password": "" }

https://{url}/http/email?type={create_code} - METHOD "POST" create_code = { "email": "" }

https://{url}/http/user_info/ - METHOD "GET" // получение информации о пользователе, если он авторизован
https://{url}/http/user_info/{id} - METHOD "GET" // получение информации о пользователе

https://{url}/http/user_info/{ null || edit_avatar} - METHOD "POST" null (ничего не надо ставить) = {}

https://{url}/http/group/{id} -  METHOD "GET" // получение списка участников группы и уровень привелегий пользователя (1 - только просмотр, 2 - создание записей, 3 - создание событий из дат, 4 - полный доступ)
https://{url}/http/group - METHOD "POST" { "group_name": "" // есть проверка на название группы, пользователь не сможет присоединиться, если уже состоит }

https://{url}/http/event?{limit || offset || (любой из параметров, который есть у event)}={param} - METHOD "GET" // Данные будут получены только у авторизованных пользователей, точно также работает note, только в нем отсутсвует "time"

https://{url}/http/event/ - METHOD "POST" { "title": "", "description": "", "phone": "", "color": "", "day": "", // число "month": "", // число "year": "", // число "time": "" // в формате 00:00 }

https://{url}/http/event/{id} - METHOD "PUT" или "PATCH" { "title": "", "description": "", "phone": "", "color": "", "day": "", // число "month": "", // число "year": "", // число "time": "" // в формате 00:00 }

https://{url}/http/event/{id} - METHOD "DELETE"