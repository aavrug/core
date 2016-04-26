<?php
/**
 * Layout
 * @todo allow switching between layout templates in the theme and the views folder
 *
 * @category   Erdiko
 * @package    Core
 * @copyright  Copyright (c) 2016, Arroyo Labs, http://www.arroyolabs.com
 * @author     John Arroyo
 */
namespace erdiko\core;

/**
 * Layout Class
 */
class Layout extends Container
{
    /** Theme Template folder */
    protected $_themeRootFolder;
    /** Regions */
    protected $_regions = array();
    /** Data */
    protected $_data = array();
    /** Theme */
    protected $_theme;
    /** Theme */
    protected $_viewRootFolder;
    

    /**
     * Constructor
     *
     * @param string $template , Theme Object (Contaier)
     * @param mixed $data
     * @param string $theme
     */
    public function __construct($template = null, $data = array(), $themeName = null)
    {
        $template = ($template === null) ? $this->_defaultTemplate : $template;
        $data['getRegion'] = function($name) { return $this->getRegion($name); };

        $this->initiate($template, $data);
        $this->setThemeRootFolder('themes');
        $this->setThemeName($themeName);
        $this->setTemplateFolder($this->getThemeRootFolder().'/'.$themeName.'/templates/layouts');
    }

    /**
     * Get template file
     *
     * @param string $filename
     * @param mixed $data Typically a string, Container object or other object
     * @return string
     * @todo array merge regions with data
     */
    public function getTemplateFile($filename, $data)
    {
        // Push the data into regions and then pass a pointer to this class to the layout
        $this->setRegions($data);
        return parent::getTemplateFile($filename, $this); // Pass in layout object to template
    }

    /**
     * Set View Root Folder
     *
     * @param string $folder
     */
    public function setViewRootFolder($folder)
    {
        $this->_viewRootFolder = $folder;
    }

    /**
     * Get Theme Root Folder
     *
     * @param string $folder
     */
    public function getThemeRootFolder()
    {
        return $this->_themeRootFolder;
    }

    /**
     * Set Theme Root Folder
     *
     * @param string $folder
     */
    public function setThemeRootFolder($folder)
    {
        $this->_themeRootFolder = $folder;
    }

    /**
     * Set theme name
     *
     * @param string $themeName
     */
    public function setThemeName($themeName)
    {
        $this->_theme = $themeName;
    }

    /**
     * Get theme name
     */
    public function getThemeName()
    {
        return $this->_theme;
    }

    /**
     * set region
     *
     * @param string $name
     * @param mixed $content , Typically a string, Container object or other object
     */
    public function setRegion($name, $content)
    {
        $this->_regions[$name] = $content;
    }

    /**
     * Set all regions at once
     *
     * @param array $data , Associative array of containers/strings
     */
    public function setRegions($data)
    {
        $this->_regions = $data;
    }

    /**
     * Get regions
     *
     * @return array $this_regions
     */
    public function getRegions()
    {
        return $this->_regions;
    }

    /**
     * get rendered region
     *
     * @param string $name
     * @return mixed $content, typically a string, Container object or other object
     */
    public function getRegion($name)
    {
        $html = (is_subclass_of($this->_regions[$name], 'erdiko\core\Container')) ?
            $this->_regions[$name]->toHtml() : $this->_regions[$name];

        return $html;
    }
}
