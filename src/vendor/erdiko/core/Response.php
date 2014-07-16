<?php
/**
 * Response
 * base response, all response objects should inherit from here
 * 
 * @category   Erdiko
 * @package    Core
 * @copyright  Copyright (c) 2014, Arroyo Labs, http://www.arroyolabs.com
 * @author	   John Arroyo
 */
namespace erdiko\core;
use Erdiko;


class Response
{
	protected $_theme;
    protected $_themeName;
    protected $_themeTemplate = 'default';
	protected $_content = null;
    protected $_data = array();
	
	/**
	 * Constructor
	 * @param Theme $theme, Theme Object (Contaier)
	 */
	public function __construct($theme = null)
	{
		$this->_theme = $theme;
    }

    public function setDataValue($key, $value)
    {
        $this->_data[$key] = $value;
    }

    /**
     * @param Theme object $theme, Theme Object (Container)
     */
    public function setTheme($theme)
    {
    	$this->_theme = $theme;
    }

    /**
     * @param string $themeName
     */
    public function setThemeName($themeName)
    {
        $this->_themeName = $themeName;
    }

    /**
     * @param string $themeName
     */
    public function setThemeTemplate($template)
    {
        $this->_themeTemplate = $template;
    }

    /**
     * @param Container $content, e.g. View or Layout Object
     */
    public function setContent($content)
    {
    	$this->_content = $content;
    }

    /**
     * Append some html content to the existing content
     * 
     * @param string $content
     * @todo check to see if content is a container, if so treat accordingly
     */
    public function appendContent($content)
    {
        $this->_content .= $content;
    }
    
    public function render()
    {
        error_log("themeName: {$this->_themeName}");
        
        $content = (is_subclass_of($this->_content, '\erdiko\core\Container')) ? $this->_content->toHtml() : $this->_content;

        if($this->_theme !== null)
            $html = $this->_theme->toHtml($content, $this->_data);
        elseif(!empty($this->_themeName))
        {
            error_log("themeName: {$this->_themeName}");
            $this->_theme = new \erdiko\core\Theme($this->_themeName, null, $this->_themeTemplate);
            $html = $this->_theme->toHtml($content, $this->_data);
        }
        else
            $html = $content;

        return $html;
    }

}
