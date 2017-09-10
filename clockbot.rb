#!/usr/bin/env ruby
require 'slack'

Slack.configure do |config|
  config.token = 'slack.api_token'
end

text = case Time.now.hour
         when 8 then
           '------- 8:00 -------'
         when 9 then
           '*------- 9:00 本日もご安全に! -------*'
         when 10 then
           '------- 10:00 -------'
         when 11 then
           '------- 11:00 -------'
         when 12 then
           '*------- 12:00 -------*'
         when 13 then
           '------- 13:00 -------'
         when 14 then
           '------- 14:00 -------'
         when 15 then
           '------- 15:00 -------'
         when 16 then
           '------- 16:00 -------'
         when 17 then
           '------- 17:00 -------'
         when 18 then
           '*------- 18:00 定時だよ! -------*'
         when 19 then
           '------- 19:00 *残業申請・工数登録* -------'
         when 20 then
           '------- 20:00 *残業申請・工数登録* -------'
         when 21 then
           '------- 21:00 -------'
         when 22 then
           '------- 22:00 -------'
         else
           'clockbot'
       end

Slack.chat_postMessage(
    username: 'clockbot',
    icon_emoji: '',
    text: text,
    channel: '1989'
)
