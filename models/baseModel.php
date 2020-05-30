<?php 
    # Родительский класс всех моделей. Подключается к бд и выполняет запросы.
    class baseModel 
    {
        private const hostName = "localhost";
        private const userName = "root";
        private const password = "";
        private const dbName = "zuwer";
        private const enctype = "utf8";

        private static $connection;

        private static function getConnection() 
        {
            if(!isset(self::$connection)) {
                self::$connection = mysqli_connect(self::hostName, self::userName, self::password, self::dbName) or die('Ошибка соединения: ' . mysql_error());
            }
        }

        public static function query($sql) 
        {
             # Получаем новое соединение, если оно не было установлено ранее
            if(!isset(self::$connection) || !self::$conncetion) self::getConnection();
            mysqli_set_charset(self::$connection, self::enctype);

            # получаем результат запроса
            $responce = mysqli_query(self::$connection, $sql) or die("<br/>Ошибка в sql запросе: " . mysqli_error(self::$connection));

            # получаем кол-во строк в нем
            $rows = mysqli_num_rows($responce);

            # если полученная строка всего отдна, то возвращаем ее в виде ассоциативного массива 
            if($rows = 1) return mysqli_fetch_array($responce, MYSQLI_ASSOC);

            # иначе, оборачиваем полученные строки в массив
            $result = null;
            for ($i = 0 ; $i < $rows ; ++$i)
            {
                $result[$i] = mysqli_fetch_array($responce, MYSQLI_ASSOC);
            }
            
            # каждое значение полученного массива $result - ассоциативный массив
            return $result;
        }
    }