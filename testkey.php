<?
// URL скрипта авторизации
$login_url = 'http://wikimapia.org/user/login/';
  
// параметры для отправки запроса - логин и пароль
$post_data = http_build_query([
  'username' => 'Логин на ВМ',
  'pw1' => 'Пасс от ВМ',
  '_time' => '3306',
]);
  
// создание объекта curl
$ch = curl_init();
  
// используем User Agent браузера
$agent = $_SERVER["HTTP_USER_AGENT"];
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
  
// задаем URL
curl_setopt($ch, CURLOPT_URL, $login_url );
  
// указываем что это POST запрос
curl_setopt($ch, CURLOPT_POST, 1 );
  
// задаем параметры запроса
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
  
// указываем, чтобы нам вернулось содержимое после запроса
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  
// в случае необходимости, следовать по перенаправлени¤м
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  
/*
    Задаем параметры сохранени¤ cookie
    как правило Cookie необходимы для дальнейшей работы с авторизацией
*/
  
curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
  
// выполняем запрос для авторизации
$postResult = curl_exec($ch);
$name = rand(200,999);
//Для создания ключей снимаем комментарий /**/ ниже и запускаем скрипт сколько нужно раз.Но вм может повесить КД ~30минут за частые запросы или большое количество ключей!


//Начало
/*
$timeout = 5; // set to zero for no timeout
$url2= "http://wikimapia.org/api/?action=create_key_process";
$post_data = http_build_query([
  'readed_eula' => 'true',
  'api_use' => 1,
  'site_name' => '',
  'application_name' => $name,
  'platform' => $name,
]);
// задаем URL
curl_setopt($ch, CURLOPT_URL, $url2 );
  
// указываем что это POST запрос
curl_setopt($ch, CURLOPT_POST, 1 );
  
// задаем параметры запроса
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
  
// указываем, чтобы нам вернулось содержимое после запроса
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  
// в случае необходимости, следовать по перенаправлени¤м
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$test = curl_exec($ch);*/
//Конец создания.

//==================================================Парсинг ключей,лучше не трогать все пашет само==========================================
curl_setopt($ch, CURLOPT_URL, 'http://wikimapia.org/api/?action=my_keys');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);
//Подключаем все файлы
require ('phpQuery-onefile.php');
require ('base.php');
 //Создаем коннект
$pq = phpQuery::newDocument($result);
$elem = $pq->find('dd');//ищем элемент с классом
$text = $elem->html();//выводим html код из полученного элемента
//Обрабатываем весь текст по маске
$re = '~\w{8}-\w{8}-\w{8}-\w{8}-\w{8}-\w{8}-\w{8}-\w{8}~';
$str = 'XXXXXXXX-XXXXXXX-XXXXXXXX-XXXXXXXX-XXXXXXXX-XXXXXXXX-XXXXXXXX-XXXXXXXX';

preg_match_all($re, $text, $matches, PREG_OFFSET_CAPTURE, 0);
//Гоним в первый массив
foreach ($matches[0] as $mt) {
//Далее обработка
foreach ($mt as $key => $value){
if(strlen($value)>15){
//Делаем проверку есть ли ключ в базе
$stmt = $go -> prepare('SELECT * FROM `wm_keys` WHERE `key`= ?');
    $stmt -> execute([$value]);
	$data = $stmt->fetch();
	//Проверка у меня по полю count я в него пишу 100(т.к это максимально сколько запросов может обработать ключ) и в скрипте выдачи ключа делаю `count`=`count`-1; Тем самым у меня всегда выдается рабочий ключ.Кому надо поймут)
	if($data['count']>0){
	echo $value.' есть в базе</br>';
	}else{
	//Если нет в базе,пишем
	$stmt = $go -> prepare('INSERT INTO `wm_keys` (`key`, `count`) VALUES (?, ?)');
    $stmt -> execute([$value, 100]);
	echo 'Внесли в базу '.$value.'</br>';
	}
	}
	}
}

?>