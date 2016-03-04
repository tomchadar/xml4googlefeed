<?php

/**
 * XMLUtils class
 *
 * SimpleXML utilities
 *
 * @author: Tom Chadaravicius
 * 2016-03-01
*/
class XMLUtils
{

	/**
	 * xml2array - Convert SimpleXMLElement ro PHP array
	 *
	 * @param SimpleXMLElementd $xmlObject The root element
	 * @param array $arrNameSpaces Array of namespaces as array('nsname'=>'http://ns.url.org'). Defaults to empty array
	 * @param array $arrOutput The output array
	 * @return array Resulting array
	 *
	 */	
	public static function xml2array($xmlObject,$arrNameSpaces=array(), $arrOutput = array () )
	{
		if(!isset($xmlObject))
		{
			return array();	
		}
		$objChild=null;
		$arrChild=array();
		if(!($arrNameSpaces))
		{
			$arrOutput=self::xmlchild2array($xmlObject);
		}
		foreach($arrNameSpaces as $NSItemName=>$NSItemValue)
		{
			$objChild=$xmlObject->children($NSItemValue);
			$arrChild=self::xmlchild2array($objChild);
			if($NSItemName)
			{
				$arrOutput[$NSItemName]=$arrChild;	
			}
			else
			{
				$arrOutput=array_merge($arrOutput,$arrChild);	
			}
			
		}
		return $arrOutput;
	}
	public static function xmlchild2array($xmlObject, $arrOutput = array () )
	{
		if(!isset($xmlObject))
		{
			return array();	
		}
		$objAttribs=null;
		$arrAtributes=array();
		if(is_object($xmlObject))
		{
			$objAttribs=$xmlObject->attributes();
		}
		$arrObject=(array)$xmlObject;
		if($objAttribs)
		{
			$arrAtributes=self::xmlattribs2array($objAttribs);
			if(empty($arrObject))
			{
				return $arrAtributes;	
			}
		}
		foreach ($arrObject as $index => $node )
		{
			if(!is_string($node))
			{
				if(!$arrAtributes)
				{
					$arrOutput[$index]=self::xmlchild2array($node);
				}
				else
				{
					return $arrAtributes;	
				}
			}
			else
			{
				$arrOutput[$index]=$node;
				
			}
		}
		return $arrOutput;
	}

	protected static function xmlattribs2array($xmlObject, $arrOutput = array () )
	{
		$arrObject=(array)$xmlObject;
		if(array_key_exists('@attributes',$arrObject))
		{
			return $arrObject['@attributes'];
		}
		return $arrOutput;
	}
	
	
}