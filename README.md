
## 

### 運行系統前事項
- 需匯入 DB (結構待捕)
- 先執行 composer 載入必要的套件 `composer install`
- 根目錄底下建立 .env 設定檔，請參考 .env.example 

### 目錄架構
- `/app` : 程式碼主要地方
   - `/Commands` : Cli
   - `/Config`   : 載入設定檔套件功能
   - `/Controllers` : 控制器
   - `/Repository` : 資料庫邏輯
   - `/Service` : 商業邏輯
   - `/Help` : 常用 function (autoload)
   - `/Trait` : Trait 撰寫處 (目前放置 Log 管理)
   
   - 其餘檔案為資料庫 model 
  
- `/config` : 設定檔撰寫處
- `/public` : index.php 和 js, css ..
- `/resource/view` : 視圖
- `/routes` : 路由設定，分為 web, cli, api
- `/vendor` : 外部套件
- `/composer.json` : composer 根據此內容安裝套件
- `/storage/log` : 存放 Log 的地方 

### 使用套件
- *Fat-Free*:
   - https://fatfreeframework.com/
   - 架構整個系統的 Framework，可指定網站路由，並有 template 套用語法等...
- *vlucas/phpdotenv*:
   - https://github.com/vlucas/phpdotenv
   - env 管理套件
- *illuminate/config*:
   - https://github.com/illuminate/config
   - config 管理套件
 - *Seldaek/monolog*:
   - https://github.com/Seldaek/monolog
   - 業界最常使用管理 Log 的套件
 - *ikkez/f3-middleware*:
   - https://github.com/ikkez/f3-middleware
   - 實作 f3 中介層功能
