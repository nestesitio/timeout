<?php

namespace lib\tools;


/**
 * Description of TinTools
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 25, 2015
 */
class TinTools
{
    //http://www.webdados.pt/2014/08/validacao-de-nif-portugues-em-php/

    /**
     * @param $nif
     * @return bool
     */
    public static function checkDigitPT($nif)
    {
        //Limpamos eventuais espaços a mais
        $nif = trim($nif);
        $nif = self::cleanTIN($nif);
        //Verificamos se é numérico e tem comprimento 9
        if (!is_numeric($nif) || strlen($nif)!=9) {
            return FALSE;
        }else{
            $nifSplit=str_split($nif);
            if(in_array($nifSplit[0], [1, 2, 5, 6, 8, 9])){
                $checkDigit=0;
                for($i=0; $i<8; $i++) {
                    $checkDigit += $nifSplit[$i]*(10-$i-1);
                }
                $checkDigit = 11-($checkDigit % 11);
                //Se der 10 então o dígito de controlo tem de ser 0 -
                if ($checkDigit >= 10) {
                    $checkDigit = 0;
                }
                //Comparamos com o último dígito
                if ($checkDigit==$nifSplit[8]) {
                    return $nif;
                }
            }
        }
        return false;
    }

    /**
     * @param $txt
     * @return mixed
     */
    public static function cleanTIN($txt)
    {
        return substr(preg_replace("/[^0-9]/", "", $txt), 0, 9);
    }

}
