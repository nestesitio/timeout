<?php

namespace lib\media;

/**
 * Description of Image
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Aug 21, 2015
 */
class Image
{
    const MIN_WIDTH = 'min-width';
    const MIN_HEIGHT = 'min-height';
    const MAX_WIDTH = 'max-width';
    const MAX_HEIGHT = 'max-height';
    const MIN_RATIO = 'min-ratio';
    const MAX_RATIO = 'max-ratio';
    
    /**
     * @var string
     */
    private $file;
    /**
     * @var int
     */
    public $width = 0;
    /**
     * @var int
     */
    public $heigth = 0;
    /**
     * @var
     */
    private $type;
    
    /**
     *
     * @var type 
     */
    public $ratio = 1;

    /**
     * Image constructor.
     * @param $src
     */
    public function __construct($src)
    {
        if (strpos($src, 'https://') !== false || is_file($src)) {
            $this->file = $src;

        } else {
            $this->file = ROOT . DS . str_replace(ROOT . DS, '', $src);
        }
        list($this->width, $this->heigth, $this->type, ) = getimagesize($this->file);
        $this->ratio = $this->width / $this->heigth;
    }
    
    
    /**
     * 
     * @return int
     */
    public function getWidth(){
        return $this->width;
    }
    
    /**
     * 
     * @return int
     */
    public function getHeight(){
        return $this->heigth;
    }

        /**
     * @param $destiny
     * @param $max_width
     * @param $max_height
     * @return mixed
     */
    public function resampleImageFile($destiny, $max_width, $max_height)
    {
        
        //redimensiona a imagem
        $ext = self::getExtension($this->type);
        if ($this->width > $max_width || $this->heigth > $max_height) {
            $src_img = self::getImageCreate($this->file, $ext);
            if (isset($src_img)) {
                $dimensions = self::resize($max_width, $max_height, $this->width, $this->heigth);
                $dst_w = $dimensions['w'];
                $dst_h = $dimensions['h'];

                $dst_img = self::imageCreate($ext, $dst_w, $dst_h);
                if ($ext == 'gif') {
                    self::imageCopy($src_img, $dst_img, $dst_w, $dst_h, $max_width, $max_height);
                    imagegif($dst_img, $destiny);
                } else {
                    self::imageCopy($src_img, $dst_img, $dst_w, $dst_h, $max_width, $max_height);
                    if ($ext == 'jpg') {
                        imagejpeg($dst_img, $destiny, 80);
                    } elseif ($ext == 'png') {
                        imagepng($dst_img, $destiny);
                    }
                }
            }
            ImageDestroy($dst_img);
        }else{
            move_uploaded_file($this->file, $destiny);
        }
        return $destiny;
    }

    /**
     * @param $ext
     * @param $dst_w
     * @param $dst_h
     * @return mixed
     */
    private function imageCreate($ext, $dst_w, $dst_h)
    {
        if ($ext == 'gif') {
            return imagecreate($dst_w, $dst_h);
        } else {
            return ImageCreateTrueColor($dst_w, $dst_h);
        }
    }

    /**
     * @param $src_img
     * @param $dst_img
     * @param $dst_w
     * @param $dst_h
     * @param $max_width
     * @param $max_height
     */
    private function imageCopy($src_img, $dst_img, $dst_w, $dst_h, $max_width, $max_height)
    {
        if ($this->width > $max_width || $this->heigth > $max_height) {
            ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $dst_w, $dst_h, $this->width, $this->heigth);
        } else {
            ImageCopy($dst_img, $src_img, 0, 0, 0, 0, $this->width, $this->heigth);
        }
    }

    /**
     * @param $src
     * @param $ext
     * @return mixed
     */
    private static function getImageCreate($src, $ext)
    {
        if ($ext == 'jpg') {
            return imagecreatefromjpeg($src);
        } elseif ($ext == 'png') {
            return imagecreatefrompng($src);
        } elseif ($ext == 'gif') {
            return imagecreatefromgif($src);
        }
    }

    /**
     * @param $type
     * @return mixed
     */
    private static function getExtension($type)
    {
        $ext = image_type_to_extension($type);
        $ext = str_replace('.', '', $ext);
        $ext = str_replace('jpeg', 'jpg', $ext);
        return $ext;
    }

    /**
     * @param $img_w
     * @param $img_h
     * @return string
     */
    private static function getOrientation($img_w, $img_h)
    {
        if ($img_w == $img_h) {
            return 'S';
        } elseif ($img_w > $img_h) {
            return 'L';
        } elseif ($img_w < $img_h) {
            return 'P';
        } else {
            return 'U';
        }
    }

    /**
     * @param $max_w
     * @param $max_h
     * @param $img_w
     * @param $img_h
     * @param int $exact
     * @return array
     */
    public static function resize($max_w, $max_h, $img_w, $img_h, $exact = 0)
    {
        $orientation = self::getOrientation($img_w, $img_h);
        $dst_w = $img_w;
        $dst_h = $img_h;
        if (!empty($exact)) {
            if (($orientation == 'P' && $exact == 'w') || ($orientation == 'L' && $max_h >= $max_h && $exact == 'h')) {
                $dst_h = $max_h;
                $factor = $img_h / $dst_h;
                $dst_w = floor($img_w / $factor);
            } elseif (($exact == 'w' && $orientation == 'L' && $max_w >= $max_w) || ($exact == 'h' && $orientation == 'P')) {
                $dst_w = $max_w;
                $factor = $img_w / $dst_w;
                $dst_h = floor($img_h / $factor);
            } else {
                $dst_w = $max_w;
                $factor = $img_w / $dst_w;
                $dst_h = floor($img_h / $factor);
            }
        } else {
            if (null != $max_w && $img_w > $max_w) {
                $dst_w = $max_w;
                $factor = $img_w / $dst_w;
                $dst_h = floor($img_h / $factor);
            } elseif (null != $max_h && $img_h > $max_h) {
                $dst_h = $max_h;
                $factor = $img_h / $dst_h;
                $dst_w = floor($img_w / $factor);
            }
        }

        return ['w' => $dst_w, 'h' => $dst_h];
    }

}
