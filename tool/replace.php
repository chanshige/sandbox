<?php
header('HTTP/1.1 200 OK');
header('Content-type: text/html');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

mb_regex_encoding('UTF-8');

/**
 * Class Replace (ファイル内文字列置換)
 * (入力値のバリデートは無し)
 */
class Replace
{
    /** @var array Values */
    private $values;
    /** @var array */
    public $result = array();

    public $isExec = false;

    public function __construct($post)
    {
        $this->values = $post;
        $this->exec();
    }

    public function getValue($name)
    {
        return $this->values[$name];
    }

    public function exec()
    {
        switch ($this->values['mode']) {
            case 'grep':
                $this->result = $this->targetFile();
                $this->isExec = true;
                break;

            case 'live':
                $this->result = $this->replaceFile();
                $this->isExec = true;
                break;

            default:
                break;
        }
    }

    public function result()
    {
        return $this->result;
    }

    public function isResult()
    {
        return count($this->result()) > 0;
    }

    public function isExecute()
    {
        return $this->isExec;
    }

    private function grepCmd()
    {
        $cmd = 'grep -R -l '
            . $this->getValue('search')
            . ' '
            . $this->getValue('directory');

        $cmd .= ($this->getValue('ext') != '') ? " --include='*.{$this->getValue('ext')}'" : '';

        return $cmd;
    }

    private function targetFile()
    {
        return self::cmd($this->grepCmd());
    }

    private function replaceFile()
    {
        $origin = addcslashes($this->getValue('search'), '/$');
        $replace = addcslashes($this->getValue('replace'), '/$');

        return self::cmd($this->grepCmd()
            . '|xargs sed -i -e "'
            . "s/{$origin}/{$replace}/g" . '"');
    }


    private static function cmd($string)
    {
        if ($string == '') {
            return false;
        }
        exec($string, $result);
        return $result;
    }
}

$app = new Replace($_REQUEST);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Replace(2017) | If you change one person's life, you change the world.</title>
  <link href="//fonts.googleapis.com/css?family=Lato:300" rel="stylesheet">
  <style>
    html, body {
      height: 100%;
    }

    body {
      margin: 0;
      padding: 0;
      width: 100%;
      display: table;
      font-weight: 100;
      font-family: 'Lato', Helvetica Neue;
    }

    .container {
      text-align: center;
      margin-top: 100px;
      vertical-align: middle;
    }

    .content {
      text-align: center;
      margin-top: 50px;
      width: auto;
    }

    .title {
      font-size: 60px;
      margin-bottom: 25px;
    }

    p.title {
      font-size: 25px;
    }

    .count {
      margin: 50px 0 0;
      font-size: 20px;
    }

    .search_fields input[type="text"] {
      padding: 10px 10px 10px;
      font-size: 15px;
      font-weight: 500;
      width: 35%;
      border-radius: 0;
    }

    .button button {
      width: 120px;
      height: 40px;
      margin: 30px auto 0;
      background: transparent;
      cursor: pointer;
      color: rgb(204, 204, 204);
      border: 1px solid;
      border-radius: 0;
      -webkit-appearance: none;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="title">Simple Replacement.</div>

  <div class="search_fields">
    <form class="search-form" action="" method="post">
      <div>
        <label for="directory">
          <input type="text" name="directory"
                 value="<?php echo htmlspecialchars($app->getValue('directory')); ?>"
                 placeholder="target directory(<?php echo __DIR__; ?>)">
        </label>
        <br><br>
        <label for="ext">
          <input type="radio" name="ext"
                 value="tpl" <?php echo ($app->getValue('ext') == 'tpl') ? 'checked' : ''; ?>>.tpl
          <input type="radio" name="ext"
                 value="html" <?php echo ($app->getValue('ext') == 'html') ? 'checked' : ''; ?>>.html
          <input type="radio" name="ext"
                 value="css" <?php echo ($app->getValue('ext') == 'css') ? 'checked' : ''; ?>>.css
          <input type="radio" name="ext"
                 value="js" <?php echo ($app->getValue('ext') == 'js') ? 'checked' : ''; ?>>.js
        </label>
        <br><br>
        <label for="search">
          <input type="text" name="search"
                 value="<?php echo htmlentities($app->getValue('search'), ENT_QUOTES, 'UTF-8'); ?>"
                 placeholder="search for...">
        </label>
        <label for="replace">
          <input type="text" name="replace"
                 value="<?php echo htmlentities($app->getValue('replace'), ENT_QUOTES, 'UTF-8'); ?>"
                 placeholder="replace with...">
        </label>
      </div>
      <div class="button">
        <button type="submit" name="mode" value="grep">grep</button>
        <button type="submit" name="mode" value="live">live</button>
      </div>
      <div class="count">
        <span><?php echo 'Hit: ' . count($app->result()) . "<br>"; ?></span>
      </div>
    </form>
  </div>
  <div class="content">
      <?php
      if ($app->isResult() && $app->isExec) {
          foreach ($app->result() as $file) {
              echo $file . "<br>";
          }
      }
      ?>
  </div>
</div>
</body>
</html>
