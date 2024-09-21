<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>天氣預報</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        body {
            background-color: #f0f8ff;
            background-image: url("https://cdn.pixabay.com/photo/2023/08/06/07/19/field-8172323_1280.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
        }
        .weather-card {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">天氣預報</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form id="weatherForm" class="mb-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="city" placeholder="輸入城市名稱" required>
                        <button class="btn btn-primary" type="submit">獲取天氣</button>
                    </div>
                </form>
            </div>
        </div>
        <div id="weatherResult" class="row justify-content-center"></div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resultModalLabel">查詢結果</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalMessage">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
$(document).ready(function() {
    var resultModal = new bootstrap.Modal(document.getElementById('resultModal'));

    $('#weatherForm').submit(function(e) {
        e.preventDefault();
        var city = $('#city').val();
        $.ajax({
            url: 'get_weather.php',
            type: 'POST',
            data: {city: city},
            dataType: 'json',
            success: function(response) {
                if (response.status === 'error') {
                    $('#modalMessage').html(response.message);
                    $('#weatherResult').html('');
                } else {
                    $('#modalMessage').html('查詢成功！');
                    $('#weatherResult').html(response.data);
                }
                resultModal.show();
            },
            error: function() {
                $('#modalMessage').html('發生錯誤，請稍後再試。');
                $('#weatherResult').html('');
                resultModal.show();
            }
        });
    });
});
    </script>
</body>
</html>