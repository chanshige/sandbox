# selenium
facebookのphp-webdriverを使ったseleniumの自動テストを試してみる (Mac)

#### 準備
- jdk (Java)\
JDKいるので入れておく
http://www.oracle.com/technetwork/java/javase/downloads/jdk8-downloads-2133151.html

- Selenium Standalone Server \
http://www.seleniumhq.org/download/ \
(Download version x.x.x)のリンクから

- chromedriver \
https://sites.google.com/a/chromium.org/chromedriver/downloadsunzip \
`mv chromedriver /usr/local/bin/`

#### 動かす
- selenium server 起動 \
`java -jar selenium-server-standalone-x.x.x.jar &` (x.x.x : version)

- 実行 \
`composer test` なり `php public/example.php` 