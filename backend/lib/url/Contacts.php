<?php

namespace lib\url;

use \lib\url\MenuRender as MR;

/**
 * Description of Contacts
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Oct 17, 2016
 */
class Contacts extends \lib\url\Menu {

    public static function render($args = null) {

        $obj = new Contacts();
        $arr = ($args != null) ? \lib\tools\StringTools::argsToArray($args) : null;

        return $obj->output($arr);
    }

    private function getXml($args = null) {
        $arr = [];
        $xml = new \lib\xml\XmlFile('config/config.xml');
        $nodes = $xml->arrayXPath('contacts/*', 'node');
        foreach ($nodes as $node) {
            $key = $node->tagName;
            $arr[$key] = ['value' => '', 'type' => '', 'alt' => ''];
            foreach ($node->attributes as $attr) {
                if ($args == null || in_array($node, $args)) {
                    if ($attr->name == 'value') {
                        $arr[$key]['value'] = $attr->value;
                    }
                    if ($attr->name == 'type') {
                        $arr[$key]['type'] = $attr->value;
                    }
                    if ($attr->name == 'alt') {
                        $arr[$key]['alt'] = $attr->value;
                    }
                }
            }
        }
        return $arr;
    }

    public function output($args = null) {
        $values = $this->getXml($args);
        foreach ($values as $key => $node) {
            if ($node['type'] == 'social') {
                $this->menu .= $this->renderItem($node['value'], '', [MR::ICON_RIGHT => 'fa-' . $key, MR::TARGET => '_blank', MR::ALT => $node['alt']]);
            }
            if ($node['type'] == 'phone') {
                $this->menu .= $this->renderItem('tel:' . $node['value'], $node['value'], [MR::ICON_LEFT => 'fa-mobile', MR::CLASS_LI => 'phone', MR::ALT => $node['alt']]);
            }
            if ($node['type'] == 'mail') {
                $this->menu .= $this->renderItem('mailto:' . $node['value'], $node['value'], [MR::ICON_LEFT => 'fa-envelope-o', MR::CLASS_LI => 'mail', MR::ALT => $node['alt']]);
            }
            if ($node['type'] == 'skype') {
                $this->menu .= '<li>' . self::skypeButton($node['value']) . '</li>';
            }
        }

        return $this->menu;
    }

    public static function skypeButton($address) {
        return '<script type="text/javascript" src="https://secure.skypeassets.com/i/scom/js/skype-uri.js"></script>
            <div title="' . $address . '" id="SkypeButton_Call_contact_42197_1"><script type="text/javascript">Skype.ui({"name": "call",
            "element": "SkypeButton_Call_' . $address . '_1", "participants": ["' . $address . '"],
                "imageColor": "white", "imageSize": 24});</script></div>';
    }

}
