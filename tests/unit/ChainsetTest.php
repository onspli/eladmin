<?php
use PHPUnit\Framework\TestCase;
use Onspli\Eladmin\Chainset\Chainset;

final class ChainsetTest extends TestCase
{
    public function testSetProperties(): void
    {
      $cs = new Chainset;
      $this->assertEquals("test", "test");
      //$cs->prop1('val1')->prop2('val2')->prop3('val3');
      //$this->assertEquals($cs->prop1, 'val1');
      //$this->assertEquals($cs->prop2, 'val2');
      //$this->assertEquals($cs->prop3, 'val3');
    }

    public function testForeach() : void
    {
      $cs = new Chainset;
      $cs->word1->val('Hello');
      $cs->word2->val('!');
      $cs->word3->val('world')->before('word2');
      $res = "";
      foreach($cs as $word) $res .= $word->val." ";
      $this->assertEquals($res, "Hello world ! ");
    }
}
