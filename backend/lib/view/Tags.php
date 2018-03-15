<?php

namespace lib\view;

/**
 * Description of Tags
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @May 18, 2016
 */
class Tags {
    
   /**
     * @var string
     */
    const TAG_END = "'}";
    /**
     * Pattern for the tag extended layout for primary template file
     * @var string
     */
    const PATTERN_EXTENDS = "/\{@extends '[^']+'\}/";
    /**
     * @var string
     */
    const TAG_EXTENDS = "{@extends '";
    /**
     * @var string
     */
    const TAG_BLOCK_CONTENT = "{@block 'content'}";
    /**
     * Pattern for include tag
     * @var string
     */
    const PATTERN_INCLUDE = "/\{@include '[^']+'[^\}]*\}/";
    /**
     * @var string
     */
    const TAG_INCLUDE = "{@include '";
    /**
     * @var string
     */
    const TAG_PUTBLOCK = "{@block 'name'}";
    /**
     * @var string
     */
    const PATTERN_PUTBLOCK = "/({@block ')[^']*('})/";
    /**
     * @var string
     */
    const PATTERN_BLOCKS = "/{@block name='([^']*)'}/"; 
    /**
     * @var string
     */
    const PATTERN_ENDBLOCK = "{@endblock}";
    /**
     * @var string
     */
    const TAG_BLOCK_CSS = '<link id="block:css" />';
    /**
     * @var string
     */
    const TAG_BLOCK_JS = '<script id="block:js" />';
    /**
     * Pattern for embed tag
     * @var string
     */
    const PATTERN_EMBED = "/\{@embed ([^}]+)\}/";
    /**
     * @var string
     */
    const TAG_EMBED = "{@embed";

    /**
     * Pattern for embed tag
     * @var string
     */
    const PATTERN_LOAD = "/\{@load ([^}]+)\}/";
    /**
     * @var string
     */
    const TAG_LOAD = "{@load";
    /**
     * Pattern for data tag {$var}
     * @var string
     */
    const PATTERN_DATA = "/{\\$([^(} ]+)([^}]*)}/";

}
