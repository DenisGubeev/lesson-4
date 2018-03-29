<?php

$appid = '8cb99e45f9746756b2a9b91872cda06e';
$id_default = '524894';
if (isset($_REQUEST['city'])) {
    $city_id = $_REQUEST['city'];
};
if (empty($city_id)) {
    $city_id = $id_default;
};
$api = file_get_contents("http://api.openweathermap.org/data/2.5/weather?id=" . $city_id . "&appid=" . $appid);
$city_list_file = file_get_contents("listOfCities.json");
$decode_api = json_decode($api, true);
$decode_city = json_decode($city_list_file, true);

$city_name = $decode_api['name'];

$weather_desc = $decode_api['weather'][0]['description'];
$pressure = $decode_api['main']['pressure'];
$humidity = $decode_api['main']['humidity'];
$coord_lon = $decode_api['coord']['lon'];
$coord_lat = $decode_api['coord']['lat'];

$temp = $decode_api['main']['temp'];

$temp_celsius = $temp - 273;
$temp_celsius = round($temp_celsius, 1). ' C&deg';

if ($temp_celsius > 0) {
    $temp_celsius = str_pad($temp_celsius, strlen($temp_celsius)+1, "+", STR_PAD_LEFT);
}

$icon = $decode_api['weather'][0]['icon'];
$icon_url = 'http://openweathermap.org/img/w/' . $icon . '.png';
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Lesson-1.4</title>
    <meta charset="UTF-8">
</head>
<body>
    <div>
        <form method="post" enctype="multipart/form-data">
            <select name="city">
                <?php foreach ($decode_city as $item) : ?>
                <option value="<?=$item['id']?>" <?php if ($item['id'] == $city_id) : echo "selected=\"selected\""; endif ?>><?=$item['name']?></option>
                <?php endforeach; ?>
            </select>
            <button>Search</button>
        </form>
        <h1><?=$city_name;?></h1>
        <div><img src="<?= $icon_url; ?> " alt=""> <span><?= $temp_celsius; ?></span></div>
        <div><?= $weather_desc; ?></div>

        <ul>
            <li>
                <div>
                    <div>
                        <span>Pressure:</span>
                    </div>
                    <div>
                        <div>
                            <?= $pressure; ?> hpa
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div>
                    <div>
                        <span>Humidity:</span>
                    </div>
                    <div>
                        <div>
                            <?= $humidity; ?> %
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div>
                    <div>
                        <span>Geo coords:</span>
                    </div>
                    <div>
                        <div>
                            [<?= $coord_lat; ?>, <?= $coord_lon; ?>]
                        </div>
                    </div>
                </div>
            </li>
        </ul>

    </div>
</body>
</html>
