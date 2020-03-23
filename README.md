# 安裝

1. 建立 composer.json

        {
            "require": {
                "jrealm/dungeons": "dev-master"
            },
            "scripts": {
                "post-update-cmd": [
                    "sh vendor/jrealm/dungeons/doc/install"
                ]
            }
        }

2. 執行

        composer install

    或

        composer update

# 檔案與目錄

| 名稱              | 說明                          |
|-------------------|-------------------------------|
| action/           | Controller                    |
| class/            | PHP 類別                      |
| config/           | 系統設定                      |
| doc/              | 說明文件                      |
| include/          | App 啟動程序                  |
| menu/             | 選單                          |
| message/          | 語言包                        |
| table/            | Model 描述                    |
| twig/             | Twig 樣板引擎 function/filter |
| view/             | View 樣板                     |
| www/              | 網頁靜態檔案 html/css/js      |
| composer.json     | 套件管理                      |
