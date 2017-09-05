<?php
namespace Jobchan\Util;

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;

class UtilTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $dotenv = new Dotenv(APP_DIR . 'tests/');
        $dotenv->load();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testBuildQuery()
    {
        $parameters = [
            'abc' => 1,
            'def' => 2,
            'ghi' => 3
        ];
        $this->assertEquals('abc=1&def=2&ghi=3', Common::buildQuery($parameters));
    }

    public function testTruncateString()
    {
        $str = 'hello world';
        $this->assertEquals('hello w...', Common::truncatedStr($str, 10));
    }

    public function testExtractIssuesFormat()
    {
        $array = [
            [
                'id' => 100,
                'issueKey' => 'KEY',
                'issueType' => ['name' => 'issueName'],
                'priority' => ['id' => 1, 'name' => '低'],
                'status' => ['name' => '未対応'],
                'summary' => 'サマリー',
                'assignee' => ['name' => 'アサイン'],
                'createdUser' => ['name' => '作成者'],
                'dueDate' => '02/31/2011'
            ],
            [
                'id' => 200,
                'issueKey' => 'KEY2',
                'issueType' => ['name' => 'issueName2'],
                'priority' => ['id' => 2, 'name' => '中'],
                'status' => ['name' => '処理中'],
                'summary' => 'サマリー2',
                'assignee' => ['name' => 'アサイン2'],
                'createdUser' => ['name' => '作成者2'],
                'dueDate' => '02/31/2013'
            ]
        ];

        $expected = [
            [
                'id' => 100,
                'issueKey' => 'KEY',
                'issueType' => 'issueName',
                'priorityId' => 1,
                'priority' => '低',
                'status' => '未対応',
                'summary' => 'サマリー',
                'assigned' => 'アサイン',
                'createdUser' => '作成者',
                'dueDate' => '2011-03-03',
                'link' => 'https://hogehoge.backlog.jp/view/KEY'
            ],
            [
                'id' => 200,
                'issueKey' => 'KEY2',
                'issueType' => 'issueName2',
                'priorityId' => 2,
                'priority' => '中',
                'status' => '処理中',
                'summary' => 'サマリー2',
                'assigned' => 'アサイン2',
                'createdUser' => '作成者2',
                'dueDate' => '2013-03-03',
                'link' => 'https://hogehoge.backlog.jp/view/KEY2'
            ]

        ];

        $this->assertEquals($expected, Format::extractIssues(json_decode(json_encode($array))));
    }

    public function testIssuesFormat()
    {
        $array = [
            [
                'id' => 100,
                'issueKey' => 'KEY',
                'issueType' => ['name' => 'issueName'],
                'priority' => ['id' => 1, 'name' => '低'],
                'status' => ['name' => '未対応'],
                'summary' => 'サマリー',
                'assignee' => ['name' => 'アサイン'],
                'createdUser' => ['name' => '作成者'],
                'dueDate' => '02/31/2011'
            ],
            [
                'id' => 200,
                'issueKey' => 'KEY2',
                'issueType' => ['name' => 'issueName2'],
                'priority' => ['id' => 2, 'name' => '中'],
                'status' => ['name' => '処理中'],
                'summary' => 'サマリー2',
                'assignee' => ['name' => 'アサイン2'],
                'createdUser' => ['name' => '作成者2'],
                'dueDate' => '02/31/2013'
            ]
        ];

        $expected = [
            '【未対応】【優先度：低】 <https://hogehoge.backlog.jp/view/KEY|KEY> サマリー (assigned to アサイン)',
            '【処理中】【優先度：中】 <https://hogehoge.backlog.jp/view/KEY2|KEY2> サマリー2 (assigned to アサイン2)'
        ];

        $this->assertEquals($expected, Format::issues(json_decode(json_encode($array))));
    }
}
