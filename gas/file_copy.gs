/** FileCopy Settings */
var copySource = DriveApp.getFileById(''),                            // コピーしたいファイルID
    destDir = DriveApp.getFolderById('0B1bkYxn3Pj4_ZEVwVXlqamJFRms'); // コピーしたファイルを置くフォルダID

/** DateTime Settings */
var date = {
  timeZone: "Asia/Tokyo",
  format: "yyyy/MM/dd"
}

/** DateTime Now */
var now = function(dateObject, timeZone, format) {
  return Utilities.formatDate(dateObject, timeZone, format);
}

/** Template Settings */
var templateConfig = {
  sheetName: "シート名",
  companyName: "株式会社あいうえお"
}

/**
 * シートのプロフィールを設定
 *
 * @param string sheetId   対象シートID
 * @param string issueName プロジェクト名(課題名)
 */
function setProfile(sheetId, issueName) {
  var activeSheet = SpreadsheetApp.openById(sheetId),
      target = activeSheet.getSheetByName(templateConfig["sheetName"]);

  // データを入れたいセルと内容を指定
  target.getRange('O12').setValue(issueName);
  target.getRange('I26').setValue(now(new Date(), date['timeZone'], date['format']));
  target.getRange('M26').setValue(templateConfig["companyName"]);
}

/**
 * ファイルコピー実行
 *
 * @param string prefix 接頭語(課題名)
 * @return File - the new copy
 */
function doFileCopy(prefix) {
  return copySource.makeCopy(prefix + '_' + copySource.getName(), destDir);
}

/**
 * アプリケーション実行関数(method:GET)
 *
 * {@link https://developers.google.com/apps-script/guides/web}
 * @param object request
 * @return string JSONP
 */
function doGet(request) {
  var issueName = request.parameter.issueName,
      cbFunc = request.parameter.callback || '';

  if(issueName === undefined) {
    throw new Error('課題名が設定されていません。')
  }

  var copied = doFileCopy(issueName),
      sheetId = copied.getId(),
      sheetName = copied.getName(),
      sheetUrl = copied.getUrl();

  setProfile(sheetId, issueName);

  var result = {
    available: sheetName,
    link: sheetUrl
  }

  return ContentService.createTextOutput(cbFunc + '(' + JSON.stringify(result) + ')')
  .setMimeType(ContentService.MimeType.JAVASCRIPT);
}

/*
 * debug
 */
function testExecute() {
  var cbFunc = {
    parameter: {issueName: "DEBUG_TEST", callback: "gas_tcs"},
    postData: "application/json"
  };

  Logger.log(doGet(cbFunc));
}
