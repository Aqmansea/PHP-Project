<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $city = $_POST['city'] ?? '';
    if (empty($city)) {
        echo json_encode(['status' => 'error', 'message' => '請輸入城市名稱。']);
        exit;
    }

    $apiKey = '你的API'; // 請替換為您的 OpenWeather API 密鑰
    $url = "http://api.openweathermap.org/data/2.5/forecast?q={$city}&appid={$apiKey}&units=metric&lang=zh_tw";

    $response = file_get_contents($url);
    
    if ($response === FALSE) {
        echo json_encode(['status' => 'error', 'message' => '無法連接到天氣服務。']);
        exit;
    }

    $data = json_decode($response, true);

    if ($data['cod'] != "200") {
        echo json_encode(['status' => 'error', 'message' => '找不到該城市的天氣數據。']);
        exit;
    }

    $result = '<div class="col-md-12"><div class="weather-card p-4"><h2 class="text-center mb-4">' . $city . '未來5天天氣預報</h2><table class="table table-bordered">';
    $result .= '<thead><tr><th>日期</th><th>天氣</th><th>溫度</th><th>濕度</th></tr></thead><tbody>';
    
    $dailyData = [];
    foreach ($data['list'] as $forecast) {
        $date = date('Y-m-d', $forecast['dt']);
        if (!isset($dailyData[$date])) {
            $dailyData[$date] = $forecast;
        }
    }

    foreach ($dailyData as $date => $forecast) {
        $weather = $forecast['weather'][0]['description'];
        $temp = round($forecast['main']['temp']);
        $humidity = $forecast['main']['humidity'];
        
        $result .= '<tr>';
        $result .= '<td>' . $date . '</td>';
        $result .= '<td>' . $weather . '</td>';
        $result .= '<td>' . $temp . '°C</td>';
        $result .= '<td>' . $humidity . '%</td>';
        $result .= '</tr>';
    }
    
    $result .= '</tbody></table></div></div>';

    echo json_encode(['status' => 'success', 'data' => $result]);
} else {
    echo json_encode(['status' => 'error', 'message' => '無效的請求方法。']);
}