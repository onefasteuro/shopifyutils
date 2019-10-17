<?php

namespace onefasteuro\ShopifyUtils;

class ShopifyUtils
{
	
	/**
	 * Parse a domain name into shop name
	 * @param $name
	 * @return mixed
	 */
	public static function getHandleFromDomain($name)
	{
		$name = str_replace(['http://', 'https://', '.myshopify.com', '.myshopify.com/'], '', $name);
		return trim($name);
	}

    /**
     * Parses a GID and returns an id
     * @param $gid
     * @return int
     */
    public static function gidParse($gid)
    {
        return intval(preg_replace('/[^0-9]/', '', $gid));
    }

    /**
     * Restore an id into a GID
     * @param $id
     * @param $namespace
     * @return string
     */
    public static function gidRestore($id, $namespace)
    {
        $id = (int) $id;
        return sprintf('gid://shopify/%s/%d', $namespace, $id);
    }

    public static function formatDomain($domain, $protocol = false)
    {
        $domain = trim($domain);
        $domain = rtrim($domain, '/');

        $domain = str_replace(['http://', 'https://'], '', $domain);

        if(!preg_match('/\.myshopify\.com/', $domain)) {
            $domain = sprintf('%s.myshopify.com', $domain);
        }

        return ($protocol === false) ? $domain : sprintf('https://%s', $domain);
    }
	
	/**
	 * Extract headers from curl response
	 * @param $response
	 * @return array
	 */
	public static function parseHeaders($response)
	{
		$split = explode("\r\n\r\n", $response);
		$headers_section = trim( strstr($split[0], "\r\n") );
		unset($split);
		
		$headers = [];
		
		$headers_array = explode("\r\n", $headers_section);
		foreach($headers_array as $header)
		{
			$h = explode(': ', $header);
			$headers[$h[0]] = $h[1];
		}
		
		return $headers;
	}
	
	/**
	 * Extract the status code ouf of a curl response
	 * @param $response
	 * @return int
	 */
	public static function parseStatusCode($response)
	{
		$code = strstr($response,"\r\n",true);
		preg_match('/\d{3}/', $code, $matches);
		
		
		return (count($matches) > 0) ? (int) $matches[0] : 0;
	}
	
	/**
	 * Extract the body from a curl response
	 * @param $response
	 * @return mixed
	 */
	public static function parseBody($response)
	{
		$split = explode("\r\n\r\n", $response);
		return $split[1];
	}


}