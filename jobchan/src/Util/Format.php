<?php
namespace Jobchan\Util;

/**
 * Class Backlog
 *
 * @package Jobchan\Util
 */
class Format
{
    /**
     * @param object $object
     * @return array
     */
    public static function extractIssues($object)
    {
        $data = [];
        foreach ($object as $item) {
            $data[] = [
                'id' => (int)$item->id,
                'issueKey' => $item->issueKey,
                'issueType' => $item->issueType->name,
                'priorityId' => $item->priority->id,
                'priority' => $item->priority->name,
                'status' => $item->status->name,
                'summary' => Common::truncatedStr($item->summary),
                'assigned' => $item->assignee->name,
                'createdUser' => $item->createdUser->name,
                'dueDate' => date_format(date_create($item->dueDate), 'Y-m-d'),
                'link' => getenv('BACKLOG_SPACE_URL') . 'view/' . $item->issueKey
            ];
        }
        return $data;
    }

    /**
     * 課題一覧 (Slack向け)
     *
     * @param array $object
     * @param bool  $viewCreatedUser
     * @return array
     */
    public static function issues($object, $viewCreatedUser = false)
    {
        $data = [];
        foreach ($object as $key => $item) {
            $data[$key] = "【{$item->status->name}】【優先度：{$item->priority->name}】 " .
                "<" . getenv('BACKLOG_SPACE_URL') . "view/{$item->issueKey}|{$item->issueKey}> " .
                Common::truncatedStr($item->summary);

            $data[$key] .= ($viewCreatedUser) ?
                " (created by {$item->createdUser->name})" : " (assigned to {$item->assignee->name})";
        }
        return $data;
    }

    /**
     * @param string $title
     * @param array  $data
     * @param string $footer
     * @return string
     */
    public static function createCodeBlocMsg($title, $data, $footer = '')
    {
        $contents = implode("\n", $data);
        return <<< EOF
{$title}
```
{$contents}
```
{$footer}
EOF;
    }
}
