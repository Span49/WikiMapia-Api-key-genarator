# WikiMapia Api key genarator
***
Для работы нам необходимо:
Любой хостинг где пашет cUrl.
Аккаунт на викимапии,который не жалко,вдруг что.
***
Далее открываем файл testkey.php в поля
 'username' => 'XXX',
  'pw1' => 'XXX',
  
Вводим свои логин и пароль от викимапии.
Далее идем в файл base.php настраиваем подключение к вашей базе.
Создаем таблицу wm_keys 
DROP TABLE IF EXISTS `wm_keys`;
CREATE TABLE `wm_keys` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL DEFAULT '',
  `count` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`key`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=cp1251;

После чего можем спокойно запускать наш testkey.php через браузер и наблюдать как ключики летят в БД.
Все вопросы можно задать мне в ЛС в моей ВК группе vk.com/urbanside
