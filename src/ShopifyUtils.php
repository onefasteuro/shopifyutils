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
		$name = trim($name);
		preg_match('/.+?(?=\/)/', $name, $matches);
		
		return (count($matches) > 0) ? $matches[0] : null;
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
	if(!preg_match('/gid\:/', $id)) {
		$id = (int) $id;
		return sprintf('gid://shopify/%s/%d', $namespace, $id);
	}
	else {
		return $id;	
	}
    }

    public static function formatDomain($domain)
    {
        $domain = trim($domain);
        $domain = rtrim($domain, '/');

        $domain = str_replace(['http://', 'https://'], '', $domain);

        if(!preg_match('/\.myshopify\.com/', $domain)) {
            $domain = sprintf('%s.myshopify.com', $domain);
        }

        return $domain;
    }
	
	public static function formatFqdn($domain)
	{
		$domain = static::formatDomain($domain);
		return sprintf('https://%s', $domain);
	}

}
