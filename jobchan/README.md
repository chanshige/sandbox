# jobchan

## Usage:

基本的に以下コマンドで実行・出力される。
Slack へ投下する場合、.env でのWebhook設定を済ませて、
コマンドと一緒にオプションを付与し、実行。

### リソース相談室
$ bin/console notice:resource 

### 見積相談室
$ bin/console notice:estimate 

### クレジットテスト管理(ひろし師匠)
$ bin/console notice:credit 

### Option (Slack Message)

[must] --slack-notify

```$xslt
--channel[=CHANNEL]    
--username[=USERNAME]  
--icon[=ICON]        
```

### example
```$xslt
$ bin/console command --slack-notify \
--channel=#general \    
--username=botname \  
--icon=:smaile:
;
```
