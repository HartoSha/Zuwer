<?php 
    # Родительский класс всех моделей. Подключается к бд и выполняет запросы.
    class baseModel 
    {
        # Если вы получаете ошибку Parse error: syntax error, unexpected 'const' (T_CONST), expecting variable (T_VARIABLE) in _путь_ on line 6, то вам нужно обновить версию php пример: https://i.imgur.com/5j5VQPK.png
        private const hostName = "localhost";
        private const userName = "root";
        private const password = "";
        private const dbName = "zuwer";
        private const enctype = "utf8";

        private static $connection;

        private static function getConnection() 
        {
            if(!isset(self::$connection)) {
                self::$connection = mysqli_connect(self::hostName, self::userName, self::password, self::dbName) or die('Ошибка соединения: ' . mysqli_error(self::$connection));
            }
        }

        public static function query($sql) 
        {
             # Получаем новое соединение, если оно не было установлено ранее
            if(!isset(self::$connection) || !self::$connection) self::getConnection();
            mysqli_set_charset(self::$connection, self::enctype);

            # Подготавливаем 
            if($prepared = self::$connection->prepare($sql)){
                if(is_bool($prepared)) return $prepared;
                // var_dump($prepared);

                # Выполняем запрос и получаем статус
                $good = $prepared->execute() or die("<br/>Ошибка в sql запросе: " . $prepared->error);

                # получаем результат запроса если он прошел успешно
                if($good) $responce = $prepared->get_result();

                // $responce = mysqli_query(self::$connection, $sql) or die("<br/>Ошибка в sql запросе: " . mysqli_error(self::$connection)); # старый вариант. выдавал ошибку Commands out of sync; you can't run this command now при вызове нескольких sql запросов подряд
                // print "<br> responce: "; var_dump($responce); print "<br>";
                if(is_bool($responce)) return $responce;
                $result = null;

                # получаем кол-во строк в нем
                $rows = mysqli_num_rows($responce);
                if($rows == 1) {
                    # если полученная строка всего одна, то возвращаем ее в виде ассоциативного массива 
                    $result = mysqli_fetch_assoc($responce);
                }
                else 
                {
                    # иначе, оборачиваем полученные строки в массив
                    for ($i = 0 ; $i < $rows ; ++$i)
                    {
                        # каждое значение полученного массива $result - ассоциативный массив
                        $result[$i] = mysqli_fetch_assoc($responce);
                    }
                }
                # Закрываем запрос
                $prepared->close();
                return $result;
            }
        }
    }