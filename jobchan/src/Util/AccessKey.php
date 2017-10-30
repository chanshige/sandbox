<?php
namespace Jobchan\Util;

/**
 * Class AccessKey
 *
 * @package Jobchan\Util
 */
final class AccessKey
{
    /** @var string AccessId */
    private $accessId;
    /** @var string SecretKey */
    private $secretKey;

    /**
     * AccessKey constructor.
     *
     * @param string $accessId
     * @param string $secretKey
     */
    public function __construct($accessId, $secretKey)
    {
        $this->accessId = $accessId;
        $this->secretKey = $secretKey;
    }

    /**
     * Generate a keyed hash value.
     *
     * @return string
     */
    public function generate()
    {
        return hash_hmac('sha256', $this->accessId, $this->secretKey);
    }
}
