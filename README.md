# www_hw3

http://wwweb.csie.io:2016/hw3/first.php
DEMO影片：https://youtu.be/iw7vRN6OPxE

## MySQL
使用MySQL儲存帳號資料、搜索紀錄及天氣圖示。

## Login and Register Page
當註冊及登入資料有誤會有alert提示，例如：使用者帳號重複、密碼與確認密碼不符、欄位未確實填寫完畢、使用者帳號與密碼與註冊資料不符。
Note：密碼在database中須加密處理。

## Weather Page
使用者可以在此頁面輸入欲搜尋的城市，下方會列出當前的天氣狀況以及未來五天的氣象預報。
Note：使用OpenWeatherMap的API獲取天氣預報的JSON資料。

## History Page
在此頁面可以看到當前使用者的所有搜索紀錄，輸入欲搜索的城市可以看到單一城市的搜索紀錄。

## Logout Page
登出五秒過後會跳轉頁面回到Login Page
