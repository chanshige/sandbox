<?php

/**
 * Class HttpCurl
 */
final class HttpCurl
{
    /** @var mixed */
    private $response;

    /** @var array */
    private $responseInfo;

    /**
     * Get.
     *
     * @param string $url
     * @throws Exception
     */
    public function onGet($url)
    {
        $ch = curl_init($url);
        $this->setCommonOptions($ch);
        $response = $this->execute($ch);
        $this->responseInfo = curl_getinfo($ch);
        curl_close($ch);

        $this->response = $response;
    }

    /**
     * Post.
     *
     * @param string $url
     * @param array  $params
     * @param array  $header
     * @throws Exception
     */
    public function onPost($url, $params = array(), $header = array())
    {
        $ch = curl_init($url);
        $this->setCommonOptions($ch);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $response = $this->execute($ch);
        $this->responseInfo = curl_getinfo($ch);
        curl_close($ch);

        $this->response = $response;
    }

    /**
     * GetResponse.
     *
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Get response. (JSON => Array)
     *
     * @return array
     * @throws Exception
     */
    public function getResponseToArray()
    {
        $ret = json_decode($this->response, true);
        $errorCode = json_last_error();
        if ($errorCode !== JSON_ERROR_NONE) {
            throw new Exception('Json parse error.', $errorCode);
        }

        return $ret;
    }

    /**
     * Get cURL response info.
     *
     * @return array
     */
    public function getResponseInfo()
    {
        return $this->responseInfo;
    }

    /**
     * 実行
     *
     * @param resource $ch
     * @return bool|string
     * @throws
     */
    private function execute($ch)
    {
        $response = curl_exec($ch);
        if ($response === false) {
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            throw new Exception('取得失敗しました。', $httpCode);
        }

        return $response;

    }

    /**
     * Set cURL options.
     *
     * @param resource $ch
     * @return void
     */
    private function setCommonOptions($ch)
    {
        curl_setopt($ch, CURLOPT_PORT, 443);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    }
}
