<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html"; charset="utf8">
    <title>Morbidity</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link href="style.css" rel="stylesheet">
</head>

<body>

<form action="" method="post">
    <!--Фильтр по месяцам-->
    <!--<select name="month" id="b">
        <option id="jan">Январь</option>
        <option id="feb">Февраль</option>
        <option id="mar">Март</option>
    </select>-->
    <!--фильтр по ФО-->
    <select name="family" id="a">
        <option value="" selected="selected"  <? if($_POST['family'] == 1) echo "selected"?>>Российская Федерация</option>
        <option value="2" <? if($_POST['family'] == 2) echo "selected"?>>Дальневосточный федеральный округ</option>
        <option value="3" <? if($_POST['family'] == 3) echo "selected"?>>Приволжский федеральный округ</option>
        <option value="4" <? if($_POST['family'] == 4) echo "selected"?>>Северо-Западный федеральный округ</option>
        <option value="5" <? if($_POST['family'] == 5) echo "selected"?>>Северо-Кавказский федеральный округ</option>
        <option value="6" <? if($_POST['family'] == 6) echo "selected"?>>Сибирский федеральный округ</option>
        <option value="7" <? if($_POST['family'] == 7) echo "selected"?>>Уральский федеральный округ</option>
        <option value="8" <? if($_POST['family'] == 8) echo "selected"?>>Центральный федеральный округ</option>
        <option value="9" <? if($_POST['family'] == 9) echo "selected"?>>Южный федеральный округ</option>
    </select>
        <input name="search" id="button" type="submit" value="Search">
    </form>

<?php

$family = "";
if(isset($_POST['family'])) {
    $family = $_POST['family'];
}

try {   //подключение к БД
    $con= new PDO('mysql:host=localhost;dbname=morbidity1', "root", "526234ms_D!");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //запросы по фильтрам
    if(!empty($family)) {
        $query = "SELECT date, t.parent_id , t.name 'tername', h.name 'hospname', d.name 'disname', patients, issued, (issued-patients)  FROM statistics s
inner join disease d on s.disease_id = d.id
inner join hospital h on s.hospital_id = h.id
inner join territory t on h.terr_id = t.id
WHERE t.parent_id = '.$family.'
order by date, t.parent_id, t.name;";
    }
    else {
        $query = "SELECT date, t.parent_id , t.name 'tername', h.name 'hospname', d.name 'disname', patients, issued, (issued-patients)  FROM statistics s
inner join disease d on s.disease_id = d.id
inner join hospital h on s.hospital_id = h.id
inner join territory t on h.terr_id = t.id
order by date, t.parent_id, t.name;";
    }

    print "<table>";
    $result = $con->query($query);
    //шапка таблицы
    $row = $result->fetch(PDO::FETCH_ASSOC);
    print " <tr>";
        foreach ($row as $field => $value){
            print " <th>$field</th>";
        }
    /// данные таблицы
    print " </tr>";
    $data = $con->query($query);
    $data->setFetchMode(PDO::FETCH_ASSOC);
    foreach($data as $row){
        print " <tr>";
        foreach ($row as $name=>$value){
            print " <td>$value</td>";
        }
        print " </tr>";
    }
    print "</table>";
} catch(PDOException $e) {  // при ошибке
    echo 'ERROR: ' . $e->getMessage();
}
?>

</body>
</html>