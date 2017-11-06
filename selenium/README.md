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



### Linux

```bash
$ wget https://chromedriver.storage.googleapis.com/2.29/chromedriver_linux64.zip
$ unzip chromedriver_linux64.zip
$ sudo mv chromedriver /usr/local/bin/
```
`$ sudo yum install -y libX11 GConf2 fontconfig`

```bash
/etc/yum.repos.d/google-chrome.repo

[google-chrome]
name=google-chrome
baseurl=http://dl.google.com/linux/chrome/rpm/stable/$basearch
enabled=1
gpgcheck=1
gpgkey=https://dl-ssl.google.com/linux/linux_signing_key.pub
```

`sudo yum install -y google-chrome-stable libOSMesa google-noto-cjk-fonts`


```bash
sudo yum install java-1.8.0-openjdk-devel
java -version

wget http://selenium-release.storage.googleapis.com/2.53/selenium-server-standalone-2.53.0.jar
nohup java -jar selenium-server-standalone-2.53.0.jar &
```
