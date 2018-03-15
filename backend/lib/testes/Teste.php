<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Teste
 * created in 5/Nov/2014
 * @author $luispinto@nestesitio.net
 */
namespace lib\testes;

class Teste
{
  public function __construct()
  {
  }

  public static function execute()
  {
    return 'teste on ' . __FILE__ . '<br />teste on ' . __DIR__ . '<br />';
  }

}
